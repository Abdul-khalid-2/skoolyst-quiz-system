<div class="sk-card">
    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <div>
            <span class="sk-badge sk-badge-{{ strtolower($difficulty) }}">{{ ucfirst($difficulty) }}</span>
            <span class="sk-badge sk-badge-light">{{ $subject }}</span>
        </div>
        <small class="text-muted"><i class="bi bi-clock"></i> {{ $time_ago }}</small>
    </div>
    <p class="fw-semibold mb-2">{{ $question }}</p>
    <div class="d-flex justify-content-between align-items-center">
        <small class="text-secondary-custom">
            <i class="bi bi-list-ol"></i> 4 Options &middot; 
            <i class="bi bi-journal-text"></i> {{ $topic }}
        </small>
        <a href="#" class="btn btn-sk-cyan btn-sm-sk">Practice</a>
    </div>
</div>