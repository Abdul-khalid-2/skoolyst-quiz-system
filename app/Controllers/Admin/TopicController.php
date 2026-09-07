<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Subject;
use Skoolyst\Models\Topic;

class TopicController extends Controller {
    public function index(): void {
        $this->view('admin.topics.index', [
            'topics' => Topic::all(),
            'success' => flash('success'),
        ]);
    }

    public function create(): void {
        $this->view('admin.topics.create', ['subjects' => Subject::all(), 'errors' => []]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.topics.create', ['subjects' => Subject::all(), 'errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.topics.create', ['subjects' => Subject::all(), 'errors' => $errors]);
            return;
        }

        Topic::create($data);
        flash('success', 'Topic created.');
        Response::redirect(route('dashboard.topics'));
    }

    public function edit(string $id): void {
        $topic = Topic::find((int) $id);
        if ($topic === null) {
            Response::redirect(route('dashboard.topics'));
        }

        $this->view('admin.topics.edit', ['topic' => $topic, 'subjects' => Subject::all(), 'errors' => []]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $topic = Topic::find($id);
        if ($topic === null) {
            Response::redirect(route('dashboard.topics'));
        }

        if (!csrf_verify()) {
            $this->view('admin.topics.edit', ['topic' => $topic, 'subjects' => Subject::all(), 'errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        [$data, $errors] = $this->validateRequest($id);

        if (!empty($errors)) {
            $this->view('admin.topics.edit', ['topic' => array_merge($topic, $data), 'subjects' => Subject::all(), 'errors' => $errors]);
            return;
        }

        Topic::update($id, $data);
        flash('success', 'Topic updated.');
        Response::redirect(route('dashboard.topics'));
    }

    public function destroy(string $id): void {
        if (csrf_verify()) {
            Topic::delete((int) $id);
            flash('success', 'Topic deleted.');
        }

        Response::redirect(route('dashboard.topics'));
    }

    /**
     * @return array{0: array<string, string>, 1: array<string, string>}
     */
    private function validateRequest(?int $currentId = null): array {
        $data = [
            'subject_id' => (int) old('subject_id'),
            'name' => trim((string) old('name')),
            'slug' => trim((string) old('slug')),
            'description' => trim((string) old('description')),
            'icon' => trim((string) old('icon')),
            'difficulty' => (string) old('difficulty', 'medium'),
        ];

        $data['slug'] = slugify($data['slug'] !== '' ? $data['slug'] : $data['name']);

        $errors = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($data['subject_id'] <= 0 || Subject::find($data['subject_id']) === null) {
            $errors['subject_id'] = 'Please choose a valid subject.';
        }

        if (!in_array($data['difficulty'], ['easy', 'medium', 'hard'], true)) {
            $errors['difficulty'] = 'Please choose a valid difficulty.';
        }

        if (empty($errors['slug']) && empty($errors['subject_id'])
            && Topic::findBySlug($data['subject_id'], $data['slug'], $currentId) !== null) {
            $errors['slug'] = 'This subject already has a topic with this slug.';
        }

        return [$data, $errors];
    }
}
