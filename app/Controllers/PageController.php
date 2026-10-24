<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\View;
use Skoolyst\Models\Mcq;
use Skoolyst\Models\MockTest;
use Skoolyst\Models\MockTestAttempt;
use Skoolyst\Models\PracticeAttempt;
use Skoolyst\Models\Subject;
use Skoolyst\Models\TestType;
use Skoolyst\Models\Topic;

class PageController extends Controller {
    public function sitemap(): void {
        $cacheFile = dirname(__DIR__, 2) . '/storage/cache/sitemap.xml';

        if (!is_file($cacheFile) || (time() - filemtime($cacheFile)) > 3600) {
            $xml = $this->buildSitemap();
            $dir = dirname($cacheFile);
            if (!is_dir($dir)) @mkdir($dir, 0775, true);
            @file_put_contents($cacheFile, $xml, LOCK_EX);
        } else {
            $xml = (string) file_get_contents($cacheFile);
        }

        header('Content-Type: application/xml; charset=utf-8');
        header('Cache-Control: public, max-age=3600');
        echo $xml;
    }

    private function buildSitemap(): string {
        $lastmod = static function (?string $date): ?string {
            if (!$date) return null;
            $ts = strtotime($date);
            return $ts ? date('Y-m-d', $ts) : null;
        };

        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('subjects.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('test-types.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('mock-tests.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('privacy-policy'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach (Subject::all() as $subject) {
            $urls[] = ['loc' => route('subjects.show', $subject['slug']), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => $lastmod($subject['updated_at'] ?? null)];
        }

        foreach (TestType::all() as $testType) {
            $urls[] = ['loc' => route('test-types.show', $testType['slug']), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => $lastmod($testType['updated_at'] ?? null)];

            // "MDCAT Biology MCQs"-style landing pages (test type + subject) are strong search targets.
            foreach (TestType::relatedSubjects((int) $testType['id']) as $subject) {
                if ((int) ($subject['mcq_count'] ?? 0) < 1) continue;
                $urls[] = ['loc' => route('test-types.subject', [$testType['slug'], $subject['slug']]), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => $lastmod($subject['updated_at'] ?? null)];
            }
        }

        // Only topics that actually have questions - empty topic pages are thin content.
        foreach (Topic::withQuestionsForSitemap() as $topic) {
            $date = $lastmod($topic['last_changed'] ?? null);
            $urls[] = ['loc' => route('topics.show', $topic['slug']), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => $date];
            $urls[] = ['loc' => route('practice.show', $topic['slug']), 'priority' => '0.6', 'changefreq' => 'weekly', 'lastmod' => $date];
        }

        foreach (MockTest::all() as $mockTest) {
            $urls[] = ['loc' => route('mock-tests.show', $mockTest['slug']), 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => $lastmod($mockTest['updated_at'] ?? null)];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            $xml .= '<url><loc>' . htmlspecialchars($url['loc'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
            if (!empty($url['lastmod'])) $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq><priority>' . $url['priority'] . '</priority></url>' . "\n";
        }
        return $xml . '</urlset>';
    }

    public function about(): void { $this->view('pages.about'); }

    public function home(): void {
        $subjects = Subject::allWithCounts();

        $this->view('pages.index', [
            'testTypes' => array_slice(TestType::allWithCounts(), 0, 3),
            'subjects' => array_slice($subjects, 0, 6),
            'popularSubjects' => array_slice($subjects, 0, 5),
            'stats' => [
                'mcqs' => Mcq::count(),
                'subjects' => Subject::count(),
                'topics' => Topic::count(),
                'testTypes' => TestType::count(),
            ],
        ]);
    }

    public function terms(): void {
        $this->view('pages.terms');
    }

    public function privacyPolicy(): void {
        $this->view('pages.privacy-policy');
    }

    public function search(): void {
        $term = trim((string) Request::input('q', ''));

        $results = [
            'subjects' => [],
            'topics' => [],
            'mcqs' => [],
        ];

        if ($term !== '') {
            $results['subjects'] = Subject::search($term, 10);
            $results['topics'] = Topic::search($term, 10);
            $results['mcqs'] = Mcq::search($term, 15);
        }

        $this->view('pages.search', [
            'term' => $term,
            'results' => $results,
            'totalCount' => count($results['subjects']) + count($results['topics']) + count($results['mcqs']),
        ]);
    }

    public function searchApi(): void {
        $term = trim((string) Request::input('q', ''));

        if ($term === '' || mb_strlen($term) < 2) {
            $this->json(['subjects' => [], 'topics' => [], 'mcqs' => []]);
        }

        $subjects = array_map(fn ($s) => [
            'type' => 'subject',
            'title' => $s['name'],
            'meta' => 'Subject',
            'icon' => $s['icon'] ?? 'bi-journal',
            'url' => route('subjects.show', $s['slug']),
        ], Subject::search($term, 4));

        $topics = array_map(fn ($t) => [
            'type' => 'topic',
            'title' => $t['name'],
            'meta' => $t['subject_name'],
            'icon' => $t['icon'] ?? 'bi-journal-text',
            'url' => route('topics.show', $t['slug']),
        ], Topic::search($term, 4));

        $mcqs = array_map(fn ($q) => [
            'type' => 'mcq',
            'title' => mb_strimwidth($q['question_text'], 0, 90, '...'),
            'meta' => $q['subject_name'] . ($q['topic_name'] ? ' · ' . $q['topic_name'] : ''),
            'icon' => 'bi-question-circle',
            'url' => $q['topic_slug'] ? route('practice.show', $q['topic_slug']) : route('subjects.show', $q['subject_slug']),
        ], Mcq::search($term, 6));

        $this->json(['subjects' => $subjects, 'topics' => $topics, 'mcqs' => $mcqs]);
    }

    public function subjectsIndex(): void {
        $this->view('pages.subjects.index', ['subjects' => Subject::allWithCounts()]);
    }

    public function subjectsShow(string $slug): void {
        $subject = Subject::findBySlug($slug);

        if ($subject === null) {
            $this->notFound();
            return;
        }

        $this->view('pages.subjects.show', [
            'subject' => $subject,
            'topics' => Topic::forSubject((int) $subject['id']),
            'difficulty' => Subject::difficultyBreakdown((int) $subject['id']),
            'relatedTestTypes' => Subject::relatedTestTypes((int) $subject['id']),
            'mcqCount' => Subject::mcqCount((int) $subject['id']),
            'topicCount' => Subject::topicCount((int) $subject['id']),
            'mockTestCount' => Subject::mockTestCount((int) $subject['id']),
        ]);
    }

    public function testTypesIndex(): void {
        $this->view('pages.test-types.index', ['testTypes' => TestType::allWithCounts()]);
    }

    public function testTypesShow(string $slug): void {
        $testType = TestType::findBySlug($slug);

        if ($testType === null) {
            $this->notFound();
            return;
        }

        $this->view('pages.test-types.show', [
            'testType' => $testType,
            'relatedSubjects' => TestType::relatedSubjects((int) $testType['id']),
            'popularTopics' => TestType::popularTopics((int) $testType['id']),
            'mcqCount' => TestType::mcqCount((int) $testType['id']),
            'topicCount' => TestType::topicCount((int) $testType['id']),
            'mockTestCount' => TestType::mockTestCount((int) $testType['id']),
        ]);
    }

    public function testTypeSubject(string $testTypeSlug, string $subjectSlug): void {
        $testType = TestType::findBySlug($testTypeSlug);
        $subject = Subject::findBySlug($subjectSlug);

        if ($testType === null || $subject === null || !TestType::isLinkedToSubject((int) $testType['id'], (int) $subject['id'])) {
            $this->notFound();
            return;
        }

        $this->view('pages.subject-test', [
            'testType' => $testType,
            'subject' => $subject,
            'topics' => Topic::forSubject((int) $subject['id']),
            'difficulty' => Subject::difficultyBreakdown((int) $subject['id']),
            'mcqCount' => Subject::mcqCount((int) $subject['id']),
        ]);
    }

    public function testTypeSubjectTopic(string $testTypeSlug, string $subjectSlug, string $topicSlug): void {
        $testType = TestType::findBySlug($testTypeSlug);
        $subject = Subject::findBySlug($subjectSlug);

        if ($testType === null || $subject === null || !TestType::isLinkedToSubject((int) $testType['id'], (int) $subject['id'])) {
            $this->notFound();
            return;
        }

        $topic = Topic::findBySlug((int) $subject['id'], $topicSlug);

        if ($topic === null) {
            $this->notFound();
            return;
        }

        $mcqs = Mcq::forTopic((int) $topic['id']);

        $this->view('pages.test-types.subject-topic', [
            'testType' => $testType,
            'subject' => $subject,
            'topic' => $topic,
            'mcqs' => $mcqs,
            'mcqOptions' => $this->optionsByMcqId($mcqs),
        ]);
    }

    public function topicsShow(string $slug): void {
        $topic = Topic::findBySlugGlobal($slug);

        if ($topic === null) {
            $this->notFound();
            return;
        }

        $mcqs = Mcq::forTopic((int) $topic['id']);

        $this->view('pages.topics.show', [
            'topic' => $topic,
            'mcqs' => $mcqs,
            'mcqOptions' => $this->optionsByMcqId($mcqs),
        ]);
    }

    public function topicsResult(string $slug): void {
        $topic = Topic::findBySlugGlobal($slug);

        if ($topic === null) {
            $this->notFound();
            return;
        }

        $attempt = null;
        $answers = [];
        $optionsByMcq = [];

        if (is_authenticated()) {
            $attempt = PracticeAttempt::mostRecentForTopic((int) auth_user()['id'], (int) $topic['id']);
            if ($attempt !== null) {
                $answers = PracticeAttempt::answers((int) $attempt['id']);
                $optionsByMcq = Mcq::getOptionsForMany(array_map(fn ($a) => (int) $a['mcq_id'], $answers));
            }
        }

        $this->view('pages.topics.result', [
            'topic' => $topic,
            'attempt' => $attempt,
            'answers' => $answers,
            'optionsByMcq' => $optionsByMcq,
        ]);
    }

    public function practice(string $slug): void {
        $topic = Topic::findBySlugGlobal($slug);

        if ($topic === null) {
            $this->notFound();
            return;
        }

        $mcqs = Mcq::forTopic((int) $topic['id']);

        $this->view('pages.practice', [
            'topic' => $topic,
            'mcqs' => $mcqs,
            'mcqOptions' => $this->optionsByMcqId($mcqs),
        ]);
    }

    public function practiceSubmit(string $slug): void {
        $topic = Topic::findBySlugGlobal($slug);

        if ($topic === null) {
            $this->json(['error' => 'Topic not found.'], 404);
        }

        if (!csrf_verify()) {
            $this->json(['error' => 'Your session expired. Please reload and try again.'], 419);
        }

        $mcqs = Mcq::forTopic((int) $topic['id']);
        if (empty($mcqs)) {
            $this->json(['error' => 'This topic has no questions.'], 422);
        }

        $answers = json_decode((string) Request::input('answers', '{}'), true);
        $answers = is_array($answers) ? $answers : [];

        $mcqIds = array_map(fn ($m) => (int) $m['id'], $mcqs);
        $optionsByMcq = Mcq::getOptionsForMany($mcqIds);

        $correctCount = 0;
        $answerRows = [];

        foreach ($mcqIds as $mcqId) {
            $selectedOptionId = isset($answers[$mcqId]) ? (int) $answers[$mcqId] : null;
            $isCorrect = false;

            if ($selectedOptionId !== null) {
                foreach ($optionsByMcq[$mcqId] ?? [] as $option) {
                    if ((int) $option['id'] === $selectedOptionId) {
                        $isCorrect = (int) $option['is_correct'] === 1;
                        break;
                    }
                }
            }

            if ($isCorrect) $correctCount++;
            $answerRows[] = ['mcq_id' => $mcqId, 'option_id' => $selectedOptionId, 'is_correct' => $isCorrect];
        }

        $total = count($mcqIds);
        $scorePercent = round($correctCount / $total * 100, 2);
        $userId = (int) auth_user()['id'];

        $attemptId = PracticeAttempt::record($userId, (int) $topic['subject_id'], (int) $topic['id'], $total, $correctCount, $scorePercent);

        foreach ($answerRows as $row) {
            PracticeAttempt::saveAnswer($attemptId, $row['mcq_id'], $row['option_id'], $row['is_correct']);
        }

        $this->json(['ok' => true, 'attemptId' => $attemptId]);
    }

    /**
     * @param array<int, array<string, mixed>> $mcqs
     * @return array<int, array<int, array<string, mixed>>>
     */
    private function optionsByMcqId(array $mcqs): array {
        return Mcq::getOptionsForMany(array_map(fn ($mcq) => (int) $mcq['id'], $mcqs));
    }

    public function mockTestsIndex(): void {
        $mockTests = MockTest::all();
        $featured = null;
        foreach ($mockTests as $mockTest) {
            if ((int) $mockTest['is_featured'] === 1) {
                $featured = $mockTest;
                break;
            }
        }

        $this->view('pages.mock-tests.index', [
            'mockTests' => $mockTests,
            'featured' => $featured,
        ]);
    }

    public function mockTestsShow(string $slug): void {
        $mockTest = MockTest::findBySlugWithTestType($slug);

        if ($mockTest === null) {
            $this->notFound();
            return;
        }

        $this->view('pages.mock-tests.show', [
            'mockTest' => $mockTest,
            'subjectBreakdown' => MockTest::subjectBreakdown((int) $mockTest['id']),
            'questionCount' => MockTest::linkedQuestionCount((int) $mockTest['id']),
            'attemptCount' => MockTest::attemptCount((int) $mockTest['id']),
        ]);
    }

    public function mockTestsTake(string $slug): void {
        $mockTest = MockTest::findBySlug($slug);

        if ($mockTest === null) {
            $this->notFound();
            return;
        }

        $questions = MockTest::questions((int) $mockTest['id']);

        $this->view('pages.mock-tests.take', [
            'mockTest' => $mockTest,
            'questions' => $questions,
            'options' => Mcq::getOptionsForMany(array_map(fn ($q) => (int) $q['id'], $questions)),
        ]);
    }

    public function mockTestsSubmit(string $slug): void {
        $mockTest = MockTest::findBySlug($slug);

        if ($mockTest === null) {
            $this->json(['error' => 'Mock test not found.'], 404);
        }

        if (!csrf_verify()) {
            $this->json(['error' => 'Your session expired. Please reload and try again.'], 419);
        }

        $questionIds = MockTest::getQuestionIds((int) $mockTest['id']);
        if (empty($questionIds)) {
            $this->json(['error' => 'This mock test has no questions yet.'], 422);
        }

        $answers = json_decode((string) Request::input('answers', '{}'), true);
        $marked = json_decode((string) Request::input('marked', '{}'), true);
        $timeTakenSeconds = max(0, (int) Request::input('time_taken_seconds', 0));

        $answers = is_array($answers) ? $answers : [];
        $marked = is_array($marked) ? $marked : [];

        $optionsByMcq = Mcq::getOptionsForMany($questionIds);
        $negativeMarking = (bool) $mockTest['negative_marking'];

        $correctCount = 0;
        $netScore = 0.0;
        $answerRows = [];

        foreach ($questionIds as $mcqId) {
            $selectedOptionId = isset($answers[$mcqId]) ? (int) $answers[$mcqId] : null;
            $isMarked = !empty($marked[$mcqId]);
            $isCorrect = false;

            if ($selectedOptionId !== null) {
                foreach ($optionsByMcq[$mcqId] ?? [] as $option) {
                    if ((int) $option['id'] === $selectedOptionId) {
                        $isCorrect = (int) $option['is_correct'] === 1;
                        break;
                    }
                }
            }

            if ($isCorrect) {
                $correctCount++;
                $netScore += 1;
            } elseif ($selectedOptionId !== null && $negativeMarking) {
                $netScore -= 0.25;
            }

            $answerRows[] = ['mcq_id' => $mcqId, 'option_id' => $selectedOptionId, 'is_correct' => $isCorrect, 'marked' => $isMarked];
        }

        $total = count($questionIds);
        $scorePercent = round(max(0, $netScore) / $total * 100, 2);
        $userId = (int) auth_user()['id'];

        $attemptId = MockTestAttempt::record($userId, (int) $mockTest['id'], $total, $correctCount, $scorePercent, $timeTakenSeconds);

        foreach ($answerRows as $row) {
            MockTestAttempt::saveAnswer($attemptId, $row['mcq_id'], $row['option_id'], $row['is_correct'], $row['marked']);
        }

        $this->json(['redirect' => route('mock-tests.result', $slug) . '?attempt=' . $attemptId]);
    }

    public function mockTestsResult(string $slug): void {
        $mockTest = MockTest::findBySlug($slug);

        if ($mockTest === null) {
            $this->notFound();
            return;
        }

        $attemptId = (int) Request::input('attempt', 0);
        $attempt = $attemptId > 0 ? MockTestAttempt::find($attemptId) : null;

        $userId = (int) (auth_user()['id'] ?? 0);
        if ($attempt !== null && ((int) $attempt['mock_test_id'] !== (int) $mockTest['id'] || (int) $attempt['user_id'] !== $userId)) {
            $attempt = null;
        }

        $answers = [];
        $optionsByMcq = [];
        if ($attempt !== null) {
            $answers = MockTestAttempt::answers($attemptId);
            $optionsByMcq = Mcq::getOptionsForMany(array_map(fn ($a) => (int) $a['mcq_id'], $answers));
        }

        $this->view('pages.mock-tests.result', [
            'mockTest' => $mockTest,
            'attempt' => $attempt,
            'answers' => $answers,
            'optionsByMcq' => $optionsByMcq,
        ]);
    }

    private function notFound(): void {
        http_response_code(404);
        View::render('errors.404');
    }
}
