<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Database;
use Skoolyst\Core\Response;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Mcq;
use Skoolyst\Models\MockTest;
use Skoolyst\Models\Subject;
use Skoolyst\Models\Topic;
use Skoolyst\Models\User;

class DashboardController extends Controller {
    public function index(): void {
        $this->view('admin.dashboard', [
            'stats' => [
                'mcqs' => Mcq::count(),
                'subjects' => Subject::count(),
                'topics' => Topic::count(),
                'mockTests' => MockTest::count(),
            ],
            'recentMcqs' => Mcq::all(6),
            'recentMockTests' => array_slice(MockTest::all(), 0, 4),
        ]);
    }

    public function account(): void {
        $this->view('admin.account', ['user' => User::findById(auth_user()['id']), 'errors' => []]);
    }

    public function updateAccount(): void {
        $user = User::findById(auth_user()['id']);

        if (!csrf_verify()) {
            $this->view('admin.account', ['user' => $user, 'errors' => ['_general' => 'Your session expired. Please try again.']]);
            return;
        }

        $data = [
            'current_password' => (string) old('current_password'),
            'password' => (string) old('password'),
            'password_confirmation' => (string) old('password_confirmation'),
        ];

        $errors = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (empty($errors) && !password_verify($data['current_password'], $user['password'])) {
            $errors['current_password'] = 'The current password is incorrect.';
        }

        if (!empty($errors)) {
            $this->view('admin.account', ['user' => $user, 'errors' => $errors]);
            return;
        }

        User::updatePassword($user['id'], password_hash($data['password'], PASSWORD_DEFAULT));
        $this->view('admin.account', [
            'user' => $user,
            'errors' => [],
            'success' => 'Your password has been updated.',
        ]);
    }

    public function settings(): void {
        $this->view('admin.settings', [
            'errors' => [],
            'subjectsWithTopics' => $this->subjectsWithTopics(),
        ]);
    }

    /**
     * Streams a topic's MCQs as a reusable JSON file (no database IDs), suitable for
     * handing to an AI to generate more unique questions in the same shape.
     */
    public function exportMcqTopic(string $id): void {
        $topic = Topic::find((int) $id);
        if ($topic === null) {
            Response::redirect(route('dashboard.settings'));
            return;
        }
        $subject = Subject::find((int) $topic['subject_id']);

        $mcqs = array_map(function (array $mcq) {
            $options = Mcq::getOptions((int) $mcq['id']);
            return [
                'question' => $mcq['question_text'],
                'difficulty' => $mcq['difficulty'],
                'explanation' => $mcq['explanation'],
                'options' => array_map(fn (array $o) => [
                    'text' => $o['option_text'],
                    'is_correct' => (bool) ((int) $o['is_correct']),
                ], $options),
            ];
        }, Mcq::forTopic((int) $topic['id']));

        $payload = [
            'subject' => $subject['name'] ?? '',
            'topic' => $topic['name'],
            'mcqs' => $mcqs,
        ];

        $filename = 'mcqs-' . $topic['slug'] . '-' . date('Ymd-His') . '.json';
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Validates an uploaded/pasted MCQ JSON batch against the selected topic and shows
     * a preview (new / duplicate / invalid counts) without writing to the database yet.
     */
    public function importMcqPreview(): void {
        $topicId = (int) old('topic_id');
        $topic = Topic::find($topicId);

        if ($topic === null) {
            Response::redirect(route('dashboard.settings'));
            return;
        }

        if (!csrf_verify()) {
            $this->view('admin.settings', [
                'errors' => ['_general' => 'Your session expired. Please try again.'],
                'subjectsWithTopics' => $this->subjectsWithTopics(),
            ]);
            return;
        }

        $result = $this->analyzeImportPayload($topicId, $this->readImportPayload());

        $this->view('admin.settings', [
            'errors' => [],
            'subjectsWithTopics' => $this->subjectsWithTopics(),
            'openTopicId' => $topicId,
            'importPreview' => ['topic' => $topic, 'result' => $result],
        ]);
    }

    /**
     * Re-validates the previewed "new" MCQs (protects against tampering / stale duplicates
     * from a double submit) and inserts them inside a single transaction.
     */
    public function importMcqConfirm(): void {
        $topicId = (int) old('topic_id');
        $topic = Topic::find($topicId);

        if ($topic === null) {
            Response::redirect(route('dashboard.settings'));
            return;
        }

        if (!csrf_verify()) {
            $this->view('admin.settings', [
                'errors' => ['_general' => 'Your session expired. Please try again.'],
                'subjectsWithTopics' => $this->subjectsWithTopics(),
            ]);
            return;
        }

        $result = $this->analyzeImportPayload($topicId, (string) old('new_mcqs_json'));

        $inserted = 0;
        $failed = false;

        if (!empty($result['new'])) {
            $pdo = Database::connection();
            try {
                $pdo->beginTransaction();
                foreach ($result['new'] as $mcq) {
                    $options = [];
                    foreach ($mcq['options'] as $i => $opt) {
                        $options[] = ['label' => chr(65 + $i), 'text' => $opt['text'], 'correct' => $opt['is_correct']];
                    }
                    Mcq::createWithOptions((int) $topic['subject_id'], (int) $topic['id'], $mcq['question'], $mcq['explanation'], $mcq['difficulty'], $options);
                    $inserted++;
                }
                $pdo->commit();
            } catch (\Throwable $e) {
                $pdo->rollBack();
                $inserted = 0;
                $failed = true;
            }
        }

        $this->view('admin.settings', [
            'errors' => [],
            'subjectsWithTopics' => $this->subjectsWithTopics(),
            'openTopicId' => $topicId,
            'importSummary' => [
                'topic' => $topic,
                'totalSubmitted' => $result['totalSubmitted'],
                'newCount' => count($result['new']),
                'duplicates' => count($result['duplicates']),
                'invalid' => count($result['invalid']),
                'inserted' => $inserted,
                'failed' => $failed,
            ],
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function subjectsWithTopics(): array {
        return array_map(function (array $subject) {
            $subject['topics'] = Topic::forSubject((int) $subject['id']);
            return $subject;
        }, Subject::allWithCounts());
    }

    private function readImportPayload(): string {
        if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK && $_FILES['import_file']['size'] > 0) {
            $content = file_get_contents($_FILES['import_file']['tmp_name']);
            if ($content !== false && trim($content) !== '') {
                return $content;
            }
        }
        return (string) old('import_json');
    }

    /**
     * Parses + validates a raw MCQ JSON payload against a topic's existing questions.
     * Returns totalSubmitted plus 'new' (ready to insert), 'duplicates' (skipped, with a
     * short preview of each), and 'invalid' (with a reason) buckets. Never touches the DB.
     *
     * @return array{totalSubmitted: int, new: array<int, array<string, mixed>>, duplicates: array<int, string>, invalid: array<int, array<string, mixed>>, parseError: ?string}
     */
    private function analyzeImportPayload(int $topicId, string $raw): array {
        $result = ['totalSubmitted' => 0, 'new' => [], 'duplicates' => [], 'invalid' => [], 'parseError' => null];

        $raw = trim($raw);
        if ($raw === '') {
            $result['parseError'] = 'No JSON was provided. Upload a file or paste JSON to import.';
            return $result;
        }

        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            $result['parseError'] = 'The provided JSON is not valid.';
            return $result;
        }

        $mcqsRaw = $decoded['mcqs'] ?? (array_is_list($decoded) ? $decoded : null);
        if (!is_array($mcqsRaw)) {
            $result['parseError'] = 'The JSON must contain an "mcqs" array.';
            return $result;
        }

        $result['totalSubmitted'] = count($mcqsRaw);

        $existing = Mcq::normalizedQuestionTextsForTopic($topicId);
        $seenInBatch = [];

        foreach ($mcqsRaw as $index => $entry) {
            $position = $index + 1;

            if (!is_array($entry)) {
                $result['invalid'][] = ['position' => $position, 'reason' => 'Entry is not a valid object.', 'question' => ''];
                continue;
            }

            $question = trim((string) ($entry['question'] ?? ''));
            $difficulty = strtolower(trim((string) ($entry['difficulty'] ?? '')));
            $explanation = trim((string) ($entry['explanation'] ?? ''));
            $optionsRaw = $entry['options'] ?? null;
            $preview = mb_strimwidth($question, 0, 80, '...');

            if ($question === '') {
                $result['invalid'][] = ['position' => $position, 'reason' => 'Missing question text.', 'question' => $preview];
                continue;
            }

            if (!in_array($difficulty, ['easy', 'medium', 'hard'], true)) {
                $result['invalid'][] = ['position' => $position, 'reason' => 'Missing or invalid difficulty (must be easy, medium, or hard).', 'question' => $preview];
                continue;
            }

            if (!is_array($optionsRaw) || count($optionsRaw) < 2) {
                $result['invalid'][] = ['position' => $position, 'reason' => 'At least 2 options are required.', 'question' => $preview];
                continue;
            }

            $options = [];
            $correctCount = 0;
            $optionsValid = true;

            foreach ($optionsRaw as $opt) {
                if (!is_array($opt) || trim((string) ($opt['text'] ?? '')) === '') {
                    $optionsValid = false;
                    break;
                }
                $isCorrect = (bool) ($opt['is_correct'] ?? false);
                if ($isCorrect) {
                    $correctCount++;
                }
                $options[] = ['text' => trim((string) $opt['text']), 'is_correct' => $isCorrect];
            }

            if (!$optionsValid) {
                $result['invalid'][] = ['position' => $position, 'reason' => 'One or more options are missing text.', 'question' => $preview];
                continue;
            }

            if ($correctCount !== 1) {
                $result['invalid'][] = ['position' => $position, 'reason' => 'Exactly one option must be marked correct (found ' . $correctCount . ').', 'question' => $preview];
                continue;
            }

            $normalized = Mcq::normalizeQuestionText($question);
            if (isset($existing[$normalized]) || isset($seenInBatch[$normalized])) {
                $result['duplicates'][] = $preview;
                continue;
            }

            $seenInBatch[$normalized] = true;
            $result['new'][] = [
                'question' => $question,
                'difficulty' => $difficulty,
                'explanation' => $explanation,
                'options' => $options,
            ];
        }

        return $result;
    }
}
