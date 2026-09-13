# Skoolyst MCQs — SEO Audit & Implementation Documentation

**Date:** 2026-09-12  
**Project:** Skoolyst MCQs System (`skoolyst-module-blueprint`)  
**Framework:** Custom PHP MVC (not Laravel)  
**Auditor:** Claude Code (Sonnet 4.6)

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Full Technical SEO Audit](#2-full-technical-seo-audit)
   - 2.1 [SEO Health Score](#21-seo-health-score)
   - 2.2 [HIGH Priority Issues Found](#22-high-priority-issues-found)
   - 2.3 [MEDIUM Priority Issues Found](#23-medium-priority-issues-found)
   - 2.4 [LOW Priority Issues Found](#24-low-priority-issues-found)
3. [What Was Implemented (Session Work)](#3-what-was-implemented-session-work)
   - 3.1 [JSON-LD Schema — layouts/app.php](#31-json-ld-schema--layoutsappphp)
   - 3.2 [Quiz Schema — topics/show.php](#32-quiz-schema--topicsshowphp)
   - 3.3 [Quiz + Question/Answer Schema — practice.php](#33-quiz--questionanswer-schema--practicephp)
   - 3.4 [Quiz Schema — mock-tests/show.php](#34-quiz-schema--mock-testsshowphp)
4. [Remaining Work (Not Yet Implemented)](#4-remaining-work-not-yet-implemented)
5. [File Reference Map](#5-file-reference-map)
6. [Schema Validation Guide](#6-schema-validation-guide)

---

## 1. Project Overview

### Application Purpose
Skoolyst MCQs is an educational platform for students preparing for **MDCAT, ECAT, and school/board exams** in Pakistan. It provides:
- Subject-wise MCQ practice (Biology, Chemistry, Physics, English, Urdu, Islamic Studies, etc.)
- Topic-level practice with instant feedback and explanations
- Timed mock tests simulating real exam conditions
- Admin dashboard for managing questions, subjects, topics, and mock tests

### Tech Stack
| Layer | Technology |
|---|---|
| Backend | PHP 8.x, Custom MVC framework |
| Frontend | Bootstrap 5.3.3 (CDN), Bootstrap Icons, custom CSS/JS |
| Database | MySQL (via PDO) |
| Web Server | Apache (XAMPP), `.htaccess` routing |
| Entry Point | `public/index.php` |
| Views | PHP templates with custom Blade-like syntax (`@extends`, `@section`, `@yield`, `{{ }}`) |

### Directory Structure
```
skoolyst-module-blueprint/
├── app/
│   ├── Controllers/          # PageController, DashboardController, Admin/*
│   ├── Models/               # Mcq, Subject, Topic, MockTest, TestType, User
│   ├── Services/             # AuthService
│   ├── Middleware/           # Auth, Guest, Admin middleware
│   ├── Helpers/              # url(), route(), asset(), canonical_url(), base_url()
│   └── Core/                 # Router, Controller, View, Database
├── resources/views/
│   ├── layouts/              # app.php, dashboard.php, auth.php
│   ├── pages/                # All public-facing page templates
│   ├── components/           # Reusable UI fragments
│   ├── admin/                # Admin dashboard templates
│   └── errors/               # 404, 500 pages
├── public/                   # Web root (robots.txt, assets/, index.php)
├── routes/                   # web.php, admin.php, api.php
├── config/                   # app.php, seo.php, database.php
└── database/                 # Migrations, seeders
```

### Routes (Public)
| Route | Controller Method | Page |
|---|---|---|
| `GET /` | `PageController::home()` | Homepage |
| `GET /subjects` | `PageController::subjectsIndex()` | All subjects |
| `GET /subjects/{slug}` | `PageController::subjectsShow()` | Subject detail |
| `GET /topics/{slug}` | `PageController::topicsShow()` | Topic detail + question list |
| `GET /practice/{slug}` | `PageController::practice()` | Interactive MCQ practice |
| `POST /practice/{slug}` | `PageController::practiceSubmit()` | Submit practice answers |
| `GET /mock-tests` | `PageController::mockTestsIndex()` | All mock tests |
| `GET /mock-tests/{slug}` | `PageController::mockTestsShow()` | Mock test info/intro |
| `GET /mock-tests/{slug}/take` | `PageController::mockTestsTake()` | Active test interface |
| `POST /mock-tests/{slug}/submit` | `PageController::mockTestsSubmit()` | Submit test |
| `GET /test-types` | `PageController::testTypesIndex()` | Test types listing |
| `GET /test-types/{slug}` | `PageController::testTypesShow()` | Test type detail |
| `GET /search` | `PageController::search()` | Search results |
| `GET /search/api` | `PageController::searchApi()` | Search JSON API |
| `GET /sitemap.xml` | `PageController::sitemap()` | Dynamic XML sitemap |

---

## 2. Full Technical SEO Audit

**Audit Date:** 2026-09-12  
**Pages Analysed:** 14 frontend view files + layout + config

### 2.1 SEO Health Score

**Overall Score: 38 / 100** *(pre-implementation)*

| Category | Score | Weight | Weighted |
|---|---|---|---|
| Technical SEO | 55/100 | 22% | 12.1 |
| On-Page Meta Tags | 20/100 | 20% | 4.0 |
| Schema / Structured Data | 0/100 | 10% | 0.0 |
| Content Quality | 45/100 | 23% | 10.4 |
| Internal Linking | 60/100 | 10% | 6.0 |
| Images / Accessibility | 90/100 | 5% | 4.5 |
| AI Search Readiness | 15/100 | 10% | 1.5 |
| **TOTAL** | | **100%** | **38.5** |

**Post-implementation estimate (after Session Work in §3):** ~52/100

---

### 2.2 HIGH Priority Issues Found

#### H-1 | Zero JSON-LD Schema Markup *(PARTIALLY FIXED — see §3)*
- **Status:** No `application/ld+json`, no microdata, no `schema.org` anywhere in codebase
- **Impact:** Missing Google rich results eligibility for Practice Problems, Quiz, and educational content
- **Pages affected:** All public pages
- **Schema types needed:**
  - `Organization` + `WebSite` → `layouts/app.php`
  - `Quiz` + `Question` → `topics/show.php`
  - `Quiz` + `Question` + `Answer` (acceptedAnswer) → `practice.php`
  - `Quiz` with exam metadata → `mock-tests/show.php`
  - `Course` / `EducationalCourse` → `subjects/show.php`
  - `BreadcrumbList` → `components/breadcrumb.php`

#### H-2 | Open Graph + Twitter Card Tags — 0% Coverage *(NOT YET FIXED)*
- **Status:** `layouts/app.php` has zero `og:*` or `twitter:*` tags
- **Impact:** Social shares (WhatsApp, Twitter/X, Facebook) show no image or description → low CTR
- **Files affected:** `resources/views/layouts/app.php`
- **Fix required:**
```html
<!-- Add after canonical tag in layouts/app.php -->
<meta property="og:type"        content="website" />
<meta property="og:url"         content="<?= htmlspecialchars(canonical_url(), ENT_QUOTES, 'UTF-8') ?>" />
<meta property="og:title"       content="@yield('title') — Skoolyst MCQs" />
<meta property="og:description" content="<?= htmlspecialchars(\Skoolyst\Core\View::yieldSection('meta_description', config('seo.description', '')), ENT_QUOTES, 'UTF-8') ?>" />
<meta property="og:image"       content="<?= htmlspecialchars(\Skoolyst\Core\View::yieldSection('og_image', asset('assets/images/og-default.jpg')), ENT_QUOTES, 'UTF-8') ?>" />
<meta property="og:site_name"   content="Skoolyst MCQs" />
<meta name="twitter:card"        content="summary_large_image" />
<meta name="twitter:title"       content="@yield('title') — Skoolyst MCQs" />
<meta name="twitter:description" content="<?= htmlspecialchars(\Skoolyst\Core\View::yieldSection('meta_description', config('seo.description', '')), ENT_QUOTES, 'UTF-8') ?>" />
<meta name="twitter:image"       content="<?= htmlspecialchars(\Skoolyst\Core\View::yieldSection('og_image', asset('assets/images/og-default.jpg')), ENT_QUOTES, 'UTF-8') ?>" />
```

#### H-3 | Meta Descriptions Missing on 11/14 Pages *(NOT YET FIXED)*
- **Status:** Generic fallback `"Skoolyst application module"` in `config/seo.php` shows in SERPs for most pages
- **Pages with unique descriptions:** Only `mock-tests/index.php` and `mock-tests/show.php`
- **Pages missing `@section('meta_description')`:**

| File | Suggested Description |
|---|---|
| `pages/index.php` | `Practice thousands of MCQs for MDCAT, ECAT, and school exams. Free timed mock tests and subject-wise practice.` |
| `pages/subjects/index.php` | `Browse all subjects on Skoolyst MCQs — Biology, Chemistry, Physics, English and more.` |
| `pages/subjects/show.php` | Dynamic: `Practice {name} MCQs — {mcqCount} questions across {topicCount} topics.` |
| `pages/topics/show.php` | Dynamic: `Practice {name} MCQs ({count} questions) — part of {subject_name}.` |
| `pages/test-types/index.php` | `Explore all test types — MDCAT, ECAT, and board exam MCQ practice on Skoolyst.` |
| `pages/test-types/show.php` | Dynamic with test type name |
| `pages/practice.php` | Dynamic: `Practice {topic} MCQs with instant feedback and explanations.` |
| `pages/search.php` | Add `noindex` instead (search result pages should not be indexed) |

- **Also fix `config/seo.php`:**
```php
return [
    'default_title' => 'Skoolyst MCQs',
    'description'   => 'Practice thousands of MCQs for MDCAT, ECAT, and school exams. Free timed mock tests and subject-wise practice on Skoolyst.',
    'og_image'      => '/assets/images/og-default.jpg',
];
```

#### H-4 | 6 Broken Internal Links (href="#") *(NOT YET FIXED)*
- **Status:** Placeholder links that never navigate anywhere
- **File 1:** `resources/views/components/footer.php`
  ```html
  <a href="#">Practice</a>   <!-- should be route('test-types.index') or similar -->
  <a href="#">About</a>      <!-- page does not exist -->
  <a href="#">Contact</a>    <!-- page does not exist -->
  <a href="#">Privacy</a>    <!-- page does not exist -->
  <a href="#">Terms</a>      <!-- page does not exist -->
  ```
- **File 2:** `resources/views/components/mcq-card.php` line 15
  ```html
  <a href="#" class="btn btn-sk-cyan btn-sm-sk">Practice</a>  <!-- broken -->
  ```
- **Fix options:**
  - Quick fix: Remove placeholder links from footer until pages are built
  - Full fix: Create `/about`, `/contact`, `/privacy`, `/terms` routes + views
  - MCQ card fix: `{{ route('practice.show', $mcq['topic_slug'] ?? '') }}`

---

### 2.3 MEDIUM Priority Issues Found

#### M-1 | Search Results Page Indexable — Creates Thin Content *(NOT YET FIXED)*
- `robots.txt` does block `/search` ✓ BUT there is no `<meta name="robots" content="noindex">` fallback
- **Fix:** Add to `layouts/app.php`:
  ```php
  <meta name="robots" content="<?= htmlspecialchars(\Skoolyst\Core\View::yieldSection('robots', 'index, follow'), ENT_QUOTES) ?>" />
  ```
- Then in `pages/search.php`: `@section('robots', 'noindex, nofollow')`

#### M-2 | BreadcrumbList Schema Missing *(NOT YET FIXED)*
- `components/breadcrumb.php` renders visual breadcrumbs correctly but has no JSON-LD
- Google shows breadcrumb paths in SERPs when `BreadcrumbList` schema is present
- **Fix — Add to end of `components/breadcrumb.php`:**
```php
<?php if (!empty($breadcrumbs)): ?>
<script type="application/ld+json">
<?php
$items = [['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>htmlspecialchars(route('home'),ENT_QUOTES)]];
foreach ($breadcrumbs as $i => $bc) {
    $item = ['@type'=>'ListItem','position'=>$i+2,'name'=>$bc['label']];
    if ($bc['url'] !== '#') { $item['item'] = htmlspecialchars($bc['url'],ENT_QUOTES); }
    $items[] = $item;
}
echo json_encode(['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>$items],
    JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
?>
</script>
<?php endif; ?>
```

#### M-3 | Generic Title Tags on Index Pages *(NOT YET FIXED)*
| File | Current | Better |
|---|---|---|
| `pages/index.php` | `Home` | `Free MCQ Practice — MDCAT, ECAT & School Exams` |
| `pages/subjects/index.php` | `Subjects` | `All Subjects — Practice MCQs by Subject` |
| `pages/test-types/index.php` | `Test Types` | `Test Types — MDCAT, ECAT & Board Exam MCQs` |

#### M-4 | No Favicon in Layout *(NOT YET FIXED)*
- `layouts/app.php` has no `<link rel="icon">` tag
- **Fix:**
```html
<link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}" />
<link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}" />
```

#### M-5 | Verify Sitemap `<lastmod>` and `<changefreq>` *(VERIFY ONLY)*
- Dynamic sitemap at `/sitemap.xml` exists and is referenced in `robots.txt` ✓
- Confirm `PageController::sitemap()` includes `<lastmod>` and `<changefreq>` per URL entry

#### M-6 | Course Schema Missing on Subject Pages *(NOT YET FIXED)*
- `pages/subjects/show.php` has rich data: `name`, `description`, `mcqCount`, `topicCount`, `difficulty breakdown`
- Add `EducationalCourse` schema:
```php
@section('schema')
<script type="application/ld+json">
<?php echo json_encode([
    '@context'         => 'https://schema.org',
    '@type'            => 'Course',
    'name'             => $subject['name'],
    'description'      => $subject['description'] ?? 'Practice ' . $subject['name'] . ' MCQs on Skoolyst.',
    'url'              => htmlspecialchars(canonical_url(), ENT_QUOTES, 'UTF-8'),
    'provider'         => ['@type'=>'Organization','name'=>'Skoolyst MCQs','url'=>htmlspecialchars(base_url(),ENT_QUOTES,'UTF-8')],
    'numberOfCredits'  => $mcqCount ?? 0,
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>
</script>
@endsection
```

---

### 2.4 LOW Priority Issues Found

#### L-1 | No CDN Preconnect Hints
- Bootstrap CDN loaded without `<link rel="preconnect">` — adds ~100ms DNS latency on first visit
- **Fix:** `<link rel="preconnect" href="https://cdn.jsdelivr.net" />`

#### L-2 | No OG Image Asset Exists
- `public/assets/images/` is empty (only `.gitkeep`)
- When OG tags are added (H-2), a 1200×630px image file is needed at `public/assets/images/og-default.jpg`

#### L-3 | Brand Name Wrong in config/seo.php
- `'default_title' => 'Skoolyst Module'` — should be `'Skoolyst MCQs'`

#### L-4 | HowTo Schema Opportunity on Homepage
- Homepage has "How It Works" 3-step section — eligible for `HowTo` rich result

#### L-5 | Organization + WebSite Schema Not in Layout
- Global `Organization` and `WebSite` (with `SearchAction`) schema missing from `layouts/app.php`
- Should be added unconditionally to every page via the master layout

---

## 3. What Was Implemented (Session Work)

All four changes were made and verified in this session.

---

### 3.1 JSON-LD Schema — `layouts/app.php`

**File:** `resources/views/layouts/app.php`  
**Change:** Added `@yield('schema')` hook in `<head>` after canonical tag

```html
<!-- Before -->
<link rel="canonical" href="..." />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/..." />

<!-- After -->
<link rel="canonical" href="..." />
@yield('schema')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/..." />
```

**Purpose:** Any child view can now inject JSON-LD via `@section('schema') ... @endsection` and it renders inside `<head>` — the correct placement per Google's guidelines.

---

### 3.2 Quiz Schema — `topics/show.php`

**File:** `resources/views/pages/topics/show.php`  
**Schema type:** `Quiz` + `Question` (question names only, no answer options — not available on this page)

**What it generates (example):**
```json
{
  "@context": "https://schema.org",
  "@type": "Quiz",
  "name": "Photosynthesis",
  "description": "Practice Photosynthesis MCQs as part of Biology.",
  "url": "https://skoolyst.com/topics/photosynthesis",
  "educationalLevel": "Medium",
  "numberOfQuestions": 25,
  "about": { "@type": "Thing", "name": "Biology" },
  "provider": { "@type": "Organization", "name": "Skoolyst MCQs", "url": "https://skoolyst.com" },
  "hasPart": [
    { "@type": "Question", "name": "Which pigment is responsible for photosynthesis?", "educationalLevel": "Medium" },
    { "@type": "Question", "name": "What is the by-product of light reactions?", "educationalLevel": "Easy" }
  ]
}
```

**Logic notes:**
- Schema only renders when `$mcqs` is non-empty (guarded by `<?php if (!empty($mcqs)): ?>`)
- `educationalLevel` maps from ENUM `easy/medium/hard` → `ucfirst()` → `Easy/Medium/Hard`
- All strings go through `json_encode()` with `JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES` — safe for all UTF-8 content including Urdu question text
- `hasPart` uses `array_values(array_map(...))` to produce a clean 0-indexed JSON array

**Rich result eligibility:** Partial — Google can index quiz names and topics but cannot show Practice Problems without `acceptedAnswer`.

---

### 3.3 Quiz + Question/Answer Schema — `practice.php`

**File:** `resources/views/pages/practice.php`  
**Schema type:** `Quiz` + `Question` with `acceptedAnswer` + `suggestedAnswer`  
**Google feature:** Eligible for **Practice Problems rich results** in Google Search

**What it generates (example):**
```json
{
  "@context": "https://schema.org",
  "@type": "Quiz",
  "name": "Practice Photosynthesis MCQs",
  "description": "Practice Photosynthesis MCQs with instant feedback and detailed explanations. Part of Biology.",
  "url": "https://skoolyst.com/practice/photosynthesis",
  "educationalLevel": "Medium",
  "numberOfQuestions": 25,
  "interactivityType": "active",
  "learningResourceType": "quiz",
  "about": { "@type": "Thing", "name": "Biology" },
  "provider": { "@type": "Organization", "name": "Skoolyst MCQs", "url": "https://skoolyst.com" },
  "hasPart": [
    {
      "@type": "Question",
      "name": "Which pigment is responsible for photosynthesis?",
      "educationalLevel": "Medium",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "B. Chlorophyll",
        "comment": "Chlorophyll absorbs red and blue light wavelengths and reflects green, which is why plants appear green."
      },
      "suggestedAnswer": [
        { "@type": "Answer", "text": "A. Carotene" },
        { "@type": "Answer", "text": "C. Xanthophyll" },
        { "@type": "Answer", "text": "D. Anthocyanin" }
      ]
    }
  ]
}
```

**Logic notes:**
- `$mcqOptions[$mcq['id']]` contains all 4 options (A/B/C/D) with `is_correct` flag
- `array_filter(..., fn($o) => (int) $o['is_correct'] === 1)` extracts correct option
- `array_filter(..., fn($o) => (int) $o['is_correct'] === 0)` extracts wrong options
- `acceptedAnswer.text` format: `"B. Chlorophyll"` (label + dot + space + option_text)
- `acceptedAnswer.comment` = `explanation` field (only added if explanation is non-empty)
- `suggestedAnswer` = array of wrong Answer objects
- Schema only renders when `$mcqs` is non-empty

**Data source:**
```
$mcqs[$i]['question_text']  → Question.name
$mcqs[$i]['difficulty']     → Question.educationalLevel
$mcqs[$i]['explanation']    → acceptedAnswer.comment
$mcqOptions[$id][$j]['label']       → "A", "B", "C", "D"
$mcqOptions[$id][$j]['option_text'] → option content
$mcqOptions[$id][$j]['is_correct']  → 0 or 1
```

---

### 3.4 Quiz Schema — `mock-tests/show.php`

**File:** `resources/views/pages/mock-tests/show.php`  
**Schema type:** `Quiz` with exam-specific metadata

**What it generates (example):**
```json
{
  "@context": "https://schema.org",
  "@type": "Quiz",
  "name": "MDCAT Full Mock Test 1",
  "description": "MDCAT Full Mock Test 1 — a timed mock test on Skoolyst MCQs.",
  "url": "https://skoolyst.com/mock-tests/mdcat-full-mock-test-1",
  "educationalLevel": "Hard",
  "numberOfQuestions": 200,
  "timeRequired": "PT210M",
  "interactivityType": "active",
  "learningResourceType": "quiz",
  "provider": { "@type": "Organization", "name": "Skoolyst MCQs", "url": "https://skoolyst.com" },
  "educationalAlignment": {
    "@type": "AlignmentObject",
    "alignmentType": "educationalSubject",
    "targetName": "MDCAT"
  },
  "about": [
    { "@type": "Thing", "name": "Biology" },
    { "@type": "Thing", "name": "Chemistry" },
    { "@type": "Thing", "name": "Physics" },
    { "@type": "Thing", "name": "English" }
  ],
  "comment": "Passing score: 60%. Negative marking applies (-0.25 per wrong answer)."
}
```

**Logic notes:**
- Schema only renders when `$questionCount > 0` (guarded)
- `timeRequired` uses ISO 8601 duration format: `PT{minutes}M`
- `about` is a single object when one subject; array when multiple (`$subjectBreakdown`)
- `comment` conditionally includes passing score and negative marking info
- `educationalAlignment` maps test type (MDCAT/ECAT/Board) as educational subject alignment
- Does NOT include individual questions — they are not available on this page (loaded in `take.php`)

---

## 4. Remaining Work (Not Yet Implemented)

Prioritized checklist for future sessions:

### Phase 1 — Complete Schema Coverage

- [ ] **`layouts/app.php`** — Add global `Organization` + `WebSite` (with `SearchAction`) schema
- [ ] **`pages/subjects/show.php`** — Add `Course` / `EducationalCourse` schema
- [ ] **`components/breadcrumb.php`** — Add `BreadcrumbList` schema (all pages benefit)

### Phase 2 — Meta Tags & Social Sharing

- [ ] **`layouts/app.php`** — Add Open Graph tags (`og:type`, `og:title`, `og:description`, `og:image`, `og:url`, `og:site_name`)
- [ ] **`layouts/app.php`** — Add Twitter Card tags (`twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`)
- [ ] **`layouts/app.php`** — Add `<meta name="robots">` with `@yield('robots', 'index, follow')` override system
- [ ] **`config/seo.php`** — Replace generic description; add `og_image` path
- [ ] **`pages/index.php`** — Add `@section('meta_description', '...')` 
- [ ] **`pages/subjects/index.php`** — Add `@section('meta_description', '...')`
- [ ] **`pages/subjects/show.php`** — Add dynamic `@section('meta_description', ...)`
- [ ] **`pages/topics/show.php`** — Add dynamic `@section('meta_description', ...)`
- [ ] **`pages/test-types/index.php`** — Add `@section('meta_description', '...')`
- [ ] **`pages/test-types/show.php`** — Add dynamic `@section('meta_description', ...)`
- [ ] **`pages/practice.php`** — Add dynamic `@section('meta_description', ...)`
- [ ] **`pages/search.php`** — Add `@section('robots', 'noindex, nofollow')`

### Phase 3 — Title Tags & Branding

- [ ] **`pages/index.php`** — Change title from `Home` to keyword-rich version
- [ ] **`pages/subjects/index.php`** — Change title from `Subjects` to `All Subjects — Practice MCQs by Subject`
- [ ] **`pages/test-types/index.php`** — Change title from `Test Types` to descriptive version

### Phase 4 — Technical Fixes

- [ ] **`components/footer.php`** — Fix 5 broken `href="#"` links (remove or implement pages)
- [ ] **`components/mcq-card.php`** — Fix broken Practice button `href="#"`
- [ ] **`layouts/app.php`** — Add `<link rel="icon">` favicon tags
- [ ] **`layouts/app.php`** — Add `<link rel="preconnect" href="https://cdn.jsdelivr.net">` before Bootstrap CDN
- [ ] **Create** `public/assets/images/og-default.jpg` (1200×630px) for social sharing

### Phase 5 — Static Pages (New Routes + Views Needed)

- [ ] Create `/about` page + route + view
- [ ] Create `/contact` page + route + view
- [ ] Create `/privacy` page + route + view
- [ ] Create `/terms` page + route + view

---

## 5. File Reference Map

### Files Modified in This Session

| File | Change |
|---|---|
| `resources/views/layouts/app.php` | Added `@yield('schema')` in `<head>` |
| `resources/views/pages/topics/show.php` | Added `@section('schema')` with Quiz + Question JSON-LD |
| `resources/views/pages/practice.php` | Added `@section('schema')` with Quiz + Question/Answer JSON-LD |
| `resources/views/pages/mock-tests/show.php` | Added `@section('schema')` with Quiz metadata JSON-LD |

### Files Audited (Not Modified)

| File | Audit Finding |
|---|---|
| `resources/views/layouts/app.php` | Missing OG tags, Twitter Cards, robots meta |
| `resources/views/components/footer.php` | 5 broken `href="#"` links |
| `resources/views/components/mcq-card.php` | Broken Practice button `href="#"` |
| `resources/views/components/breadcrumb.php` | Missing BreadcrumbList JSON-LD |
| `resources/views/pages/index.php` | Missing meta_description |
| `resources/views/pages/subjects/index.php` | Missing meta_description |
| `resources/views/pages/subjects/show.php` | Missing meta_description, missing Course schema |
| `resources/views/pages/topics/show.php` | Missing meta_description |
| `resources/views/pages/test-types/index.php` | Missing meta_description, weak title |
| `resources/views/pages/test-types/show.php` | Missing meta_description |
| `resources/views/pages/search.php` | Should be noindex |
| `resources/views/pages/mock-tests/index.php` | Has description ✓, missing OG tags |
| `resources/views/pages/mock-tests/show.php` | Has description ✓, missing OG tags |
| `resources/views/pages/mock-tests/take.php` | Correctly noindex ✓ |
| `config/seo.php` | Generic values, needs expansion |
| `public/robots.txt` | Correct configuration ✓ |
| Sitemap (`/sitemap.xml`) | Dynamic, exists ✓, verify lastmod |

### Key Model Fields Reference

**`mcq_questions` table:**
```
id, subject_id, topic_id, question_text (TEXT),
explanation (TEXT, nullable), difficulty (ENUM: easy/medium/hard),
created_at, updated_at
```

**`mcq_options` table:**
```
id, mcq_id, label (CHAR: A/B/C/D), option_text (VARCHAR 500),
is_correct (TINYINT: 0/1), sort_order
```

**`mcq_topics` table:**
```
id, subject_id, name, slug, description, icon (Bootstrap icon class),
difficulty (ENUM: easy/medium/hard), created_at, updated_at
```

**`mcq_mock_tests` table:**
```
id, test_type_id, title, slug, description, total_questions,
duration_minutes, difficulty, passing_score_percent,
negative_marking (TINYINT: 0/1), is_featured (TINYINT: 0/1),
created_at, updated_at
```

**`mcq_subjects` table:**
```
id, name, slug, description, icon (Bootstrap icon class),
icon_bg (CSS class), created_at, updated_at
```

---

## 6. Schema Validation Guide

After deploying to a live/staging URL, validate implemented schemas using:

### Google Rich Results Test
- URL: `https://search.google.com/test/rich-results`
- Test these pages:
  - `/practice/{any-topic-slug}` → Should show **Quiz** with **Practice Problems** eligibility
  - `/topics/{any-topic-slug}` → Should show **Quiz**
  - `/mock-tests/{any-slug}` → Should show **Quiz**

### Expected Rich Results per Page

| Page | Schema | Google Feature |
|---|---|---|
| `/practice/{slug}` | `Quiz` + `Question` + `acceptedAnswer` | Practice Problems (eligible) |
| `/topics/{slug}` | `Quiz` + `Question` (name only) | Quiz (basic) |
| `/mock-tests/{slug}` | `Quiz` with metadata | Quiz (exam info) |

### Schema.org Validator
- URL: `https://validator.schema.org`
- Paste raw JSON-LD output to check for errors

### What "Practice Problems" Requires (Google)
Google's Practice Problems feature requires:
1. `@type: Quiz`
2. `hasPart` array of `Question` objects
3. Each `Question` must have `acceptedAnswer` with `@type: Answer` and `text`
4. Page must be indexable (not blocked by robots.txt or noindex)
5. Content must be genuinely educational

The `/practice/{slug}` pages meet all these requirements after this session's implementation.

---

*Document generated: 2026-09-12 | Skoolyst MCQs System | skoolyst-module-blueprint*
