<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\View;
use Skoolyst\Models\Mcq;
use Skoolyst\Models\Subject;
use Skoolyst\Models\TestType;
use Skoolyst\Models\Topic;

class PageController extends Controller {
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

        $this->view('pages.topics.result', ['topic' => $topic]);
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

    /**
     * @param array<int, array<string, mixed>> $mcqs
     * @return array<int, array<int, array<string, mixed>>>
     */
    private function optionsByMcqId(array $mcqs): array {
        $options = [];
        foreach ($mcqs as $mcq) {
            $options[$mcq['id']] = Mcq::getOptions((int) $mcq['id']);
        }
        return $options;
    }

    public function mockTestsIndex(): void {
        $this->view('pages.mock-tests.index');
    }

    public function mockTestsShow(string $slug): void {
        $this->view('pages.mock-tests.show', ['slug' => $slug]);
    }

    public function mockTestsTake(string $slug): void {
        $this->view('pages.mock-tests.take', ['slug' => $slug]);
    }

    public function mockTestsResult(string $slug): void {
        $this->view('pages.mock-tests.result', ['slug' => $slug]);
    }

    private function notFound(): void {
        http_response_code(404);
        View::render('errors.404');
    }
}
