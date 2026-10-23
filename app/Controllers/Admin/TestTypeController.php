<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Database;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Subject;
use Skoolyst\Models\TestType;
use Skoolyst\Services\EmailService;

class TestTypeController extends Controller {
    public function index(): void {
        $this->view('admin.test-types.index', [
            'testTypes' => TestType::all(),
            'error' => flash('error'),
            'success' => flash('success'),
        ]);
    }

    public function create(): void {
        $this->view('admin.test-types.create', [
            'subjects' => Subject::all(),
            'selectedSubjectIds' => [],
            'errors' => [],
        ]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.test-types.create', [
                'subjects' => Subject::all(),
                'selectedSubjectIds' => [],
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.test-types.create', [
                'subjects' => Subject::all(),
                'selectedSubjectIds' => $data['subject_ids'],
                'errors' => $errors,
            ]);
            return;
        }

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $testTypeId = TestType::create($data);
            TestType::syncSubjects($testTypeId, $data['subject_ids']);
            $pdo->commit();
        } catch (\Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $exception;
        }

        EmailService::notifyAdmin(
            'Test type created: ' . $data['name'],
            "A new test type was added.\n\nName: {$data['name']}\nSlug: {$data['slug']}"
        );

        flash('success', 'Test type created.');
        Response::redirect(route('dashboard.test-types'));
    }

    public function edit(string $id): void {
        $testType = TestType::find((int) $id);
        if ($testType === null) {
            Response::redirect(route('dashboard.test-types'));
        }

        $this->view('admin.test-types.edit', [
            'testType' => $testType,
            'subjects' => Subject::all(),
            'selectedSubjectIds' => TestType::subjectIds((int) $id),
            'errors' => [],
        ]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $testType = TestType::find($id);
        if ($testType === null) {
            Response::redirect(route('dashboard.test-types'));
        }

        if (!csrf_verify()) {
            $this->view('admin.test-types.edit', [
                'testType' => $testType,
                'subjects' => Subject::all(),
                'selectedSubjectIds' => TestType::subjectIds($id),
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $errors] = $this->validateRequest($id);

        if (!empty($errors)) {
            $this->view('admin.test-types.edit', [
                'testType' => array_merge($testType, $data),
                'subjects' => Subject::all(),
                'selectedSubjectIds' => $data['subject_ids'],
                'errors' => $errors,
            ]);
            return;
        }

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            TestType::update($id, $data);
            TestType::syncSubjects($id, $data['subject_ids']);
            $pdo->commit();
        } catch (\Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $exception;
        }

        flash('success', 'Test type updated.');
        Response::redirect(route('dashboard.test-types'));
    }

    public function destroy(string $id): void {
        $id = (int) $id;

        if (!csrf_verify()) {
            Response::redirect(route('dashboard.test-types'));
        }

        $mockTests = TestType::mockTestCount($id);

        if ($mockTests > 0) {
            flash('error', "Can't delete: this test type still has {$mockTests} mock test(s). Remove them first.");
            Response::redirect(route('dashboard.test-types'));
        }

        TestType::delete($id);
        flash('success', 'Test type deleted.');
        Response::redirect(route('dashboard.test-types'));
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<string, string>}
     */
    private function validateRequest(?int $currentId = null): array {
        $data = [
            'name' => trim((string) old('name')),
            'slug' => trim((string) old('slug')),
            'description' => trim((string) old('description')),
            'icon' => trim((string) old('icon')),
            'badge_class' => trim((string) old('badge_class')),
        ];
        $subjectIds = $_POST['subject_ids'] ?? [];
        $data['subject_ids'] = [];

        $data['slug'] = slugify($data['slug'] !== '' ? $data['slug'] : $data['name']);

        $errors = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if (!is_array($subjectIds)) {
            $errors['subject_ids'] = 'Select valid subjects.';
        } else {
            foreach ($subjectIds as $subjectId) {
                if ((!is_string($subjectId) && !is_int($subjectId)) || filter_var($subjectId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
                    $errors['subject_ids'] = 'Select valid subjects.';
                    continue;
                }

                $data['subject_ids'][] = (int) $subjectId;
            }

            $data['subject_ids'] = array_values(array_unique($data['subject_ids']));
            $availableSubjectIds = array_map('intval', array_column(Subject::all(), 'id'));
            if (array_diff($data['subject_ids'], $availableSubjectIds) !== []) {
                $errors['subject_ids'] = 'One or more selected subjects no longer exist.';
            }
        }

        if (empty($errors['slug']) && TestType::findBySlug($data['slug'], $currentId) !== null) {
            $errors['slug'] = 'This slug is already in use by another test type.';
        }

        return [$data, $errors];
    }
}
