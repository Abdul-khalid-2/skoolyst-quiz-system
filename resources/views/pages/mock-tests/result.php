@extends('layouts.app')

@section('title', 'Mock Test Result')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => route('mock-tests.index')], ['label' => 'Result', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-check me-2"></i>Mock Test Result</h1>
        <p>MDCAT Full Mock Test #1 — Your Performance Report</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div id="sk-result-container" data-type="mock"></div>
    </div>
</section>
@endsection
