@extends('layouts.app')

<?php $metaDescription = 'About Skoolyst MCQs: a free MCQ practice platform for MDCAT, ECAT, CSS, PPSC and school exams in Pakistan, with topic-wise practice and timed mock tests.'; ?>
@section('title', 'About Us')
@section('meta_description', $metaDescription)

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'About', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>About Skoolyst MCQs</h1>
        <p>Exam preparation made simple for students in Pakistan.</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 sk-prose">
                <h2>What is Skoolyst MCQs?</h2>
                <p>Skoolyst MCQs is a practice platform where students can solve multiple choice questions subject by subject and topic by topic, see the correct answer with an explanation, and test themselves with timed mock tests that follow real exam conditions.</p>

                <h2>What you can do here</h2>
                <ul>
                    <li>Practice MCQs for MDCAT, ECAT, CSS, PPSC and school exams.</li>
                    <li>Study by <a href="{{ route('subjects.index') }}">subject</a> or by <a href="{{ route('test-types.index') }}">test type</a>.</li>
                    <li>Take timed <a href="{{ route('mock-tests.index') }}">mock tests</a> and review your results.</li>
                    <li>Create a free account to keep track of your attempts and progress.</li>
                </ul>

                <h2>Part of Skoolyst</h2>
                <p>Skoolyst MCQs is one of the products in the Skoolyst education ecosystem. Learn more about the wider platform at <a href="https://skoolyst.com">skoolyst.com</a>.</p>

                <p class="text-secondary-custom mt-4">See also our <a href="{{ route('privacy-policy') }}">Privacy Policy</a> and <a href="{{ route('terms') }}">Terms of Service</a>.</p>
            </div>
        </div>
    </div>
</section>
@endsection
