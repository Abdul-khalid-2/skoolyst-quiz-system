<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Mcq;
use Skoolyst\Models\Subject;
use Skoolyst\Models\Topic;
use Skoolyst\Services\EmailService;

class McqController extends Controller {
    private const PER_PAGE_OPTIONS = [30, 50];

    public function index(): void {
        $perPage = (int) ($_GET['per_page'] ?? self::PER_PAGE_OPTIONS[0]);
        if (!in_array($perPage, self::PER_PAGE_OPTIONS, true)) {
            $perPage = self::PER_PAGE_OPTIONS[0];
        }

        $topicParam = (string) ($_GET['topic_id'] ?? '');
        $filters = [
            'q' => mb_substr(trim((string) ($_GET['q'] ?? '')), 0, 100),
            'subject_id' => max(0, (int) ($_GET['subject_id'] ?? 0)),
            'topic_id' => $topicParam === 'none' ? 'none' : max(0, (int) $topicParam),
            'difficulty' => in_array($_GET['difficulty'] ?? '', ['easy', 'medium', 'hard'], true) ? (string) $_GET['difficulty'] : '',
        ];

        $result = Mcq::paginate($filters, max(1, (int) ($_GET['page'] ?? 1)), $perPage);

        // Query string that recreates the current filters (without the page number) for pagination links.
        $query = array_filter([
            'q' => $filters['q'],
            'subject_id' => $filters['subject_id'] ?: null,
            'topic_id' => $filters['topic_id'] ?: null,
            'difficulty' => $filters['difficulty'],
            'per_page' => $perPage !== self::PER_PAGE_OPTIONS[0] ? $perPage : null,
        ], static fn($v) => $v !== null && $v !== '');

        $this->view('admin.mcqs.index', [
            'mcqs' => $result['items'],
            'pagination' => $result,
            'filters' => $filters,
            'query' => $query,
            'hasFilters' => (bool) array_diff_key($query, ['per_page' => 1]),
            'perPageOptions' => self::PER_PAGE_OPTIONS,
            'subjects' => Subject::all(),
            'topicsBySubject' => Topic::allGroupedBySubject(),
        ]);
    }

    public function create(): void {
        $this->view('admin.mcqs.create', [
            'subjects' => Subject::all(),
            'topicsBySubject' => Topic::allGroupedBySubject(),
            'errors' => [],
        ]);
    }

    public function store(): void {
        if (!csrf_verify()) {
            $this->view('admin.mcqs.create', [
                'subjects' => Subject::all(),
                'topicsBySubject' => Topic::allGroupedBySubject(),
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $options, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.mcqs.create', [
                'subjects' => Subject::all(),
                'topicsBySubject' => Topic::allGroupedBySubject(),
                'errors' => $errors,
            ]);
            return;
        }

        $id = Mcq::create($data);
        Mcq::saveOptions($id, $options);

        EmailService::notifyAdmin(
            'MCQ added',
            "A new MCQ was added.\n\nQuestion: " . mb_strimwidth($data['question_text'], 0, 200, '...') . "\nDifficulty: {$data['difficulty']}"
        );

        Response::redirect(route('dashboard.mcqs'));
    }

    public function edit(string $id): void {
        $id = (int) $id;
        $mcq = Mcq::find($id);
        if ($mcq === null) {
            Response::redirect(route('dashboard.mcqs'));
        }

        $this->view('admin.mcqs.edit', [
            'mcq' => $mcq,
            'options' => Mcq::getOptions($id),
            'subjects' => Subject::all(),
            'topicsBySubject' => Topic::allGroupedBySubject(),
            'errors' => [],
        ]);
    }

    public function update(string $id): void {
        $id = (int) $id;
        $mcq = Mcq::find($id);
        if ($mcq === null) {
            Response::redirect(route('dashboard.mcqs'));
        }

        if (!csrf_verify()) {
            $this->view('admin.mcqs.edit', [
                'mcq' => $mcq,
                'options' => Mcq::getOptions($id),
                'subjects' => Subject::all(),
                'topicsBySubject' => Topic::allGroupedBySubject(),
                'errors' => ['_general' => 'Your session expired. Please try again.'],
            ]);
            return;
        }

        [$data, $options, $errors] = $this->validateRequest();

        if (!empty($errors)) {
            $this->view('admin.mcqs.edit', [
                'mcq' => array_merge($mcq, $data),
                'options' => Mcq::getOptions($id),
                'subjects' => Subject::all(),
                'topicsBySubject' => Topic::allGroupedBySubject(),
                'errors' => $errors,
            ]);
            return;
        }

        Mcq::update($id, $data);
        Mcq::saveOptions($id, $options);

        Response::redirect(safe_next_url(isset($_POST['return']) ? (string) $_POST['return'] : null) ?? route('dashboard.mcqs'));
    }

    public function destroy(string $id): void {
        if (csrf_verify()) {
            Mcq::delete((int) $id);
        }

        Response::redirect(safe_next_url(isset($_POST['return']) ? (string) $_POST['return'] : null) ?? route('dashboard.mcqs'));
    }

    /**
     * @return array{0: array<string, mixed>, 1: array<int, array{label: string, text: string, correct: bool}>, 2: array<string, string>}
     */
    private function validateRequest(): array {
        $data = [
            'subject_id' => (int) old('subject_id'),
            'topic_id' => (int) old('topic_id'),
            'question_text' => trim((string) old('question_text')),
            'explanation' => trim((string) old('explanation')),
            'difficulty' => (string) old('difficulty'),
        ];

        $errors = Validator::make($data, [
            'question_text' => 'required',
            'difficulty' => 'required',
        ]);

        if (!in_array($data['difficulty'], ['easy', 'medium', 'hard'], true)) {
            $errors['difficulty'] = 'Please choose a valid difficulty.';
        }

        if ($data['subject_id'] <= 0 || Subject::find($data['subject_id']) === null) {
            $errors['subject_id'] = 'Please choose a valid subject.';
        }

        if ($data['topic_id'] > 0) {
            $topic = Topic::find($data['topic_id']);
            if ($topic === null || (int) $topic['subject_id'] !== $data['subject_id']) {
                $errors['topic_id'] = 'The selected topic does not belong to the selected subject.';
            }
        }

        $options = [];
        $hasCorrect = false;
        $correctLabel = (string) old('correct_option');

        foreach (['A', 'B', 'C', 'D'] as $label) {
            $text = trim((string) old('option_' . strtolower($label)));
            if ($text === '') {
                $errors['option_' . strtolower($label)] = 'This option is required.';
            }

            $isCorrect = $correctLabel === $label;
            if ($isCorrect) {
                $hasCorrect = true;
            }

            $options[] = ['label' => $label, 'text' => $text, 'correct' => $isCorrect];
        }

        if (!$hasCorrect) {
            $errors['correct_option'] = 'Please mark one option as correct.';
        }

        return [$data, $options, $errors];
    }
}
