<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;

class PageController extends Controller {
    public function home(): void {
        $this->view('pages.index');
    }

    public function subjectsIndex(): void {
        $this->view('pages.subjects.index');
    }

    public function subjectsShow(string $slug): void {
        $this->view('pages.subjects.show', ['slug' => $slug]);
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
