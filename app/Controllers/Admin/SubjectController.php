<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Subject;

class SubjectController extends Controller {
    public function index(): void {
        $this->view('admin.subjects.index', [
            'subjects' => Subject::all(),
            'error' => flash('error'),
            'success' => flash('success'),
        ]);
    }

    public function create(): void {
        $this->view('admin.subjects.create', ['errors' => []]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.subjects.create', ['errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.subjects.create', ['errors' => $errors]);
            return;
        }

        Subject::create($data);
        flash('success', 'Subject created.');
        Response::redirect(route('dashboard.subjects'));
    }

    public function edit(string $id): void {
        $subject = Subject::find((int) $id);
        if ($subject === null) {
            Response::redirect(route('dashboard.subjects'));
        }

        $this->view('admin.subjects.edit', ['subject' => $subject, 'errors' => []]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $subject = Subject::find($id);
        if ($subject === null) {
            Response::redirect(route('dashboard.subjects'));
        }

        if (!csrf_verify()) {
            $this->view('admin.subjects.edit', ['subject' => $subject, 'errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest($id);

        if (!empty($errors)) {
            $this->view('admin.subjects.edit', ['subject' => array_merge($subject, $data), 'errors' => $errors]);
            return;
        }

        Subject::update($id, $data);
        flash('success', 'Subject updated.');
        Response::redirect(route('dashboard.subjects'));
    }

    public function destroy(string $id): void {
        $id = (int) $id;

        if (!csrf_verify()) {
            Response::redirect(route('dashboard.subjects'));
        }

        $topics = Subject::topicCount($id);
        $mcqs = Subject::mcqCount($id);

        if ($topics > 0 || $mcqs > 0) {
            flash('error', "Can't delete: this subject still has {$topics} topic(s) and {$mcqs} MCQ(s). Remove them first.");
            Response::redirect(route('dashboard.subjects'));
        }

        Subject::delete($id);
        flash('success', 'Subject deleted.');
        Response::redirect(route('dashboard.subjects'));
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
            'icon_bg' => trim((string) old('icon_bg')),
        ];

        if ($data['slug'] === '' && $data['name'] !== '') {
            $data['slug'] = slugify($data['name']);
        } else {
            $data['slug'] = slugify($data['slug']);
        }

        $errors = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if (empty($errors['slug']) && Subject::findBySlug($data['slug'], $currentId) !== null) {
            $errors['slug'] = 'This slug is already in use by another subject.';
        }

        return [$data, $errors];
    }
}
