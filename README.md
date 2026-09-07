# 🎓 Skoolyst MCQs - Quiz System

> A comprehensive Multiple Choice Questions (MCQ) and Quiz management platform built with a **custom Core PHP MVC architecture** (no framework, no Composer package like Laravel/Symfony) for schools and educational institutions.

**Repository:** [https://github.com/Abdul-khalid-2/skoolyst-quiz-system](https://github.com/Abdul-khalid-2/skoolyst-quiz-system)

---

## 📊 Project Overview

**Skoolyst MCQs** is a standalone educational platform designed to:
- 📚 Host thousands of MCQs across multiple subjects
- 🎯 Support various exam types (MDCAT, ECAT, School Exams, etc.)
- 🧪 Provide mock tests with exam-like conditions
- 📈 Track student performance and progress
- 🎨 Deliver a seamless user experience with modern UI

**Technology Stack:**
- **Backend:** PHP 8.2+ (Custom MVC Structure — no framework; see [ARCHITECTURE.md](./ARCHITECTURE.md))
- **Frontend:** Plain PHP templates (component-based, `resources/views/`), Bootstrap 5, Vanilla JavaScript
- **Database:** MySQL (via raw PDO in `app/Core/Database.php`)
- **Assets:** Bootstrap Icons, Tailwind CSS
- **Tools:** Composer, Git

---

## 🚀 Project Timeline & Phases

This document serves as a **progress tracker** for all development phases. Each phase contains actionable tasks organized by feature.

---

# 📅 PHASE 1: Foundation & Setup ✅

**Duration:** Week 1  
**Goal:** Establish core project structure, database, and basic functionality

## 1.1 Project Structure Setup
- [x] Create GitHub repository
- [x] Initialize PHP MVC directory structure
- [x] Create `.gitignore` and `composer.json`
- [x] Set up environment configuration (`.env.example`)
- [x] Create main entry point (`index.php`)

## 1.2 Blade Template & Component System
- [x] Create main layout (`resources/views/layouts/app.php`)
- [x] Create dashboard layout (`resources/views/layouts/dashboard.php`)
- [x] Build reusable components:
  - [x] Navbar component
  - [x] Footer component
  - [x] Breadcrumb component
  - [x] Stat card component
  - [x] Subject card component
  - [x] MCQ card component
  - [x] Dashboard sidebar
  - [x] Dashboard topbar
- [x] Organize views by feature (`pages/`, `components/`, `layouts/`)

## 1.3 Frontend Pages Creation
- [x] Home page (`pages/index.php`)
- [x] Subjects listing (`pages/subjects/index.php`)
- [x] Subject detail (`pages/subjects/show.php`)
- [x] Test types listing (`pages/test-types/index.php`)
- [x] Mock tests listing (`pages/mock-tests/index.php`)
- [x] Admin dashboard (`admin/dashboard.php`)
- [x] Create placeholder pages for:
  - [x] Test type detail
  - [x] Topic detail
  - [x] Practice interface
  - [x] Mock test detail
  - [x] Results pages

## 1.4 Styling & Assets
- [x] Copy Bootstrap 5 CDN links to layouts
- [x] Copy Bootstrap Icons CDN links
- [x] Create `public/assets/css/style.css` structure
- [x] Create `public/assets/js/app.js` structure
- [x] Create `public/assets/images/` directory
- [x] Define CSS variables & design system
- [x] Implement responsive design classes

## 1.5 Database Schema Design
- [ ] Create migration files for database tables:
  - [ ] `questions` table
  - [ ] `options` table
  - [ ] `subjects` table
  - [ ] `topics` table
  - [ ] `quizzes` table
  - [ ] `quiz_questions` table
  - [ ] `test_types` table
  - [ ] `attempts` table
  - [ ] `user_answers` table
  - [ ] `users` table
  - [ ] `schools` table

## 1.6 Configuration Files
- [ ] Create `config/database.php` with DB connection settings
- [ ] Create `config/app.php` with application settings
- [ ] Create `config/quiz.php` with quiz-specific configurations
- [ ] Set up environment variables in `.env`
- [ ] Create database seeders structure

---

# 📅 PHASE 2: Backend Architecture & Models ⏳

**Duration:** Week 2  
**Goal:** Implement core models, relationships, and database queries

## 2.1 Create Eloquent Models
- [ ] Create `Question` model with relationships
- [ ] Create `Option` model with relationships
- [ ] Create `Subject` model with relationships
- [ ] Create `Topic` model with relationships
- [ ] Create `Quiz` model with relationships
- [ ] Create `TestType` model
- [ ] Create `Attempt` model
- [ ] Create `UserAnswer` model
- [ ] Create `User` model
- [ ] Create `School` model

## 2.2 Model Relationships
- [ ] Set up `Question` ↔ `Option` (one-to-many)
- [ ] Set up `Subject` ↔ `Topic` (one-to-many)
- [ ] Set up `Topic` ↔ `Question` (one-to-many)
- [ ] Set up `Quiz` ↔ `Question` (many-to-many)
- [ ] Set up `Quiz` ↔ `TestType` (belongs-to)
- [ ] Set up `Attempt` ↔ `Quiz` (belongs-to)
- [ ] Set up `Attempt` ↔ `UserAnswer` (one-to-many)
- [ ] Set up `User` ↔ `School` (belongs-to)
- [ ] Set up `User` ↔ `Attempt` (one-to-many)

## 2.3 Create Controllers
- [ ] `HomeController` - Handle home page
- [ ] `SubjectController` - Subject listing & details
- [ ] `TestTypeController` - Test types management
- [ ] `TopicController` - Topic listing & details
- [ ] `MCQController` - MCQ listing & practice
- [ ] `QuizController` - Quiz management
- [ ] `AttemptController` - Attempt tracking
- [ ] `DashboardController` - Admin dashboard

## 2.4 Create Service Classes
- [ ] `QuizService` - Quiz business logic
- [ ] `AttemptService` - Attempt tracking & scoring
- [ ] `ScoreCalculationService` - Calculate test scores
- [ ] `PerformanceAnalysisService` - Performance analytics
- [ ] `QuestionFilterService` - Filter & search questions

## 2.5 Database Seeding
- [ ] Create seeders for subjects
- [ ] Create seeders for topics
- [ ] Create seeders for questions
- [ ] Create seeders for options
- [ ] Create seeders for test types
- [ ] Create seeders for quizzes
- [ ] Run seeders to populate test data

## 2.6 Data Validation
- [ ] Create validation rules for questions
- [ ] Create validation rules for quizzes
- [ ] Create validation rules for user input
- [ ] Implement custom validation classes
- [ ] Add error handling middleware

---

# 📅 PHASE 3: Frontend Interactivity & Features ⏳

**Duration:** Week 3  
**Goal:** Build interactive features and user-facing functionality

## 3.1 Search & Filtering
- [ ] Implement MCQ search functionality
- [ ] Add subject filtering
- [ ] Add difficulty level filtering
- [ ] Add test type filtering
- [ ] Create search API endpoint
- [ ] Add client-side search with JavaScript
- [ ] Implement pagination for listings

## 3.2 Practice Interface
- [ ] Build MCQ practice page (`practice.html` → `practice.php`)
- [ ] Implement question display with options
- [ ] Add "Check Answer" functionality
- [ ] Add "Hint" button with hints
- [ ] Show explanation after answer
- [ ] Implement Previous/Next navigation
- [ ] Create progress indicator
- [ ] Add question palette for navigation

## 3.3 Mock Test Interface
- [ ] Build mock test page (`take-mock-test.html` → `take-mock-test.php`)
- [ ] Implement countdown timer (JavaScript)
- [ ] Create question palette with status indicators:
  - [ ] Not answered (white)
  - [ ] Answered (green)
  - [ ] Marked for review (yellow)
  - [ ] Answered & marked (blue)
- [ ] Add "Mark for Review" feature
- [ ] Add "Clear Answer" button
- [ ] Implement "Submit Test" confirmation modal
- [ ] Auto-submit when timer reaches zero
- [ ] Save attempt data to database

## 3.4 Results & Performance Pages
- [ ] Create results page template
- [ ] Implement score ring visualization (CSS conic-gradient)
- [ ] Display performance message based on score
- [ ] Show stats: total, correct, wrong, unanswered, time taken
- [ ] Create performance breakdown charts
- [ ] Display question-by-question review
- [ ] Add option to retake quiz
- [ ] Implement printing/PDF export functionality

## 3.5 User Dashboard (Student)
- [ ] Create student dashboard page
- [ ] Show recent attempts
- [ ] Display progress statistics
- [ ] Show performance trends
- [ ] List bookmarked questions
- [ ] Show streak/consecutive practice days
- [ ] Create "Continue Learning" section

## 3.6 JavaScript Functionality
- [ ] Implement MCQ option selection
- [ ] Build countdown timer with alerts
- [ ] Create question palette interactivity
- [ ] Add answer validation logic
- [ ] Implement form submissions via AJAX
- [ ] Add animations & transitions
- [ ] Create responsive menu toggle
- [ ] Implement data counter animation

---

# 📅 PHASE 4: Admin Dashboard & Management ⏳

**Duration:** Week 4  
**Goal:** Build admin panel for content management

## 4.1 Admin Dashboard
- [ ] Complete dashboard page with charts
- [ ] Add statistics widgets
- [ ] Create activity feed
- [ ] Show quick stats (MCQs, subjects, topics, tests)
- [ ] Add recent MCQs table
- [ ] Show recent mock tests

## 4.2 Question Management
- [ ] Create add question form
- [ ] Implement edit question form
- [ ] Build delete question modal
- [ ] Create bulk upload (CSV/Excel)
- [ ] Add question preview
- [ ] Implement question sorting & filtering
- [ ] Add question status management (draft/published)

## 4.3 Quiz & Test Management
- [ ] Create add quiz form
- [ ] Implement quiz editing interface
- [ ] Add question selection for quizzes
- [ ] Create quiz preview
- [ ] Implement quiz status management
- [ ] Add timer configuration
- [ ] Set passing scores & marking scheme

## 4.4 Subject & Topic Management
- [ ] Create subject management page
- [ ] Add topic management page
- [ ] Implement CRUD operations for subjects
- [ ] Implement CRUD operations for topics
- [ ] Add icon selection for subjects
- [ ] Create category hierarchy management

## 4.5 Mock Test Management
- [ ] Create mock test creation form
- [ ] Build mock test editing interface
- [ ] Implement test preview
- [ ] Add test publication workflow
- [ ] Create test result visualization
- [ ] Show student performance on tests
- [ ] Implement test archival

## 4.6 Admin User Management
- [ ] Create admin user listing
- [ ] Add admin role management
- [ ] Implement permission system
- [ ] Create user activity log
- [ ] Add admin action tracking

---

# 📅 PHASE 5: User Authentication & Authorization ⏳

**Duration:** Week 5  
**Goal:** Implement secure user authentication and role-based access control

## 5.1 Authentication System
- [ ] Create user registration form
- [ ] Implement registration validation
- [ ] Create email verification flow
- [ ] Build login form
- [ ] Implement session management
- [ ] Create password reset functionality
- [ ] Add "Remember Me" feature
- [ ] Implement logout functionality

## 5.2 Role-Based Access Control
- [ ] Define user roles (admin, teacher, student, guest)
- [ ] Create permission matrix
- [ ] Implement role middleware
- [ ] Add permission checking in routes
- [ ] Create role seeder data
- [ ] Implement role assignment in admin panel

## 5.3 Student Profile
- [ ] Create user profile page
- [ ] Add profile edit form
- [ ] Implement avatar upload
- [ ] Create profile completion checklist
- [ ] Add educational background fields
- [ ] Show learning goals & preferences

## 5.4 Teacher/Admin Profile
- [ ] Create teacher profile page
- [ ] Add school/institution association
- [ ] Show teacher's created content
- [ ] Implement teacher dashboard

## 5.5 Social Authentication (Optional)
- [ ] Set up Google OAuth login
- [ ] Implement Facebook login
- [ ] Create social account linking

---

# 📅 PHASE 6: API Development & Integration ⏳

**Duration:** Week 6  
**Goal:** Create RESTful APIs for mobile app integration

## 6.1 API Structure
- [ ] Create `routes/api.php` file
- [ ] Implement API versioning (v1)
- [ ] Create API middleware for authentication
- [ ] Add rate limiting
- [ ] Implement CORS headers
- [ ] Create API documentation structure

## 6.2 Question APIs
- [ ] `GET /api/v1/questions` - List questions
- [ ] `GET /api/v1/questions/{id}` - Get single question
- [ ] `POST /api/v1/questions` - Create question (admin)
- [ ] `PUT /api/v1/questions/{id}` - Update question (admin)
- [ ] `DELETE /api/v1/questions/{id}` - Delete question (admin)
- [ ] `GET /api/v1/subjects/{id}/questions` - Questions by subject
- [ ] `GET /api/v1/topics/{id}/questions` - Questions by topic

## 6.3 Quiz APIs
- [ ] `GET /api/v1/quizzes` - List quizzes
- [ ] `GET /api/v1/quizzes/{id}` - Get quiz details
- [ ] `POST /api/v1/quizzes/{id}/start` - Start quiz attempt
- [ ] `POST /api/v1/quizzes/{id}/submit` - Submit quiz
- [ ] `GET /api/v1/quizzes/{id}/results` - Get quiz results

## 6.4 Attempt APIs
- [ ] `POST /api/v1/attempts` - Create new attempt
- [ ] `POST /api/v1/attempts/{id}/answer` - Submit answer
- [ ] `GET /api/v1/attempts/{id}` - Get attempt details
- [ ] `GET /api/v1/attempts/{id}/results` - Get attempt results
- [ ] `GET /api/v1/user/attempts` - Get user's attempts

## 6.5 Subject & Topic APIs
- [ ] `GET /api/v1/subjects` - List all subjects
- [ ] `GET /api/v1/subjects/{id}` - Get subject details
- [ ] `GET /api/v1/topics` - List all topics
- [ ] `GET /api/v1/topics/{id}` - Get topic details

## 6.6 User APIs
- [ ] `POST /api/v1/auth/register` - User registration
- [ ] `POST /api/v1/auth/login` - User login
- [ ] `POST /api/v1/auth/logout` - User logout
- [ ] `GET /api/v1/user/profile` - Get user profile
- [ ] `PUT /api/v1/user/profile` - Update profile
- [ ] `GET /api/v1/user/statistics` - Get user stats

---

# 📅 PHASE 7: Analytics & Reporting ⏳

**Duration:** Week 7  
**Goal:** Build performance tracking and analytics features

## 7.1 Student Analytics
- [ ] Create student dashboard with statistics
- [ ] Implement progress tracking charts
- [ ] Show quiz attempt history
- [ ] Display performance trends over time
- [ ] Create subject-wise performance breakdown
- [ ] Show topic mastery levels
- [ ] Implement streak tracking (consecutive days of practice)
- [ ] Display accuracy percentage by subject

## 7.2 Admin Analytics
- [ ] Create admin analytics dashboard
- [ ] Show total questions per subject
- [ ] Display question difficulty distribution
- [ ] Show user engagement metrics
- [ ] Create quiz performance analytics
- [ ] Display user retention rates
- [ ] Show most attempted questions
- [ ] Create performance heatmaps

## 7.3 Reporting
- [ ] Create student report generation (PDF)
- [ ] Implement class/batch performance reports
- [ ] Create question effectiveness reports
- [ ] Build time spent analysis
- [ ] Generate performance comparison reports
- [ ] Create exportable analytics (CSV/Excel)

## 7.4 Visualization
- [ ] Implement progress charts (Chart.js/Apex Charts)
- [ ] Create performance graphs
- [ ] Build heatmaps for topic mastery
- [ ] Implement pie charts for distribution
- [ ] Create line charts for trends
- [ ] Add data tables with sorting/filtering

---

# 📅 PHASE 8: Advanced Features ⏳

**Duration:** Week 8-9  
**Goal:** Add premium and advanced functionality

## 8.1 Bookmarking & Collections
- [ ] Implement question bookmarking
- [ ] Create custom collections
- [ ] Add collection sharing (private/public)
- [ ] Implement collection management page
- [ ] Add "My Bookmarks" section

## 8.2 Study Recommendations
- [ ] Create recommendation engine
- [ ] Suggest weak topics based on performance
- [ ] Recommend similar questions
- [ ] Suggest personalized study plan
- [ ] Create adaptive learning paths

## 8.3 Question Bank Features
- [ ] Add question difficulty adjustment
- [ ] Implement weighted random selection
- [ ] Create adaptive difficulty quizzes
- [ ] Add negative marking option
- [ ] Implement partial marking
- [ ] Add question review workflow

## 8.4 Notifications & Alerts
- [ ] Create notification system
- [ ] Add email notifications
- [ ] Implement in-app notifications
- [ ] Add quiz reminder notifications
- [ ] Create performance alerts
- [ ] Implement progress milestone alerts

## 8.5 Discussion Forum (Optional)
- [ ] Create forum structure
- [ ] Build question/discussion thread creation
- [ ] Implement threading & replies
- [ ] Add voting/rating system
- [ ] Create moderation tools
- [ ] Add mention/tagging system

## 8.6 Leaderboards & Gamification
- [ ] Create global leaderboard
- [ ] Build class/school leaderboards
- [ ] Implement achievement badges
- [ ] Create point/coin system
- [ ] Add level system
- [ ] Implement rewards mechanism

---

# 📅 PHASE 9: Testing & Quality Assurance ⏳

**Duration:** Week 10  
**Goal:** Comprehensive testing and bug fixing

## 9.1 Unit Testing
- [ ] Write tests for Question model
- [ ] Write tests for Quiz model
- [ ] Write tests for Attempt calculations
- [ ] Test validation rules
- [ ] Test service classes
- [ ] Implement test fixtures & factories

## 9.2 Feature Testing
- [ ] Test user registration flow
- [ ] Test login functionality
- [ ] Test MCQ practice flow
- [ ] Test mock test execution
- [ ] Test result calculations
- [ ] Test result display

## 9.3 Integration Testing
- [ ] Test database transactions
- [ ] Test API endpoints
- [ ] Test file uploads
- [ ] Test email notifications
- [ ] Test payment integration (if applicable)

## 9.4 UI/UX Testing
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] Mobile responsiveness testing
- [ ] Accessibility testing (WCAG compliance)
- [ ] Performance testing (page load speed)
- [ ] Stress testing (high traffic simulation)

## 9.5 Security Testing
- [ ] SQL injection testing
- [ ] XSS vulnerability testing
- [ ] CSRF protection verification
- [ ] Authentication bypass testing
- [ ] Authorization boundary testing
- [ ] File upload security validation

## 9.6 Bug Fixing & Documentation
- [ ] Fix identified bugs
- [ ] Document known issues
- [ ] Create troubleshooting guide
- [ ] Write API documentation
- [ ] Create user guide documentation
- [ ] Create admin guide documentation

---

# 📅 PHASE 10: Deployment & Launch ⏳

**Duration:** Week 11  
**Goal:** Deploy to production and prepare for launch

## 10.1 Environment Setup
- [ ] Set up production server
- [ ] Configure web server (Apache/Nginx)
- [ ] Set up SSL/HTTPS certificate
- [ ] Configure database backups
- [ ] Set up email service
- [ ] Configure CDN for assets

## 10.2 Database Migration
- [ ] Set up production database
- [ ] Run migrations on production
- [ ] Seed production data
- [ ] Verify data integrity
- [ ] Set up automated backups
- [ ] Test backup restoration

## 10.3 Deployment Process
- [ ] Set up continuous integration (GitHub Actions)
- [ ] Configure automated testing in CI/CD
- [ ] Set up staging environment
- [ ] Deploy to staging
- [ ] Test in staging environment
- [ ] Deploy to production
- [ ] Verify deployment success

## 10.4 Monitoring & Logging
- [ ] Set up application logging
- [ ] Configure error tracking (Sentry/Rollbar)
- [ ] Implement uptime monitoring
- [ ] Set up performance monitoring
- [ ] Create monitoring dashboards
- [ ] Set up alert notifications

## 10.5 Launch Preparation
- [ ] Create marketing materials
- [ ] Prepare launch announcement
- [ ] Set up social media presence
- [ ] Create promotional content
- [ ] Prepare support documentation
- [ ] Train support team

## 10.6 Post-Launch
- [ ] Monitor user feedback
- [ ] Track error reports
- [ ] Monitor system performance
- [ ] Handle critical issues
- [ ] Gather usage analytics
- [ ] Plan for Phase 11 improvements

---

# 📅 PHASE 11: Post-Launch & Continuous Improvement ⏳

**Duration:** Ongoing  
**Goal:** Maintain, improve, and scale the platform

## 11.1 Performance Optimization
- [ ] Optimize database queries
- [ ] Implement caching strategies
- [ ] Optimize asset loading
- [ ] Reduce code bundle size
- [ ] Implement lazy loading
- [ ] Database indexing optimization

## 11.2 Feature Enhancements
- [ ] Add live chat support
- [ ] Implement AI-powered question generator
- [ ] Add spaced repetition algorithm
- [ ] Create mobile app (iOS/Android)
- [ ] Add offline mode support
- [ ] Implement dark mode

## 11.3 Content Expansion
- [ ] Add more subjects
- [ ] Expand topic coverage
- [ ] Create new test types
- [ ] Add international exam prep
- [ ] Create video tutorials
- [ ] Add interactive explanations

## 11.4 Community Features
- [ ] Expand discussion forums
- [ ] Create study groups
- [ ] Add mentor matching
- [ ] Implement peer review system
- [ ] Create content creator program
- [ ] Build ambassador program

## 11.5 Business Features
- [ ] Implement premium subscriptions
- [ ] Add payment processing
- [ ] Create affiliate program
- [ ] Implement bulk licensing for schools
- [ ] Add institutional analytics
- [ ] Create white-label solution

## 11.6 Scaling Infrastructure
- [ ] Implement load balancing
- [ ] Set up database replication
- [ ] Implement caching servers (Redis)
- [ ] Set up message queues
- [ ] Implement microservices (if needed)
- [ ] Plan for multi-region deployment

---

## 📈 Progress Summary

| Phase | Status | Completion |
|-------|--------|-----------|
| Phase 1: Foundation & Setup | ✅ DONE | 100% |
| Phase 2: Backend Architecture | ⏳ PENDING | 0% |
| Phase 3: Frontend Interactivity | ⏳ PENDING | 0% |
| Phase 4: Admin Dashboard | ⏳ PENDING | 0% |
| Phase 5: Authentication | ⏳ PENDING | 0% |
| Phase 6: API Development | ⏳ PENDING | 0% |
| Phase 7: Analytics & Reporting | ⏳ PENDING | 0% |
| Phase 8: Advanced Features | ⏳ PENDING | 0% |
| Phase 9: Testing & QA | ⏳ PENDING | 0% |
| Phase 10: Deployment & Launch | ⏳ PENDING | 0% |
| Phase 11: Post-Launch | ⏳ PENDING | 0% |

**Overall Progress:** `████░░░░░░░░░░░░░░░░` **9%**

---

## 🛠️ Technology Stack

```
Backend:
├── PHP (Custom MVC)
├── MySQL/PostgreSQL
└── Composer

Frontend:
├── HTML5
├── CSS3 / Tailwind CSS
├── Bootstrap 5
├── Vanilla JavaScript
└── Chart.js (Analytics)

Tools & Services:
├── Git & GitHub
├── GitHub Actions (CI/CD)
├── Docker (Optional)
└── Sentry (Error Tracking)
```

---

## 📁 Project Structure

```
skoolyst-quiz-system/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Middleware/
│   └── Requests/
├── config/
│   ├── app.php
│   ├── database.php
│   └── quiz.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── index.php
├── resources/
│   └── views/
│       ├── layouts/
│       ├── components/
│       └── pages/
├── routes/
│   ├── web.php
│   └── api.php
├── tests/
│   ├── Unit/
│   └── Feature/
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── README.md
└── ARCHITECTURE.md
```

---

## 🚀 Quick Start Guide

> ⚠️ This is a **custom Core PHP MVC app, not Laravel** — there is no `artisan` binary. Use the steps below, not the generic Laravel workflow.

### Prerequisites
- PHP 8.2+
- MySQL 5.7+ (e.g. via XAMPP)
- Composer
- Git
- Apache with `mod_rewrite` enabled (XAMPP ships this already), or any web server that can point its document root at `public/`

### Installation

This project is meant to be placed directly under your web server's document root (e.g. XAMPP's `htdocs/`), not run with a framework CLI server.

```bash
# 1. Clone (or place the project) inside htdocs
git clone https://github.com/Abdul-khalid-2/skoolyst-quiz-system.git
cd skoolyst-quiz-system

# 2. Install dependencies
composer install

# 3. Copy the environment file
cp .env.example .env
```

Then edit `.env` and set at least:

```
APP_URL=http://localhost/<path-to-project>/public
DB_DATABASE=<a database name of your choice>
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Create the database (there is no `artisan key:generate` step — this app has no app key)
#    Easiest via phpMyAdmin: create a new database matching DB_DATABASE in .env.
#    Or from the command line:
mysql -u root -e "CREATE DATABASE IF NOT EXISTS <your_db_name> CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Run migrations
php console migrate

# 6. Seed the database (optional, once seeders exist)
php console seed

# 7. Start Apache (and MySQL) from the XAMPP Control Panel — no dev server command needed
```

Visit the app at whatever `APP_URL` you set, e.g.:

```
http://localhost/<path-to-project>/public/
```

### Migrations & Seeders

There is no `artisan`. Instead, this repo ships a small `console` script (`php console <command>`) that talks directly to the PDO connection in `app/Core/Database.php`:

| Command | What it does |
|---|---|
| `php console migrate` | Runs any `.sql` files in `database/migrations/` that haven't been applied yet, tracked in a `migrations` table it creates automatically. |
| `php console migrate:fresh` | Drops every table in the configured database, then re-runs all migrations from scratch. **Destructive** — only use in local dev. |
| `php console seed` | Requires `database/seeders/DatabaseSeeder.php` (must return a `function (PDO $pdo): void { ... }`) and runs it. |

**Adding a migration:** drop a new `.sql` file into `database/migrations/`, named so it sorts in the order it should run, e.g.:

```
database/migrations/2026_09_07_000001_create_users_table.sql
```

Each file's raw SQL (`CREATE TABLE`, etc.) is executed once and recorded by filename — never edit an already-applied migration file, add a new one instead.

**Adding a seeder:** create a file like `database/seeders/UserSeeder.php` that returns a `function (PDO $pdo): void { ... }`, then call it from `database/seeders/DatabaseSeeder.php`:

```php
// database/seeders/DatabaseSeeder.php
return function (PDO $pdo): void {
    (require __DIR__ . '/UserSeeder.php')($pdo);
};
```

> **Current state:** `database/migrations/` and `database/seeders/` are currently empty placeholders — no schema or seed data has been defined yet (see Phase 2 below). `database/sql/module_database.sql` is also just a stub, not a real dump.

---

## 📖 Documentation Links

- **[Architecture Guide](./ARCHITECTURE.md)** - System design & patterns
- **[Database Schema](./database/README.md)** - Database structure
- **[API Documentation](./docs/API.md)** - REST API reference
- **[User Guide](./docs/USER_GUIDE.md)** - End-user documentation
- **[Admin Guide](./docs/ADMIN_GUIDE.md)** - Administrator documentation
- **[Contribution Guide](./CONTRIBUTING.md)** - How to contribute

---

## 👥 Team & Contributors

- **Lead Developer:** Abdul Khalid [@Abdul-khalid-2](https://github.com/Abdul-khalid-2)
- **Project:** Skoolyst MCQs System
- **Part of:** [Skoolyst Ecosystem](https://github.com/Abdul-khalid-2?tab=repositories&q=skoolyst)

---

## 📝 License

This project is licensed under the MIT License - see [LICENSE](./LICENSE) file for details.

---

## 🤝 Contributing

We welcome contributions! Please see our [CONTRIBUTING.md](./CONTRIBUTING.md) guide for details on:
- Code standards
- Pull request process
- Issue reporting
- Feature requests

---

## 📞 Support & Contact

- **Issues:** [GitHub Issues](https://github.com/Abdul-khalid-2/skoolyst-quiz-system/issues)
- **Discussions:** [GitHub Discussions](https://github.com/Abdul-khalid-2/skoolyst-quiz-system/discussions)
- **Email:** [Contact](mailto:support@skoolyst.com)

---

## 🎯 Roadmap

**Q4 2026:** Phase 2-4 completion  
**Q1 2027:** Phase 5-6 completion  
**Q2 2027:** Phase 7-8 completion & Beta Launch  
**Q3 2027:** Phase 9-10 completion & Production Launch  
**Q4 2027+:** Phase 11 - Continuous Improvements & Scaling

---

## 📊 Tracking Progress

This README serves as the **single source of truth** for project progress. Check back regularly to:
- ✅ Mark completed tasks
- 📝 Update phase status
- 🐛 Report issues
- 💡 Suggest improvements

**Last Updated:** September 7, 2026  
**Current Phase:** Phase 1 (Completed)  
**Next Phase:** Phase 2 (Backend Architecture)

---

## 🙏 Acknowledgments

- **Bootstrap** - UI Framework
- **Skoolyst Team** - Project vision
- **Community Contributors** - Support & feedback

---

**Happy Learning! 🎓**
