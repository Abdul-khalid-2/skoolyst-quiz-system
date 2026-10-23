@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="sk-auth-label">Name</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="{{ old('name', $testType['name'] ?? '') }}" required>
        @if(isset($errors['name']))
        <div class="invalid-feedback">{{ $errors['name'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="slug" class="sk-auth-label">Slug <span class="text-secondary-custom fw-normal">(auto-generated if left blank)</span></label>
        <input type="text" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" id="slug" name="slug" value="{{ old('slug', $testType['slug'] ?? '') }}" placeholder="e.g. mdcat">
        @if(isset($errors['slug']))
        <div class="invalid-feedback">{{ $errors['slug'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="icon" class="sk-auth-label">Icon <span class="text-secondary-custom fw-normal">(Bootstrap Icons class)</span></label>
        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $testType['icon'] ?? '') }}" placeholder="e.g. bi-heart-pulse">
    </div>

    <div class="col-md-6">
        <label for="badge_class" class="sk-auth-label">Badge Color</label>
        <?php $badgeClass = old('badge_class', $testType['badge_class'] ?? ''); ?>
        <select class="form-select" id="badge_class" name="badge_class">
            <option value="">Default</option>
            <option value="sk-badge-navy" <?= $badgeClass === 'sk-badge-navy' ? 'selected' : '' ?>>Navy</option>
            <option value="sk-badge-cyan" <?= $badgeClass === 'sk-badge-cyan' ? 'selected' : '' ?>>Cyan</option>
            <option value="sk-badge-gold" <?= $badgeClass === 'sk-badge-gold' ? 'selected' : '' ?>>Gold</option>
            <option value="sk-badge-light" <?= $badgeClass === 'sk-badge-light' ? 'selected' : '' ?>>Light</option>
        </select>
    </div>

    <div class="col-12">
        <label for="description" class="sk-auth-label">Description <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $testType['description'] ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="sk-auth-label">Subjects</label>
        <p class="text-secondary-custom small mb-2">Choose the subjects covered by this test type.</p>
        @if(count($subjects) > 0)
        <div class="row g-2">
            <?php $selectedSubjectIds = array_map('intval', $selectedSubjectIds ?? []); ?>
            @foreach($subjects as $subject)
            <div class="col-sm-6 col-lg-4">
                <label class="form-check border rounded p-2 ps-5 h-100">
                    <input class="form-check-input" type="checkbox" name="subject_ids[]" value="{{ $subject['id'] }}" <?= in_array((int) $subject['id'], $selectedSubjectIds, true) ? 'checked' : '' ?>>
                    <span class="form-check-label">{{ $subject['name'] }}</span>
                </label>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-secondary-custom small mb-0">Create a subject before assigning subjects to this test type.</p>
        @endif
        @if(isset($errors['subject_ids']))
        <div class="text-danger small mt-2">{{ $errors['subject_ids'] }}</div>
        @endif
    </div>
</div>
