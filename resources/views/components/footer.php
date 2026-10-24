<footer class="sk-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="sk-footer-brand"><span class="sk-logo-mark">S</span> Skoolyst<span>MCQs</span></div>
                <p>Practice thousands of educational MCQs and prepare for your exams with Skoolyst. Your trusted partner in academic success.</p>
            </div>
            <div class="col-6 col-lg-2">
                <h5>MCQs</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                    <li class="mb-2"><a href="{{ route('test-types.index') }}">Test Types</a></li>
                    <li class="mb-2"><a href="{{ route('mock-tests.index') }}">Mock Tests</a></li>
                    <li class="mb-2"><a href="{{ route('search') }}">Search MCQs</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Company</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('about') }}">About</a></li>
                    <li class="mb-2"><a href="{{ route('privacy-policy') }}">Privacy</a></li>
                    <li class="mb-2"><a href="{{ route('terms') }}">Terms</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>Start Practising</h5>
                <p class="mb-2">Preparing for MDCAT, ECAT, CSS or school exams? Pick your test type and start free MCQs.</p>
                <a class="btn btn-sk-cyan" href="{{ route('test-types.index') }}">Browse Test Types</a>
            </div>
        </div>
        <div class="sk-footer-bottom d-flex justify-content-between flex-wrap gap-2">
            <span>&copy; <?= date('Y') ?> Skoolyst MCQs. All rights reserved.</span>
            <span>Part of the Skoolyst Ecosystem</span>
        </div>
    </div>
</footer>