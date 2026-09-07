<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Mcq;
use Skoolyst\Models\MockTest;
use Skoolyst\Models\TestType;

class MockTestController extends Controller {
    public function index(): void {
        $this->view('admin.mock-tests.index', [
            'mockTests' => MockTest::all(),
            'error' => flash('error'),
            'success' => flash('success'),
        ]);
    }

    public function create(): void {
        $this->view('admin.mock-tests.create', [
            'testTypes' => TestType::all(),
            'mcqs' => Mcq::all(),
            'selectedMcqIds' => [],
            'errors' => [],
        ]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.mock-tests.create', [
                'testTypes' => TestType::all(),
                'mcqs' => Mcq::all(),
                'selectedMcqIds' => [],
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $mcqIds, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.mock-tests.create', [
                'testTypes' => TestType::all(),
                'mcqs' => Mcq::all(),
                'selectedMcqIds' => $mcqIds,
                'errors' => $errors,
            ]);
            return;
        }

        $id = MockTest::create($data);
        MockTest::saveQuestions($id, $mcqIds);

        flash('success', 'Mock test created.');
        Response::redirect(route('dashboard.mock-tests'));
    }

    public function edit(string $id): void {
        $id = (int) $id;
        $mockTest = MockTest::find($id);
        if ($mockTest === null) {
            Response::redirect(route('dashboard.mock-tests'));
        }

        $this->view('admin.mock-tests.edit', [
            'mockTest' => $mockTest,
            'testTypes' => TestType::all(),
            'mcqs' => Mcq::all(),
            'selectedMcqIds' => MockTest::getQuestionIds($id),
            'errors' => [],
        ]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $mockTest = MockTest::find($id);
        if ($mockTest === null) {
            Response::redirect(route('dashboard.mock-tests'));
        }

        if (!csrf_verify()) {
            $this->view('admin.mock-tests.edit', [
                'mockTest' => $mockTest,
                'testTypes' => TestType::all(),
                'mcqs' => Mcq::all(),
                'selectedMcqIds' => MockTest::getQuestionIds($id),
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $mcqIds, $errors] = $this->validateRequest($id);

        if (!empty($errors)) {
            $this->view('admin.mock-tests.edit', [
                'mockTest' => array_merge($mockTest, $data),
                'testTypes' => TestType::all(),
                'mcqs' => Mcq::all(),
                'selectedMcqIds' => $mcqIds,
                'errors' => $errors,
            ]);
            return;
        }

        MockTest::update($id, $data);
        MockTest::saveQuestions($id, $mcqIds);

        flash('success', 'Mock test updated.');
        Response::redirect(route('dashboard.mock-tests'));
    }

    public function destroy(string $id): void {
        $id = (int) $id;

        if (!csrf_verify()) {
            Response::redirect(route('dashboard.mock-tests'));
        }

        $attempts = MockTest::attemptCount($id);

        if ($attempts > 0) {
            flash('error', "Can't delete: {$attempts} student attempt(s) exist for this mock test.");
            Response::redirect(route('dashboard.mock-tests'));
        }

        MockTest::delete($id);
        flash('success', 'Mock test deleted.');
        Response::redirect(route('dashboard.mock-tests'));
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<int, int>, 2: array<string, string>}
     */
    private function validateRequest(?int $currentId = null): array {
        $data = [
            'test_type_id' => (int) old('test_type_id'),
            'title' => trim((string) old('title')),
            'slug' => trim((string) old('slug')),
            'description' => trim((string) old('description')),
            'total_questions' => (int) old('total_questions'),
            'duration_minutes' => (int) old('duration_minutes'),
            'difficulty' => (string) old('difficulty', 'medium'),
            'passing_score_percent' => (int) old('passing_score_percent', '50'),
            'negative_marking' => old('negative_marking') === '1',
            'is_featured' => old('is_featured') === '1',
        ];

        $data['slug'] = slugify($data['slug'] !== '' ? $data['slug'] : $data['title']);

        $mcqIds = array_map('intval', (array) old('mcq_ids', []));

        $errors = Validator::make($data, [
            'title' => 'required',
            'slug' => 'required',
        ]);

        if ($data['test_type_id'] <= 0 || TestType::find($data['test_type_id']) === null) {
            $errors['test_type_id'] = 'Please choose a valid test type.';
        }

        if (!in_array($data['difficulty'], ['easy', 'medium', 'hard'], true)) {
            $errors['difficulty'] = 'Please choose a valid difficulty.';
        }

        if ($data['total_questions'] < 0) {
            $errors['total_questions'] = 'Must be zero or more.';
        }

        if ($data['duration_minutes'] < 0) {
            $errors['duration_minutes'] = 'Must be zero or more.';
        }

        if ($data['passing_score_percent'] < 0 || $data['passing_score_percent'] > 100) {
            $errors['passing_score_percent'] = 'Must be between 0 and 100.';
        }

        if (empty($errors['slug']) && MockTest::findBySlug($data['slug'], $currentId) !== null) {
            $errors['slug'] = 'This slug is already in use by another mock test.';
        }

        return [$data, $mcqIds, $errors];
    }
}
