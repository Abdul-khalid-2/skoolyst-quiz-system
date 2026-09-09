@extends('layouts.dashboard')

@section('page_title', 'Settings')

@section('content')
@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif
@if(isset($success))
<div class="alert alert-success py-2 small">{{ $success }}</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="sk-info-box">
            <h6><i class="bi bi-arrow-down-up me-1"></i>MCQ Import / Export</h6>
            <p class="text-secondary-custom small mb-3">Export a topic's MCQs as reusable JSON, hand it to an AI to generate more unique questions in the same shape, then import the new ones back in. Duplicate questions (matched by normalized text) are detected automatically and skipped.</p>

            <div class="accordion" id="mcqImportExportAccordion">
                @foreach($subjectsWithTopics as $subject)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subject-<?= (int) $subject['id'] ?>">
                            {{ $subject['name'] }}
                            <span class="sk-badge sk-badge-light ms-2">{{ $subject['topic_count'] }} topics</span>
                        </button>
                    </h2>
                    <div id="subject-<?= (int) $subject['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#mcqImportExportAccordion">
                        <div class="accordion-body">
                            @if(count($subject['topics']) === 0)
                            <p class="text-secondary-custom small mb-0">No topics yet.</p>
                            @endif

                            @foreach($subject['topics'] as $topic)
                            <div class="border rounded p-3 mb-2">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div>
                                        <strong>{{ $topic['name'] }}</strong>
                                        <span class="sk-badge sk-badge-light ms-1">{{ $topic['mcq_count'] }} MCQs</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-sk-outline btn-sm-sk" href="{{ route('dashboard.settings.mcqs.export', $topic['id']) }}"><i class="bi bi-download me-1"></i>Export MCQs</a>
                                        <button class="btn btn-sk-outline btn-sm-sk" type="button" data-bs-toggle="collapse" data-bs-target="#import-topic-<?= (int) $topic['id'] ?>"><i class="bi bi-upload me-1"></i>Import MCQs</button>
                                    </div>
                                </div>

                                <div id="import-topic-<?= (int) $topic['id'] ?>" class="collapse <?= (isset($openTopicId) && (int) $openTopicId === (int) $topic['id']) ? 'show' : '' ?> mt-3">
                                    @if(isset($importSummary) && (int) $importSummary['topic']['id'] === (int) $topic['id'])
                                    <div class="alert alert-<?= $importSummary['failed'] ? 'danger' : 'success' ?> small">
                                        @if($importSummary['failed'])
                                        Import failed due to a database error. No MCQs were inserted.
                                        @else
                                        <strong>Import complete for {{ $importSummary['topic']['name'] }}</strong><br>
                                        Submitted: {{ $importSummary['totalSubmitted'] }} &middot;
                                        New: {{ $importSummary['newCount'] }} &middot;
                                        Skipped as duplicate: {{ $importSummary['duplicates'] }} &middot;
                                        Invalid: {{ $importSummary['invalid'] }} &middot;
                                        <strong>Total inserted: {{ $importSummary['inserted'] }}</strong>
                                        @endif
                                    </div>
                                    <button class="btn btn-sk-outline btn-sm-sk" type="button" data-bs-toggle="collapse" data-bs-target="#import-topic-<?= (int) $topic['id'] ?>">Close</button>

                                    @elseif(isset($importPreview) && (int) $importPreview['topic']['id'] === (int) $topic['id'])
                                    <?php $result = $importPreview['result']; ?>
                                    @if($result['parseError'])
                                    <div class="alert alert-danger small">{{ $result['parseError'] }}</div>
                                    @else
                                    <div class="alert alert-info small mb-2">
                                        <strong>Preview: {{ $importPreview['topic']['name'] }}</strong><br>
                                        Total submitted: {{ $result['totalSubmitted'] }} &middot;
                                        New MCQs: {{ count($result['new']) }} &middot;
                                        Duplicates: {{ count($result['duplicates']) }} &middot;
                                        Invalid: {{ count($result['invalid']) }}
                                    </div>

                                    @if(count($result['duplicates']) > 0)
                                    <details class="small mb-2">
                                        <summary>Skipped duplicates ({{ count($result['duplicates']) }})</summary>
                                        <ul class="mb-0">
                                            @foreach($result['duplicates'] as $dup)
                                            <li>{{ $dup }}</li>
                                            @endforeach
                                        </ul>
                                    </details>
                                    @endif

                                    @if(count($result['invalid']) > 0)
                                    <details class="small mb-2">
                                        <summary>Invalid entries ({{ count($result['invalid']) }})</summary>
                                        <ul class="mb-0">
                                            @foreach($result['invalid'] as $inv)
                                            <li>#{{ $inv['position'] }}: {{ $inv['reason'] }}<?= $inv['question'] !== '' ? ' (' . htmlspecialchars($inv['question'], ENT_QUOTES, 'UTF-8') . ')' : '' ?></li>
                                            @endforeach
                                        </ul>
                                    </details>
                                    @endif

                                    @if(count($result['new']) > 0)
                                    <form method="POST" action="{{ route('dashboard.settings.mcqs.import.confirm') }}">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="topic_id" value="{{ $topic['id'] }}">
                                        <input type="hidden" name="new_mcqs_json" value="{{ json_encode(['mcqs' => $result['new']], JSON_UNESCAPED_UNICODE) }}">
                                        <button type="submit" class="btn btn-sk-gold btn-sm-sk">Import <?= count($result['new']) ?> New MCQ<?= count($result['new']) === 1 ? '' : 's' ?></button>
                                        <button type="button" class="btn btn-sk-outline btn-sm-sk" data-bs-toggle="collapse" data-bs-target="#import-topic-<?= (int) $topic['id'] ?>">Cancel</button>
                                    </form>
                                    @else
                                    <button class="btn btn-sk-outline btn-sm-sk" type="button" data-bs-toggle="collapse" data-bs-target="#import-topic-<?= (int) $topic['id'] ?>">Close</button>
                                    @endif
                                    @endif

                                    @else
                                    <form method="POST" action="{{ route('dashboard.settings.mcqs.import.preview') }}" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="topic_id" value="{{ $topic['id'] }}">
                                        <div class="mb-2">
                                            <label class="sk-auth-label">Upload JSON file</label>
                                            <input type="file" name="import_file" accept="application/json,.json" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-2">
                                            <label class="sk-auth-label">or paste JSON</label>
                                            <textarea name="import_json" rows="4" class="form-control form-control-sm" placeholder='{"mcqs":[{"question":"...","difficulty":"easy","explanation":"...","options":[{"text":"...","is_correct":true}]}]}'></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sk-navy btn-sm-sk">Preview Import</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
