<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
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

    public function subjectsIndex(): void {
        $this->view('pages.subjects.index', ['subjects' => Subject::allWithCounts()]);
    }

    public function subjectsShow(string $slug): void {
        $subject = Subject::findBySlug($slug);

        if ($subject === null) {
            http_response_code(404);
            View::render('errors.404');
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

    public function subjectsResult(string $slug): void {
        $this->view('pages.subjects.result', ['slug' => $slug]);
    }

    public function testTypesIndex(): void {
        $this->view('pages.test-types.index');
    }

    public function testTypesShow(string $slug): void {
        $this->view('pages.test-types.show', ['slug' => $slug]);
    }

    public function testTypeSubject(string $testType, string $subject): void {
        $this->view('pages.subject-test', ['testType' => $testType, 'subject' => $subject]);
    }

    public function topicsShow(string $slug): void {
        $this->view('pages.topics.show', ['slug' => $slug]);
    }

    public function topicsResult(string $slug): void {
        $this->view('pages.topics.result', ['slug' => $slug]);
    }

    public function practice(string $slug): void {
        $this->view('pages.practice', ['slug' => $slug]);
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
}
