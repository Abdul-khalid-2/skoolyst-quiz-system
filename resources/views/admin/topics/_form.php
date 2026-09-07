@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="subject_id" class="sk-auth-label">Subject</label>
        <select class="form-select <?= isset($errors['subject_id']) ? 'is-invalid' : '' ?>" id="subject_id" name="subject_id" required>
            <option value="">Choose a subject...</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject['id'] }}" <?= ((string) old('subject_id', (string) ($topic['subject_id'] ?? '')) === (string) $subject['id']) ? 'selected' : '' ?>>{{ $subject['name'] }}</option>
            @endforeach
        </select>
        @if(isset($errors['subject_id']))
        <div class="invalid-feedback">{{ $errors['subject_id'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="difficulty" class="sk-auth-label">Difficulty</label>
        <?php $difficulty = old('difficulty', $topic['difficulty'] ?? 'medium'); ?>
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
        <label for="name" class="sk-auth-label">Name</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="{{ old('name', $topic['name'] ?? '') }}" required>
        @if(isset($errors['name']))
        <div class="invalid-feedback">{{ $errors['name'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="slug" class="sk-auth-label">Slug <span class="text-secondary-custom fw-normal">(auto-generated if left blank, unique per subject)</span></label>
        <input type="text" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" id="slug" name="slug" value="{{ old('slug', $topic['slug'] ?? '') }}" placeholder="e.g. cell-biology">
        @if(isset($errors['slug']))
        <div class="invalid-feedback">{{ $errors['slug'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="icon" class="sk-auth-label">Icon <span class="text-secondary-custom fw-normal">(Bootstrap Icons class, optional)</span></label>
        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $topic['icon'] ?? '') }}" placeholder="e.g. bi-dna">
    </div>

    <div class="col-12">
        <label for="description" class="sk-auth-label">Description <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $topic['description'] ?? '') }}</textarea>
    </div>
</div>
