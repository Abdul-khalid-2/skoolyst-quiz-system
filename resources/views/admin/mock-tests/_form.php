<?php $selectedIds = array_map('intval', $selectedMcqIds); ?>

@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="test_type_id" class="sk-auth-label">Test Type</label>
        <select class="form-select <?= isset($errors['test_type_id']) ? 'is-invalid' : '' ?>" id="test_type_id" name="test_type_id" required>
            <option value="">Choose a test type...</option>
            @foreach($testTypes as $testType)
            <option value="{{ $testType['id'] }}" <?= ((string) old('test_type_id', (string) ($mockTest['test_type_id'] ?? '')) === (string) $testType['id']) ? 'selected' : '' ?>>{{ $testType['name'] }}</option>
            @endforeach
        </select>
        @if(isset($errors['test_type_id']))
        <div class="invalid-feedback">{{ $errors['test_type_id'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="difficulty" class="sk-auth-label">Difficulty</label>
        <?php $difficulty = old('difficulty', $mockTest['difficulty'] ?? 'medium'); ?>
        <select class="form-select <?= isset($errors['difficulty']) ? 'is-invalid' : '' ?>" id="difficulty" name="difficulty">
            <option value="easy" <?= $difficulty === 'easy' ? 'selected' : '' ?>>Easy</option>
            <option value="medium" <?= $difficulty === 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="hard" <?= $difficulty === 'hard' ? 'selected' : '' ?>>Hard</option>
        </select>
        @if(isset($errors['difficulty']))
        <div class="invalid-feedback">{{ $errors['difficulty'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="title" class="sk-auth-label">Title</label>
        <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" value="{{ old('title', $mockTest['title'] ?? '') }}" required>
        @if(isset($errors['title']))
        <div class="invalid-feedback">{{ $errors['title'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="slug" class="sk-auth-label">Slug <span class="text-secondary-custom fw-normal">(auto-generated if left blank)</span></label>
        <input type="text" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" id="slug" name="slug" value="{{ old('slug', $mockTest['slug'] ?? '') }}" placeholder="e.g. mdcat-full-mock-test-1">
        @if(isset($errors['slug']))
        <div class="invalid-feedback">{{ $errors['slug'] }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label for="total_questions" class="sk-auth-label">Total Questions</label>
        <input type="number" min="0" class="form-control <?= isset($errors['total_questions']) ? 'is-invalid' : '' ?>" id="total_questions" name="total_questions" value="{{ old('total_questions', (string) ($mockTest['total_questions'] ?? 0)) }}">
        @if(isset($errors['total_questions']))
        <div class="invalid-feedback">{{ $errors['total_questions'] }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label for="duration_minutes" class="sk-auth-label">Duration (minutes)</label>
        <input type="number" min="0" class="form-control <?= isset($errors['duration_minutes']) ? 'is-invalid' : '' ?>" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', (string) ($mockTest['duration_minutes'] ?? 0)) }}">
        @if(isset($errors['duration_minutes']))
        <div class="invalid-feedback">{{ $errors['duration_minutes'] }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label for="passing_score_percent" class="sk-auth-label">Passing Score (%)</label>
        <input type="number" min="0" max="100" class="form-control <?= isset($errors['passing_score_percent']) ? 'is-invalid' : '' ?>" id="passing_score_percent" name="passing_score_percent" value="{{ old('passing_score_percent', (string) ($mockTest['passing_score_percent'] ?? 50)) }}">
        @if(isset($errors['passing_score_percent']))
        <div class="invalid-feedback">{{ $errors['passing_score_percent'] }}</div>
        @endif
    </div>

    <div class="col-12">
        <label for="description" class="sk-auth-label">Description <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <textarea class="form-control" id="description" name="description" rows="2">{{ old('description', $mockTest['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12 d-flex gap-4">
        <?php $negativeMarking = old('negative_marking', ((int) ($mockTest['negative_marking'] ?? 0)) === 1 ? '1' : '0'); ?>
        <div class="form-check">
            <input type="hidden" name="negative_marking" value="0">
            <input class="form-check-input" type="checkbox" id="negative_marking" name="negative_marking" value="1" <?= $negativeMarking === '1' ? 'checked' : '' ?>>
            <label class="form-check-label" for="negative_marking">Negative marking</label>
        </div>
        <?php $isFeatured = old('is_featured', ((int) ($mockTest['is_featured'] ?? 0)) === 1 ? '1' : '0'); ?>
        <div class="form-check">
            <input type="hidden" name="is_featured" value="0">
            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= $isFeatured === '1' ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_featured">Featured</label>
        </div>
    </div>

    <div class="col-12">
        <label class="sk-auth-label">Questions <span class="text-secondary-custom fw-normal">(select MCQs to include in this mock test)</span></label>

        <?php $mcqSubjectNames = []; foreach ($mcqs as $mcq) { $mcqSubjectNames[$mcq['subject_name']] = true; } $mcqSubjectNames = array_keys($mcqSubjectNames); sort($mcqSubjectNames); ?>

        @if(count($mcqs) > 0)
        <div class="row g-2 mb-2">
            <div class="col-md-6">
                <input type="text" class="form-control form-control-sm" id="mcq-filter-search" placeholder="Search question text...">
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" id="mcq-filter-subject">
                    <option value="">All subjects</option>
                    @foreach($mcqSubjectNames as $subjectName)
                    <option value="{{ $subjectName }}">{{ $subjectName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" id="mcq-filter-difficulty">
                    <option value="">All difficulties</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <small class="text-secondary-custom" id="mcq-filter-count"></small>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sk-outline btn-sm-sk" id="mcq-select-visible">Select all shown</button>
                <button type="button" class="btn btn-sk-outline btn-sm-sk" id="mcq-clear-visible">Clear all shown</button>
            </div>
        </div>
        @endif

        <div class="sk-info-box" style="max-height:320px;overflow-y:auto;">
            @if(count($mcqs) > 0)
            @foreach($mcqs as $mcq)
            <div class="form-check mb-2 mcq-row" data-subject="<?= htmlspecialchars($mcq['subject_name']) ?>" data-difficulty="{{ $mcq['difficulty'] }}" data-search="<?= htmlspecialchars(strtolower($mcq['question_text'])) ?>">
                <input class="form-check-input" type="checkbox" name="mcq_ids[]" id="mcq_{{ $mcq['id'] }}" value="{{ $mcq['id'] }}" <?= in_array((int) $mcq['id'], $selectedIds, true) ? 'checked' : '' ?>>
                <label class="form-check-label" for="mcq_{{ $mcq['id'] }}">
                    {{ mb_strimwidth($mcq['question_text'], 0, 80, '...') }}
                    <span class="text-secondary-custom small">(<?= htmlspecialchars($mcq['subject_name']) ?><?= $mcq['topic_name'] ? ' — ' . htmlspecialchars($mcq['topic_name']) : '' ?>)</span>
                    <span class="sk-badge sk-badge-{{ $mcq['difficulty'] }} ms-1">{{ ucfirst($mcq['difficulty']) }}</span>
                </label>
            </div>
            @endforeach
            @else
            <p class="text-secondary-custom mb-0 small">No MCQs exist yet. Add some first, then come back here to include them in this mock test.</p>
            @endif
        </div>
        <div id="mcq-no-results" class="text-secondary-custom small mt-2" hidden>No questions match your filters.</div>
    </div>
</div>

<script>
(function () {
    var search = document.getElementById('mcq-filter-search');
    var subjectFilter = document.getElementById('mcq-filter-subject');
    var difficultyFilter = document.getElementById('mcq-filter-difficulty');
    var rows = Array.prototype.slice.call(document.querySelectorAll('.mcq-row'));
    var countLabel = document.getElementById('mcq-filter-count');
    var noResults = document.getElementById('mcq-no-results');
    var selectVisibleBtn = document.getElementById('mcq-select-visible');
    var clearVisibleBtn = document.getElementById('mcq-clear-visible');

    if (!rows.length || !search) return;

    function applyFilters() {
        var term = (search.value || '').toLowerCase().trim();
        var subject = subjectFilter.value;
        var difficulty = difficultyFilter.value;
        var visibleCount = 0;

        rows.forEach(function (row) {
            var matchesSearch = !term || row.getAttribute('data-search').indexOf(term) !== -1;
            var matchesSubject = !subject || row.getAttribute('data-subject') === subject;
            var matchesDifficulty = !difficulty || row.getAttribute('data-difficulty') === difficulty;
            var show = matchesSearch && matchesSubject && matchesDifficulty;
            row.hidden = !show;
            if (show) visibleCount++;
        });

        countLabel.textContent = visibleCount + ' of ' + rows.length + ' questions shown';
        noResults.hidden = visibleCount !== 0;
    }

    function setVisibleChecked(checked) {
        rows.forEach(function (row) {
            if (!row.hidden) {
                var checkbox = row.querySelector('input[type=checkbox]');
                if (checkbox) checkbox.checked = checked;
            }
        });
    }

    search.addEventListener('input', applyFilters);
    subjectFilter.addEventListener('change', applyFilters);
    difficultyFilter.addEventListener('change', applyFilters);
    selectVisibleBtn.addEventListener('click', function () { setVisibleChecked(true); });
    clearVisibleBtn.addEventListener('click', function () { setVisibleChecked(false); });

    applyFilters();
})();
</script>

