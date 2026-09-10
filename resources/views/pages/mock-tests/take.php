<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ $mockTest['title'] }} — Skoolyst MCQs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body style="background-color: var(--sk-bg-alt);">

@if(count($questions) === 0)
<div class="container py-5">
    @include('components.empty-state', [
        'icon' => 'bi-clipboard2-x',
        'title' => 'This mock test has no questions yet',
        'message' => 'Check back soon — questions are being added to this test.',
    ])
    <div class="text-center">
        <a href="{{ route('mock-tests.show', $mockTest['slug']) }}" class="btn btn-sk-navy btn-lg"><i class="bi bi-arrow-left me-2"></i>Back to Test Details</a>
    </div>
</div>
@else
<script type="application/json" id="sk-mt-data"><?= json_encode([
    'questions' => array_map(function ($q) use ($options) {
        return [
            'id' => (int) $q['id'],
            'question' => $q['question_text'],
            'subject' => $q['subject_name'],
            'topic' => $q['topic_name'],
            'difficulty' => $q['difficulty'],
            'options' => array_map(fn ($o) => ['id' => (int) $o['id'], 'label' => $o['label'], 'text' => $o['option_text']], array_values($options[$q['id']] ?? [])),
        ];
    }, $questions),
    'durationSeconds' => (int) $mockTest['duration_minutes'] * 60,
    'title' => $mockTest['title'],
    'submitUrl' => route('mock-tests.submit', $mockTest['slug']),
    'csrfToken' => csrf_token(),
], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>

    <div class="sk-test-header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('mock-tests.show', $mockTest['slug']) }}" class="btn btn-sk-light btn-sm-sk"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h5 class="mb-0">{{ $mockTest['title'] }}</h5>
                <small class="text-secondary-custom">{{ count($questions) }} Questions &middot; {{ $mockTest['duration_minutes'] }}m</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="sk-timer"><i class="bi bi-clock-fill"></i> <span id="sk-mt-timer">--:--</span></div>
        </div>
    </div>

    <div id="sk-mt-container" class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="sk-card" id="sk-mt-main"></div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-grid-3x3-gap me-1"></i>Question Palette</h6>
                    <div id="sk-mt-legend"></div>
                    <div id="sk-mt-palette" class="sk-palette-grid"></div>
                </div>
                <div class="sk-info-box">
                    <h6><i class="bi bi-info-circle me-1"></i>Instructions</h6>
                    <ul class="small mb-0">
                        <li>Click an option to select your answer</li>
                        <li>Click again to deselect</li>
                        <li>Use "Mark for Review" to flag questions</li>
                        <li>Use "Clear" to remove your answer</li>
                        <li>Submit when you're done</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        var data = JSON.parse(document.getElementById('sk-mt-data').textContent);
        var questions = data.questions;
        var currentIndex = 0;
        var userAnswers = new Array(questions.length).fill(null);
        var markedForReview = new Array(questions.length).fill(false);
        var totalTime = data.durationSeconds;
        var timeRemaining = totalTime;
        var timerInterval = null;
        var submitted = false;

        function escapeHtml(str) {
            var div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function formatTime(seconds) {
            seconds = Math.max(0, seconds);
            var h = Math.floor(seconds / 3600);
            var m = Math.floor((seconds % 3600) / 60);
            var s = seconds % 60;
            var out = (h > 0 ? String(h).padStart(2, '0') + ':' : '') + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            return out;
        }

        function updateTimer() {
            var timerEl = document.getElementById('sk-mt-timer');
            if (!timerEl) return;
            timerEl.textContent = formatTime(timeRemaining);
            if (timeRemaining < 300) {
                timerEl.parentElement.classList.add('danger');
            } else if (timeRemaining < 600) {
                timerEl.parentElement.classList.add('warning');
            }
        }

        timerInterval = setInterval(function () {
            timeRemaining--;
            updateTimer();
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                submitTest();
            }
        }, 1000);

        function renderPalette() {
            var paletteEl = document.getElementById('sk-mt-palette');
            paletteEl.innerHTML = questions.map(function (q, i) {
                var cls = 'sk-palette-item';
                if (i === currentIndex) cls += ' current';
                else if (markedForReview[i] && userAnswers[i] !== null) cls += ' answered-marked';
                else if (markedForReview[i]) cls += ' marked';
                else if (userAnswers[i] !== null) cls += ' answered';
                return '<span class="' + cls + '" data-idx="' + i + '">' + (i + 1) + '</span>';
            }).join('');
            paletteEl.querySelectorAll('.sk-palette-item').forEach(function (item) {
                item.addEventListener('click', function () {
                    currentIndex = parseInt(item.getAttribute('data-idx'), 10);
                    render();
                });
            });

            var answered = userAnswers.filter(function (a) { return a !== null; }).length;
            var marked = markedForReview.filter(function (m) { return m; }).length;
            var notAnswered = questions.length - answered;
            var legendEl = document.getElementById('sk-mt-legend');
            legendEl.innerHTML =
                '<div class="d-flex flex-wrap gap-3 mb-2">' +
                    '<span class="d-flex align-items-center gap-1"><span class="sk-palette-item answered" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Answered (' + answered + ')</span>' +
                    '<span class="d-flex align-items-center gap-1"><span class="sk-palette-item" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Not Answered (' + notAnswered + ')</span>' +
                    '<span class="d-flex align-items-center gap-1"><span class="sk-palette-item marked" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Marked (' + marked + ')</span>' +
                '</div>';
        }

        function render() {
            var q = questions[currentIndex];
            var progress = ((currentIndex + 1) / questions.length) * 100;
            var mainEl = document.getElementById('sk-mt-main');

            mainEl.innerHTML =
                '<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">' +
                    '<span class="sk-badge sk-badge-navy">Question ' + (currentIndex + 1) + ' of ' + questions.length + '</span>' +
                    '<div class="d-flex gap-2">' +
                        '<span class="sk-badge sk-badge-light">' + escapeHtml(q.subject || '') + '</span>' +
                        (q.topic ? '<span class="sk-badge sk-badge-light">' + escapeHtml(q.topic) + '</span>' : '') +
                    '</div>' +
                '</div>' +
                '<div class="sk-progress mb-4"><div class="sk-progress-bar" style="width: ' + progress + '%"></div></div>' +
                '<h4 class="mb-3">' + escapeHtml(q.question) + '</h4>' +
                '<div id="sk-mt-options">' +
                    q.options.map(function (opt) {
                        var cls = 'sk-mcq-option';
                        if (userAnswers[currentIndex] === opt.id) cls += ' selected';
                        return '<div class="' + cls + '" data-option-id="' + opt.id + '">' +
                            '<span class="sk-mcq-option-letter">' + opt.label + '</span>' +
                            '<span class="sk-mcq-option-text">' + escapeHtml(opt.text) + '</span>' +
                        '</div>';
                    }).join('') +
                '</div>' +
                '<div class="d-flex justify-content-between mt-4 flex-wrap gap-2">' +
                    '<div class="d-flex gap-2 flex-wrap">' +
                        '<button class="btn btn-sk-outline btn-sm-sk" id="sk-mt-prev" type="button" ' + (currentIndex === 0 ? 'disabled' : '') + '><i class="bi bi-arrow-left me-1"></i>Previous</button>' +
                        '<button class="btn btn-sk-outline btn-sm-sk" id="sk-mt-mark" type="button">' + (markedForReview[currentIndex] ? '<i class="bi bi-bookmark-fill me-1 text-warning"></i>Unmark' : '<i class="bi bi-bookmark me-1"></i>Mark for Review') + '</button>' +
                        '<button class="btn btn-sk-outline btn-sm-sk" id="sk-mt-clear" type="button" ' + (userAnswers[currentIndex] === null ? 'disabled' : '') + '><i class="bi bi-eraser me-1"></i>Clear</button>' +
                    '</div>' +
                    '<div class="d-flex gap-2">' +
                        (currentIndex < questions.length - 1
                            ? '<button class="btn btn-sk-navy btn-sm-sk" id="sk-mt-next" type="button">Next<i class="bi bi-arrow-right ms-1"></i></button>'
                            : '<button class="btn btn-sk-gold btn-sm-sk" id="sk-mt-submit" type="button"><i class="bi bi-check2-all me-1"></i>Submit Test</button>') +
                    '</div>' +
                '</div>';

            mainEl.querySelectorAll('.sk-mcq-option').forEach(function (el) {
                el.addEventListener('click', function () {
                    var optId = parseInt(el.getAttribute('data-option-id'), 10);
                    userAnswers[currentIndex] = userAnswers[currentIndex] === optId ? null : optId;
                    render();
                });
            });

            var prevBtn = document.getElementById('sk-mt-prev');
            if (prevBtn) prevBtn.addEventListener('click', function () { if (currentIndex > 0) { currentIndex--; render(); } });
            var nextBtn = document.getElementById('sk-mt-next');
            if (nextBtn) nextBtn.addEventListener('click', function () { if (currentIndex < questions.length - 1) { currentIndex++; render(); } });
            var markBtn = document.getElementById('sk-mt-mark');
            if (markBtn) markBtn.addEventListener('click', function () { markedForReview[currentIndex] = !markedForReview[currentIndex]; render(); });
            var clearBtn = document.getElementById('sk-mt-clear');
            if (clearBtn) clearBtn.addEventListener('click', function () { userAnswers[currentIndex] = null; render(); });
            var submitBtn = document.getElementById('sk-mt-submit');
            if (submitBtn) submitBtn.addEventListener('click', showSubmitConfirm);

            renderPalette();
        }

        function showSubmitConfirm() {
            var answered = userAnswers.filter(function (a) { return a !== null; }).length;
            var notAnswered = questions.length - answered;
            var marked = markedForReview.filter(function (m) { return m; }).length;

            var modalDiv = document.createElement('div');
            modalDiv.innerHTML =
                '<div class="modal fade" id="sk-mt-submit-modal" tabindex="-1">' +
                    '<div class="modal-dialog modal-dialog-centered">' +
                        '<div class="modal-content">' +
                            '<div class="modal-header bg-dark-navy text-white">' +
                                '<h5 class="modal-title"><i class="bi bi-check2-circle me-2"></i>Submit Test?</h5>' +
                                '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>' +
                            '</div>' +
                            '<div class="modal-body">' +
                                '<p>You are about to submit your test. Here\'s a summary:</p>' +
                                '<div class="sk-info-box mb-3">' +
                                    '<div class="sk-info-row"><span class="sk-info-label">Total Questions</span><span class="sk-info-value">' + questions.length + '</span></div>' +
                                    '<div class="sk-info-row"><span class="sk-info-label">Answered</span><span class="sk-info-value text-success">' + answered + '</span></div>' +
                                    '<div class="sk-info-row"><span class="sk-info-label">Not Answered</span><span class="sk-info-value text-danger">' + notAnswered + '</span></div>' +
                                    '<div class="sk-info-row"><span class="sk-info-label">Marked for Review</span><span class="sk-info-value text-warning">' + marked + '</span></div>' +
                                    '<div class="sk-info-row"><span class="sk-info-label">Time Used</span><span class="sk-info-value">' + formatTime(totalTime - timeRemaining) + '</span></div>' +
                                '</div>' +
                                (notAnswered > 0 ? '<div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>You have unanswered questions. Are you sure you want to submit?</div>' : '') +
                            '</div>' +
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-sk-light" data-bs-dismiss="modal">Cancel</button>' +
                                '<button type="button" class="btn btn-sk-gold" id="sk-mt-confirm-submit">Submit Test</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            document.body.appendChild(modalDiv);
            var modal = new bootstrap.Modal(modalDiv.querySelector('#sk-mt-submit-modal'));
            modal.show();
            document.getElementById('sk-mt-confirm-submit').addEventListener('click', function () {
                modal.hide();
                modalDiv.remove();
                submitTest();
            });
            modalDiv.querySelector('#sk-mt-submit-modal').addEventListener('hidden.bs.modal', function () {
                modalDiv.remove();
            });
        }

        function submitTest() {
            if (submitted) return;
            submitted = true;
            clearInterval(timerInterval);

            var answersById = {};
            var markedById = {};
            questions.forEach(function (q, i) {
                if (userAnswers[i] !== null) answersById[q.id] = userAnswers[i];
                if (markedForReview[i]) markedById[q.id] = true;
            });

            var mainEl = document.getElementById('sk-mt-main');
            mainEl.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-warning" role="status"></div><p class="mt-3 text-secondary-custom">Submitting your test...</p></div>';

            var body = new URLSearchParams();
            body.set('_csrf', data.csrfToken);
            body.set('answers', JSON.stringify(answersById));
            body.set('marked', JSON.stringify(markedById));
            body.set('time_taken_seconds', String(totalTime - timeRemaining));

            fetch(data.submitUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' },
                body: body.toString(),
            })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    if (json.redirect) {
                        window.location.href = json.redirect;
                    } else {
                        mainEl.innerHTML = '<div class="alert alert-danger m-3">' + escapeHtml(json.error || 'Something went wrong while submitting. Please try again.') + '</div>';
                        submitted = false;
                    }
                })
                .catch(function () {
                    mainEl.innerHTML = '<div class="alert alert-danger m-3">Network error while submitting. Please check your connection and try again.</div>';
                    submitted = false;
                });
        }

        window.addEventListener('beforeunload', function (e) {
            if (!submitted) { e.preventDefault(); e.returnValue = ''; }
        });

        updateTimer();
        render();
    })();
    </script>
@endif
</body>
</html>
