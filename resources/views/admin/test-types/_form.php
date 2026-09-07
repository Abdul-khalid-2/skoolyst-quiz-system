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
</div>
