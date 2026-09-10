@if(count($mcqs) > 0)
<script type="application/json" id="sk-practice-data"><?= json_encode(array_map(function ($mcq) use ($mcqOptions) {
    return [
        'id' => (int) $mcq['id'],
        'question' => $mcq['question_text'],
        'difficulty' => $mcq['difficulty'],
        'explanation' => $mcq['explanation'],
        'options' => array_map(function ($option) {
            return [
                'id' => (int) $option['id'],
                'label' => $option['label'],
                'text' => $option['option_text'],
                'correct' => (int) $option['is_correct'] === 1,
            ];
        }, array_values($mcqOptions[$mcq['id']] ?? [])),
    ];
}, $mcqs), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>

<div class="progress mb-3" style="height: 6px;">
    <div id="sk-practice-progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
</div>

<div id="sk-practice-app"></div>

<script>
(function () {
    var dataEl = document.getElementById('sk-practice-data');
    if (!dataEl) return;

    var questions = JSON.parse(dataEl.textContent);
    var app = document.getElementById('sk-practice-app');
    var progressBar = document.getElementById('sk-practice-progress-bar');
    var backUrl = <?= json_encode($backUrl ?? null) ?>;
    var backLabel = <?= json_encode($backLabel ?? 'Back') ?>;
    var resultUrl = <?= json_encode($resultUrl ?? null) ?>;
    var submitUrl = <?= json_encode($submitUrl ?? null) ?>;
    var csrfToken = <?= json_encode(!empty($submitUrl) ? csrf_token() : null) ?>;

    var state = questions.map(function () { return { selected: null, checked: false }; });
    var currentIndex = 0;

    function updateProgress() {
        var checkedCount = state.filter(function (s) { return s.checked; }).length;
        progressBar.style.width = Math.round((checkedCount / questions.length) * 100) + '%';
    }

    function render() {
        var q = questions[currentIndex];
        var s = state[currentIndex];
        var isLast = currentIndex === questions.length - 1;

        var optionsHtml = q.options.map(function (opt, i) {
            var cls = 'sk-mcq-option';
            var icon = '';
            if (s.checked) {
                cls += ' disabled';
                if (opt.correct) {
                    cls += ' correct';
                    icon = '<i class="bi bi-check-circle-fill sk-mcq-option-icon text-success ms-2"></i>';
                } else if (i === s.selected) {
                    cls += ' incorrect';
                    icon = '<i class="bi bi-x-circle-fill sk-mcq-option-icon text-danger ms-2"></i>';
                }
            } else if (i === s.selected) {
                cls += ' selected';
            }

            return '<div class="' + cls + '" data-option-index="' + i + '">' +
                '<span class="sk-mcq-option-letter">' + opt.label + '</span>' +
                '<span class="sk-mcq-option-text">' + escapeHtml(opt.text) + '</span>' +
                icon +
            '</div>';
        }).join('');

        var feedbackHtml = '';
        if (s.checked && q.explanation) {
            feedbackHtml = '<p class="text-secondary-custom small mt-3 mb-0"><i class="bi bi-lightbulb me-1"></i>' + escapeHtml(q.explanation) + '</p>';
        }

        var checkDisabled = s.selected === null ? 'disabled' : '';
        var actionsHtml = '<div class="mt-3 d-flex justify-content-between flex-wrap gap-2">' +
            '<button type="button" class="btn btn-sk-outline btn-sm-sk" id="sk-practice-prev"' + (currentIndex === 0 ? ' disabled' : '') + '><i class="bi bi-arrow-left me-1"></i>Previous</button>' +
            (s.checked
                ? '<button type="button" class="btn btn-sk-gold btn-sm-sk" id="sk-practice-next">' + (isLast ? 'Finish Practice<i class="bi bi-flag-fill ms-1"></i>' : 'Next<i class="bi bi-arrow-right ms-1"></i>') + '</button>'
                : '<button type="button" class="btn btn-sk-gold btn-sm-sk" id="sk-practice-check" ' + checkDisabled + '>Submit Answer<i class="bi bi-check2 ms-1"></i></button>') +
        '</div>';

        app.innerHTML =
            '<div class="sk-card mb-3">' +
                '<div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">' +
                    '<span class="sk-badge sk-badge-navy">Q' + (currentIndex + 1) + ' of ' + questions.length + '</span>' +
                    '<span class="sk-badge sk-badge-' + q.difficulty + '">' + q.difficulty.charAt(0).toUpperCase() + q.difficulty.slice(1) + '</span>' +
                '</div>' +
                '<p class="fw-semibold mb-3">' + escapeHtml(q.question) + '</p>' +
                optionsHtml +
                feedbackHtml +
                actionsHtml +
            '</div>';

        app.querySelectorAll('.sk-mcq-option').forEach(function (el) {
            el.addEventListener('click', function () {
                if (state[currentIndex].checked) return;
                state[currentIndex].selected = parseInt(el.getAttribute('data-option-index'), 10);
                render();
            });
        });

        var checkBtn = document.getElementById('sk-practice-check');
        if (checkBtn) {
            checkBtn.addEventListener('click', function () {
                if (state[currentIndex].selected === null) return;
                state[currentIndex].checked = true;
                updateProgress();
                render();
            });
        }

        var prevBtn = document.getElementById('sk-practice-prev');
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                if (currentIndex > 0) {
                    currentIndex--;
                    render();
                }
            });
        }

        var nextBtn = document.getElementById('sk-practice-next');
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                if (isLast) {
                    renderSummary();
                } else {
                    currentIndex++;
                    render();
                }
            });
        }
    }

    function renderSummary() {
        var correctCount = 0;
        state.forEach(function (s, i) {
            if (s.checked && questions[i].options[s.selected] && questions[i].options[s.selected].correct) {
                correctCount++;
            }
        });
        var percentage = Math.round((correctCount / questions.length) * 100);

        progressBar.style.width = '100%';

        var linksHtml = '';
        if (backUrl) {
            linksHtml += '<a href="' + backUrl + '" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>' + escapeHtml(backLabel) + '</a>';
        }
        if (resultUrl) {
            linksHtml += '<a href="' + resultUrl + '" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-clipboard-data me-1"></i>View Results</a>';
        }

        var saveNoteHtml = submitUrl ? '<p class="small text-secondary-custom mt-3 mb-0" id="sk-practice-save-note"><i class="bi bi-cloud-arrow-up me-1"></i>Saving your result&hellip;</p>' : '';

        app.innerHTML =
            '<div class="sk-card text-center">' +
                '<i class="bi bi-trophy-fill text-warning" style="font-size:2.5rem;"></i>' +
                '<h3 class="mt-2 mb-1">Practice Complete!</h3>' +
                '<p class="text-secondary-custom mb-3">You scored ' + correctCount + ' out of ' + questions.length + ' (' + percentage + '%)</p>' +
                '<div class="d-flex justify-content-center gap-2 flex-wrap">' +
                    '<button type="button" class="btn btn-sk-gold btn-sm-sk" id="sk-practice-retake"><i class="bi bi-arrow-repeat me-1"></i>Retake Practice</button>' +
                    linksHtml +
                '</div>' +
                saveNoteHtml +
            '</div>';

        var retakeBtn = document.getElementById('sk-practice-retake');
        if (retakeBtn) {
            retakeBtn.addEventListener('click', function () {
                state = questions.map(function () { return { selected: null, checked: false }; });
                currentIndex = 0;
                updateProgress();
                render();
            });
        }

        if (submitUrl) {
            var answersById = {};
            questions.forEach(function (q, i) {
                var s = state[i];
                if (s.checked && s.selected !== null && q.options[s.selected]) {
                    answersById[q.id] = q.options[s.selected].id;
                }
            });

            var body = new URLSearchParams();
            body.set('_csrf', csrfToken);
            body.set('answers', JSON.stringify(answersById));

            fetch(submitUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json' },
                body: body.toString(),
            })
                .then(function (res) { return res.json(); })
                .then(function (json) {
                    var note = document.getElementById('sk-practice-save-note');
                    if (!note) return;
                    if (json.ok) {
                        note.innerHTML = '<i class="bi bi-cloud-check me-1"></i>Result saved.';
                    } else {
                        note.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Could not save your result.';
                    }
                })
                .catch(function () {
                    var note = document.getElementById('sk-practice-save-note');
                    if (note) note.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Could not save your result.';
                });
        }
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    render();
})();
</script>
@else
@include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions for this topic will show up here once added.'])
@endif
