<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Take Mock Test — Skoolyst MCQs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>
<body style="background-color: var(--sk-bg-alt);">

    <div class="sk-test-header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('mock-tests.show', $slug) }}" class="btn btn-sk-light btn-sm-sk"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h5 class="mb-0">MDCAT Full Mock Test #1</h5>
                <small class="text-secondary-custom">200 Questions &middot; 3h 30m</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="sk-timer"><i class="bi bi-clock-fill"></i> <span id="sk-timer">30:00</span></div>
        </div>
    </div>

    <div id="sk-mock-test-container" class="container-fluid py-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="sk-card" id="sk-mock-main"></div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-grid-3x3-gap me-1"></i>Question Palette</h6>
                    <div id="sk-palette-legend"></div>
                    <div id="sk-mock-palette" class="sk-palette-grid"></div>
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
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
