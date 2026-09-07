<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\TestType;

class TestTypeController extends Controller {
    public function index(): void {
        $this->view('admin.test-types.index', [
            'testTypes' => TestType::all(),
            'error' => flash('error'),
            'success' => flash('success'),
        ]);
    }

    public function create(): void {
        $this->view('admin.test-types.create', ['errors' => []]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.test-types.create', ['errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.test-types.create', ['errors' => $errors]);
            return;
        }

        TestType::create($data);
        flash('success', 'Test type created.');
        Response::redirect(route('dashboard.test-types'));
    }

    public function edit(string $id): void {
        $testType = TestType::find((int) $id);
        if ($testType === null) {
            Response::redirect(route('dashboard.test-types'));
        }

        $this->view('admin.test-types.edit', ['testType' => $testType, 'errors' => []]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $testType = TestType::find($id);
        if ($testType === null) {
            Response::redirect(route('dashboard.test-types'));
        }

        if (!csrf_verify()) {
            $this->view('admin.test-types.edit', ['testType' => $testType, 'errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest($id);

        if (!empty($errors)) {
            $this->view('admin.test-types.edit', ['testType' => array_merge($testType, $data), 'errors' => $errors]);
            return;
        }

        TestType::update($id, $data);
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
     * @return array{0: array<string, string>, 1: array<string, string>}
     */
    private function validateRequest(?int $currentId = null): array {
        $data = [
            'name' => trim((string) old('name')),
            'slug' => trim((string) old('slug')),
            'description' => trim((string) old('description')),
            'icon' => trim((string) old('icon')),
            'badge_class' => trim((string) old('badge_class')),
        ];

        $data['slug'] = slugify($data['slug'] !== '' ? $data['slug'] : $data['name']);

        $errors = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if (empty($errors['slug']) && TestType::findBySlug($data['slug'], $currentId) !== null) {
            $errors['slug'] = 'This slug is already in use by another test type.';
        }

        return [$data, $errors];
    }
}
