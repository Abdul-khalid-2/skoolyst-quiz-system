<?php
$correctOption = '';
$optionTextFor = [];
foreach (($options ?? []) as $option) {
    $optionTextFor[$option['label']] = $option['option_text'];
    if ((int) $option['is_correct'] === 1) {
        $correctOption = $option['label'];
    }
}
?>

@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="subject_id" class="sk-auth-label">Subject</label>
        <select class="form-select <?= isset($errors['subject_id']) ? 'is-invalid' : '' ?>" id="subject_id" name="subject_id" required>
            <option value="">Choose a subject...</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject['id'] }}" <?= ((string) old('subject_id', (string) ($mcq['subject_id'] ?? '')) === (string) $subject['id']) ? 'selected' : '' ?>>{{ $subject['name'] }}</option>
            @endforeach
        </select>
        @if(isset($errors['subject_id']))
        <div class="invalid-feedback">{{ $errors['subject_id'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="topic_id" class="sk-auth-label">Topic <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <select class="form-select <?= isset($errors['topic_id']) ? 'is-invalid' : '' ?>" id="topic_id" name="topic_id">
            <option value="">No specific topic</option>
            @foreach($topicsBySubject as $subjectName => $subjectTopics)
            @foreach($subjectTopics as $topic)
            <option value="{{ $topic['id'] }}" data-subject-id="{{ $topic['subject_id'] }}" <?= ((string) old('topic_id', (string) ($mcq['topic_id'] ?? '')) === (string) $topic['id']) ? 'selected' : '' ?>>{{ $topic['name'] }}</option>
            @endforeach
            @endforeach
        </select>
        <div class="form-text">Only topics for the selected subject are shown.</div>
        @if(isset($errors['topic_id']))
        <div class="invalid-feedback">{{ $errors['topic_id'] }}</div>
        @endif
    </div>

    <div class="col-md-4">
        <label for="difficulty" class="sk-auth-label">Difficulty</label>
        <?php $difficulty = old('difficulty', $mcq['difficulty'] ?? 'medium'); ?>
        <select class="form-select <?= isset($errors['difficulty']) ? 'is-invalid' : '' ?>" id="difficulty" name="difficulty">
            <option value="easy" <?= $difficulty === 'easy' ? 'selected' : '' ?>>Easy</option>
            <option value="medium" <?= $difficulty === 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="hard" <?= $difficulty === 'hard' ? 'selected' : '' ?>>Hard</option>
        </select>
        @if(isset($errors['difficulty']))
        <div class="invalid-feedback">{{ $errors['difficulty'] }}</div>
        @endif
    </div>

    <div class="col-12">
        <label for="question_text" class="sk-auth-label">Question</label>
        <textarea class="form-control <?= isset($errors['question_text']) ? 'is-invalid' : '' ?>" id="question_text" name="question_text" rows="2" required>{{ old('question_text', $mcq['question_text'] ?? '') }}</textarea>
        @if(isset($errors['question_text']))
        <div class="invalid-feedback">{{ $errors['question_text'] }}</div>
        @endif
    </div>

    <div class="col-12">
        <label for="explanation" class="sk-auth-label">Explanation <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <textarea class="form-control" id="explanation" name="explanation" rows="2">{{ old('explanation', $mcq['explanation'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="sk-auth-label">Options <span class="text-secondary-custom fw-normal">(select the correct one)</span></label>
        @if(isset($errors['correct_option']))
        <div class="alert alert-danger py-1 px-2 small mb-2">{{ $errors['correct_option'] }}</div>
        @endif
        @foreach(['A', 'B', 'C', 'D'] as $label)
        <div class="d-flex align-items-start gap-2 mb-2">
            <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="correct_option" id="correct_{{ $label }}" value="{{ $label }}" <?= ((string) old('correct_option', $correctOption)) === $label ? 'checked' : '' ?>>
            </div>
            <span class="fw-semibold mt-2" style="width:16px;">{{ $label }}</span>
            <div class="flex-grow-1">
                <input type="text" class="form-control <?= isset($errors['option_' . strtolower($label)]) ? 'is-invalid' : '' ?>" name="option_{{ strtolower($label) }}" placeholder="Option {{ $label }} text" value="{{ old('option_' . strtolower($label), $optionTextFor[$label] ?? '') }}">
                @if(isset($errors['option_' . strtolower($label)]))
                <div class="invalid-feedback">{{ $errors['option_' . strtolower($label)] }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
(function () {
    var subjectSelect = document.getElementById('subject_id');
    var topicSelect = document.getElementById('topic_id');
    if (!subjectSelect || !topicSelect) return;

    var options = Array.prototype.slice.call(topicSelect.querySelectorAll('option[data-subject-id]'));

    function filterTopics() {
        var subjectId = subjectSelect.value;
        var selectedStillValid = false;

        options.forEach(function (option) {
            var matches = !subjectId || option.getAttribute('data-subject-id') === subjectId;
            option.hidden = !matches;
            option.disabled = !matches;
            if (matches && option.selected) selectedStillValid = true;
        });

        if (!selectedStillValid) {
            topicSelect.value = '';
        }
    }

    subjectSelect.addEventListener('change', filterTopics);
    filterTopics();
})();
</script>
