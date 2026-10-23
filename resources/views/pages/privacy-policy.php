@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'Privacy Policy for Skoolyst MCQs — what information we collect, how we use it, and the third-party services we rely on.')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Privacy Policy', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: October 2, 2026</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 sk-prose">

                <h2>1. Information We Collect</h2>
                <p>When you create an account directly, we collect your <strong>name</strong>, <strong>email address</strong>, and a securely hashed <strong>password</strong> (we never store your password in plain text). If you sign in with <strong>Login with Skoolyst</strong> or <strong>Continue with Google</strong>, we receive your name, email address, and a stable account ID from that provider instead — your password with that provider is never shared with us.</p>
                <p>We also store the <strong>practice attempts</strong>, <strong>mock test attempts</strong>, and <strong>answers/scores</strong> associated with your account, so you can track your progress.</p>

                <h2>2. How We Use Your Information</h2>
                <ul>
                    <li>To create and manage your account, and let you log in.</li>
                    <li>To track your MCQ practice and mock test history and show you your progress.</li>
                    <li>To send you account-related emails (e.g. a welcome email when you sign up).</li>
                    <li>To maintain the security and integrity of the Service.</li>
                </ul>

                <h2>3. Third-Party Services We Use</h2>
                <p>Skoolyst MCQs is part of the Skoolyst family of apps and relies on a few shared, first-party Skoolyst services to operate:</p>
                <ul>
                    <li><strong>Skoolyst Ad Engine</strong> (ads.skoolyst.com) — serves advertisements shown on certain pages.</li>
                    <li><strong>Skoolyst Email API</strong> (ads.skoolyst.com) — sends transactional emails on our behalf, such as welcome emails and account activity notifications. We send your email address and the message content to this service solely to deliver the email.</li>
                    <li><strong>Login with Skoolyst</strong> (skoolyst.com) — an optional single sign-on method. If you use it, skoolyst.com shares your basic profile (name, email, account ID) with us after you authenticate there.</li>
                    <li><strong>Google Sign-In</strong> (accounts.google.com) — an optional single sign-on method. If you use it, Google shares your basic profile (name, email, account ID, email-verification status) with us after you authenticate with Google, under Google's own privacy policy.</li>
                </ul>
                <p>We do not sell your personal information to advertisers or any third party.</p>

                <h2>4. Cookies and Sessions</h2>
                <p>We use a session cookie to keep you logged in and to protect forms against cross-site request forgery (CSRF). This cookie is necessary for the Service to function and does not track you across other websites.</p>

                <h2>5. Data Retention</h2>
                <p>We retain your account information and practice/mock test history for as long as your account remains active, or as needed to provide the Service. You may request deletion of your account and associated data at any time.</p>

                <h2>6. Your Rights</h2>
                <p>You may request access to, correction of, or deletion of your personal information by contacting us. If you signed up via Login with Skoolyst or Google, you can also manage that connection from your account on the respective provider.</p>

                <h2>7. Children's Privacy</h2>
                <p>Skoolyst MCQs is intended for students preparing for secondary and higher-secondary level exams. We do not knowingly collect personal information from children under the age required by applicable law to use online services without parental consent.</p>

                <h2>8. Data Security</h2>
                <p>We use industry-standard practices such as password hashing and HTTPS to protect your information. However, no method of transmission or storage is 100% secure, and we cannot guarantee absolute security.</p>

                <h2>9. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. The "Last updated" date at the top of this page will reflect the most recent changes.</p>

                <h2>10. Contact</h2>
                <p>Questions about this Privacy Policy can be sent to our support team through the contact details listed on <a href="https://skoolyst.com">skoolyst.com</a>.</p>

                <p class="text-secondary-custom mt-4">See also our <a href="{{ route('terms') }}">Terms of Service</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
