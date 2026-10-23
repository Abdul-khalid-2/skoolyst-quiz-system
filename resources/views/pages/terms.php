@extends('layouts.app')

@section('title', 'Terms of Service')
@section('meta_description', 'Terms of Service for Skoolyst MCQs — the rules for using our MCQ practice and mock test platform.')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Terms of Service', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Terms of Service</h1>
        <p>Last updated: October 2, 2026</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 sk-prose">

                <h2>1. Acceptance of Terms</h2>
                <p>By accessing or using Skoolyst MCQs ("the Service", "we", "us"), you agree to be bound by these Terms of Service. If you do not agree, please do not use the Service.</p>

                <h2>2. Who Can Use the Service</h2>
                <p>Skoolyst MCQs is intended for students preparing for exams such as MDCAT, ECAT, and school/college assessments. You must provide accurate information when creating an account and are responsible for maintaining the confidentiality of your login credentials.</p>

                <h2>3. Account Creation and Sign-In Options</h2>
                <p>You can create an account directly with your email and password, or sign in using <strong>Login with Skoolyst</strong> (your account on skoolyst.com) or <strong>Continue with Google</strong>. When you use either of these, we receive your basic identity (name, email, and a stable account ID) from that provider to create or match your local account — we never receive or store your Skoolyst or Google password.</p>

                <h2>4. Acceptable Use</h2>
                <p>You agree not to:</p>
                <ul>
                    <li>Attempt to copy, scrape, or redistribute our MCQ content in bulk without permission.</li>
                    <li>Interfere with or disrupt the Service, its servers, or networks.</li>
                    <li>Use automated scripts or bots to create accounts, submit practice attempts, or manipulate statistics.</li>
                    <li>Upload or submit content that is unlawful, abusive, or infringes on the rights of others.</li>
                    <li>Attempt to gain unauthorized access to the admin dashboard or any other user's account.</li>
                </ul>

                <h2>5. Content and Intellectual Property</h2>
                <p>MCQs, explanations, mock tests, and other educational content on the Service are provided for personal study purposes. Unless otherwise stated, this content is the property of Skoolyst MCQs or its licensors and may not be reproduced or redistributed commercially without written permission.</p>

                <h2>6. Practice Results and Mock Test Attempts</h2>
                <p>Your practice sessions, mock test attempts, scores, and answer history are recorded against your account so you can track your progress over time. We make reasonable efforts to keep this data accurate but do not guarantee it will never be lost or reset.</p>

                <h2>7. Advertisements</h2>
                <p>The Service may display advertisements served through the shared Skoolyst Ad Engine. We are not responsible for the content of third-party advertisements or the websites they link to.</p>

                <h2>8. Account Suspension and Termination</h2>
                <p>We may suspend or terminate accounts that violate these Terms, engage in abusive behavior, or attempt to compromise the integrity of the Service. You may stop using the Service and request account deletion at any time.</p>

                <h2>9. Disclaimer of Warranties</h2>
                <p>The Service is provided "as is" without warranties of any kind. While we strive for accuracy, we do not guarantee that MCQ content, explanations, or mock test scoring are free of errors, or that the Service will be uninterrupted or error-free.</p>

                <h2>10. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, Skoolyst MCQs shall not be liable for any indirect, incidental, or consequential damages arising from your use of, or inability to use, the Service, including reliance on any MCQ content for exam preparation outcomes.</p>

                <h2>11. Changes to These Terms</h2>
                <p>We may update these Terms from time to time. Continued use of the Service after changes are posted constitutes acceptance of the revised Terms.</p>

                <h2>12. Contact</h2>
                <p>Questions about these Terms can be sent to our support team through the contact details listed on <a href="https://skoolyst.com">skoolyst.com</a>.</p>

                <p class="text-secondary-custom mt-4">See also our <a href="{{ route('privacy-policy') }}">Privacy Policy</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
