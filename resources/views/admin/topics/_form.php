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
        <label for="description" class="sk-auth-label">Description <span class="text-secondary-custom fw-normal">(optional &mdash; headings, bold/italic and lists only)</span></label>
        <div id="descriptionEditor" class="sk-rte" style="display:none"></div>
        <textarea class="form-control" id="description" name="description" rows="6">{{ rich_text_html(old('description', $topic['description'] ?? '')) }}</textarea>
        @if(!empty($errors['description']))
        <div class="text-danger small mt-1">{{ $errors['description'] }}</div>
        @endif
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" integrity="sha384-ecIckRi4QlKYya/FQUbBUjS4qp65jF/J87Guw5uzTbO1C1Jfa/6kYmd6dXUF6D7i" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js" integrity="sha384-utBUCeG4SYaCm4m7GQZYr8Hy8Fpy3V4KGjBZaf4WTKOcwhCYpt/0PfeEe3HNlwx8" crossorigin="anonymous"></script>
<script>
// Simple description editor. If Quill fails to load, the plain textarea above keeps working.
(function () {
    var box = document.getElementById('descriptionEditor');
    var field = document.getElementById('description');
    if (!window.Quill || !box || !field) return;

    var quill = new Quill(box, {
        theme: 'snow',
        placeholder: 'Write a short description of this topic...',
        // Whitelist: anything else (images, links, colours, fonts...) is dropped, even when pasted.
        formats: ['header', 'bold', 'italic', 'list'],
        modules: {
            toolbar: [
                [{ header: [2, 3, 4, false] }],
                ['bold', 'italic'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    if (field.value.trim() !== '') {
        quill.setContents(quill.clipboard.convert({ html: field.value }), 'silent');
    }

    box.style.display = '';
    field.style.display = 'none';

    var form = field.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            field.value = quill.getText().trim() === '' ? '' : quill.getSemanticHTML();
        });
    }
})();
</script>
