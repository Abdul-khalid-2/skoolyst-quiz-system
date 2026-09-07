@if(isset($errors['_general']))
<div class="alert alert-danger py-2 small">{{ $errors['_general'] }}</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="sk-auth-label">Name</label>
        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="{{ old('name', $subject['name'] ?? '') }}" required>
        @if(isset($errors['name']))
        <div class="invalid-feedback">{{ $errors['name'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="slug" class="sk-auth-label">Slug <span class="text-secondary-custom fw-normal">(auto-generated if left blank)</span></label>
        <input type="text" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>" id="slug" name="slug" value="{{ old('slug', $subject['slug'] ?? '') }}" placeholder="e.g. biology">
        @if(isset($errors['slug']))
        <div class="invalid-feedback">{{ $errors['slug'] }}</div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="icon" class="sk-auth-label">Icon <span class="text-secondary-custom fw-normal">(Bootstrap Icons class)</span></label>
        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $subject['icon'] ?? '') }}" placeholder="e.g. bi-tree">
    </div>

    <div class="col-md-6">
        <label for="icon_bg" class="sk-auth-label">Icon Color</label>
        <?php $iconBg = old('icon_bg', $subject['icon_bg'] ?? ''); ?>
        <select class="form-select" id="icon_bg" name="icon_bg">
            <option value="">Default</option>
            <option value="bg-icon-navy" <?= $iconBg === 'bg-icon-navy' ? 'selected' : '' ?>>Navy</option>
            <option value="bg-icon-cyan" <?= $iconBg === 'bg-icon-cyan' ? 'selected' : '' ?>>Cyan</option>
            <option value="bg-icon-gold" <?= $iconBg === 'bg-icon-gold' ? 'selected' : '' ?>>Gold</option>
            <option value="bg-icon-success" <?= $iconBg === 'bg-icon-success' ? 'selected' : '' ?>>Success (green)</option>
            <option value="bg-icon-info" <?= $iconBg === 'bg-icon-info' ? 'selected' : '' ?>>Info (blue)</option>
            <option value="bg-icon-error" <?= $iconBg === 'bg-icon-error' ? 'selected' : '' ?>>Error (red)</option>
        </select>
    </div>

    <div class="col-12">
        <label for="description" class="sk-auth-label">Description <span class="text-secondary-custom fw-normal">(optional)</span></label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $subject['description'] ?? '') }}</textarea>
    </div>
</div>
