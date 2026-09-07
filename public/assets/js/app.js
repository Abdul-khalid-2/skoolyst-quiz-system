/* ============================================================
   Skoolyst MCQs — Vanilla JS Application
   ============================================================ */

/* ---------- Sample MCQ Data ---------- */
const SK_SAMPLE_QUESTIONS = [
  {
    id: 1,
    question: "Which of the following is the powerhouse of the cell?",
    options: ["Nucleus", "Mitochondria", "Ribosome", "Golgi apparatus"],
    correct: 1,
    explanation: "Mitochondria are organelles that act like a digestive system which takes in nutrients, breaks them down, and creates energy rich molecules for the cell. This process is known as cellular respiration.",
    hint: "It's responsible for producing ATP through cellular respiration.",
    difficulty: "easy",
    topic: "Cell Biology",
    subject: "Biology"
  },
  {
    id: 2,
    question: "What is the chemical symbol for Gold?",
    options: ["Go", "Gd", "Au", "Ag"],
    correct: 2,
    explanation: "The symbol Au comes from the Latin word 'aurum' which means gold. Ag is the symbol for Silver (argentum).",
    hint: "It comes from the Latin word 'aurum'.",
    difficulty: "easy",
    topic: "Periodic Table",
    subject: "Chemistry"
  },
  {
    id: 3,
    question: "Which planet is known as the Red Planet?",
    options: ["Venus", "Jupiter", "Mars", "Saturn"],
    correct: 2,
    explanation: "Mars is called the Red Planet because of its reddish appearance, caused by iron oxide (rust) on its surface.",
    hint: "It's the fourth planet from the Sun.",
    difficulty: "easy",
    topic: "Astronomy",
    subject: "Physics"
  },
  {
    id: 4,
    question: "What is the derivative of x² with respect to x?",
    options: ["x", "2x", "x²", "2"],
    correct: 1,
    explanation: "Using the power rule: d/dx(xⁿ) = n·xⁿ⁻¹. So d/dx(x²) = 2·x²⁻¹ = 2x.",
    hint: "Use the power rule for differentiation.",
    difficulty: "medium",
    topic: "Calculus",
    subject: "Mathematics"
  },
  {
    id: 5,
    question: "Which gas is most abundant in Earth's atmosphere?",
    options: ["Oxygen", "Carbon Dioxide", "Nitrogen", "Hydrogen"],
    correct: 2,
    explanation: "Nitrogen makes up about 78% of Earth's atmosphere, followed by oxygen at about 21%.",
    hint: "It makes up about 78% of the air we breathe.",
    difficulty: "medium",
    topic: "Atmospheric Chemistry",
    subject: "Chemistry"
  },
  {
    id: 6,
    question: "In which year did World War II end?",
    options: ["1943", "1944", "1945", "1946"],
    correct: 2,
    explanation: "World War II ended in 1945 with the surrender of Germany in May and Japan in September.",
    hint: "It ended shortly after the atomic bombings of Hiroshima and Nagasaki.",
    difficulty: "easy",
    topic: "World History",
    subject: "General Knowledge"
  },
  {
    id: 7,
    question: "What is the SI unit of electric current?",
    options: ["Volt", "Watt", "Ampere", "Ohm"],
    correct: 2,
    explanation: "The ampere (A) is the SI base unit of electric current, named after André-Marie Ampère.",
    hint: "Named after a French physicist.",
    difficulty: "medium",
    topic: "Electricity",
    subject: "Physics"
  },
  {
    id: 8,
    question: "Which enzyme is responsible for breaking down starch into maltose in the digestive system?",
    options: ["Pepsin", "Amylase", "Lipase", "Trypsin"],
    correct: 1,
    explanation: "Amylase, found in saliva and pancreatic juice, breaks down starch (a polysaccharide) into maltose (a disaccharide).",
    hint: "It's also present in your saliva.",
    difficulty: "hard",
    topic: "Digestive System",
    subject: "Biology"
  },
  {
    id: 9,
    question: "What is the value of sin(90°)?",
    options: ["0", "0.5", "1", "√2/2"],
    correct: 2,
    explanation: "sin(90°) = 1. At 90 degrees, the sine function reaches its maximum value.",
    hint: "Think about the unit circle.",
    difficulty: "medium",
    topic: "Trigonometry",
    subject: "Mathematics"
  },
  {
    id: 10,
    question: "Which blood vessels carry blood away from the heart?",
    options: ["Veins", "Arteries", "Capillaries", "Venules"],
    correct: 1,
    explanation: "Arteries carry oxygenated blood away from the heart to the body, while veins carry blood back to the heart.",
    hint: "They have thicker walls than veins.",
    difficulty: "easy",
    topic: "Circulatory System",
    subject: "Biology"
  }
];

/* ---------- Sample Mock Test Data ---------- */
const SK_SAMPLE_MOCK_QUESTIONS = [
  {
    id: 1,
    question: "The process by which plants make their own food is called:",
    options: ["Respiration", "Photosynthesis", "Transpiration", "Digestion"],
    correct: 1,
    explanation: "Photosynthesis is the process by which green plants use sunlight to synthesize foods from carbon dioxide and water.",
    topic: "Plant Physiology",
    subject: "Biology"
  },
  {
    id: 2,
    question: "If f(x) = 3x + 2, what is f(5)?",
    options: ["15", "17", "10", "13"],
    correct: 1,
    explanation: "f(5) = 3(5) + 2 = 15 + 2 = 17.",
    topic: "Functions",
    subject: "Mathematics"
  },
  {
    id: 3,
    question: "Which of the following is a noble gas?",
    options: ["Oxygen", "Nitrogen", "Helium", "Hydrogen"],
    correct: 2,
    explanation: "Helium is a noble gas (Group 18), known for being inert and having a full outer shell of electrons.",
    topic: "Periodic Table",
    subject: "Chemistry"
  },
  {
    id: 4,
    question: "The acceleration due to gravity on Earth's surface is approximately:",
    options: ["8.8 m/s²", "9.8 m/s²", "10.8 m/s²", "11.8 m/s²"],
    correct: 1,
    explanation: "The standard acceleration due to gravity (g) at Earth's surface is approximately 9.8 m/s².",
    topic: "Mechanics",
    subject: "Physics"
  },
  {
    id: 5,
    question: "Which organ in the human body is primarily responsible for filtering blood?",
    options: ["Liver", "Kidneys", "Heart", "Lungs"],
    correct: 1,
    explanation: "The kidneys filter waste and excess fluid from the blood, which are then excreted as urine.",
    topic: "Excretory System",
    subject: "Biology"
  },
  {
    id: 6,
    question: "Solve: 2x + 7 = 21. What is x?",
    options: ["5", "6", "7", "8"],
    correct: 2,
    explanation: "2x + 7 = 21 → 2x = 14 → x = 7.",
    topic: "Algebra",
    subject: "Mathematics"
  },
  {
    id: 7,
    question: "What is the pH of a neutral solution at 25°C?",
    options: ["0", "7", "14", "1"],
    correct: 1,
    explanation: "A neutral solution has a pH of 7 at 25°C, meaning the concentration of H⁺ and OH⁻ ions are equal.",
    topic: "Acids and Bases",
    subject: "Chemistry"
  },
  {
    id: 8,
    question: "Which type of energy is stored in a stretched rubber band?",
    options: ["Kinetic energy", "Potential energy", "Thermal energy", "Electrical energy"],
    correct: 1,
    explanation: "A stretched rubber band stores elastic potential energy due to its position and deformation.",
    topic: "Work and Energy",
    subject: "Physics"
  },
  {
    id: 9,
    question: "The chemical formula for water is:",
    options: ["CO₂", "H₂O", "O₂", "NaCl"],
    correct: 1,
    explanation: "Water is composed of two hydrogen atoms and one oxygen atom, giving it the formula H₂O.",
    topic: "Chemical Bonds",
    subject: "Chemistry"
  },
  {
    id: 10,
    question: "What is the capital of Pakistan?",
    options: ["Karachi", "Lahore", "Islamabad", "Peshawar"],
    correct: 2,
    explanation: "Islamabad became the capital of Pakistan in 1960, replacing Karachi.",
    topic: "Geography",
    subject: "General Knowledge"
  }
];

/* ---------- DOM Ready ---------- */
document.addEventListener('DOMContentLoaded', function() {

  /* Mobile navbar toggle (Bootstrap handles, but ensure proper close) */
  document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
      var navbarCollapse = document.querySelector('.navbar-collapse');
      if (navbarCollapse && navbarCollapse.classList.contains('show')) {
        var btn = document.querySelector('.navbar-toggler');
        if (btn) btn.click();
      }
    });
  });

  /* Dashboard sidebar toggle */
  var dashToggle = document.querySelector('.sk-dash-toggle');
  if (dashToggle) {
    var sidebar = document.querySelector('.sk-dash-sidebar');
    var overlay = document.querySelector('.sk-dash-overlay');
    dashToggle.addEventListener('click', function() {
      if (sidebar) sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('show');
    });
    if (overlay) {
      overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
      });
    }
  }

  /* Filter chips */
  document.querySelectorAll('.sk-filter-chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
      var group = chip.getAttribute('data-group');
      if (group === 'single') {
        document.querySelectorAll('.sk-filter-chip[data-group="single"]').forEach(function(c) {
          c.classList.remove('active');
        });
        chip.classList.add('active');
      } else {
        chip.classList.toggle('active');
      }
    });
  });

  /* Password show/hide */
  document.querySelectorAll('[data-toggle-password]').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var targetId = btn.getAttribute('data-toggle-password');
      var input = document.getElementById(targetId);
      if (input) {
        if (input.type === 'password') {
          input.type = 'text';
          btn.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
          input.type = 'password';
          btn.innerHTML = '<i class="bi bi-eye"></i>';
        }
      }
    });
  });

  /* Initialize MCQ practice interface */
  initMCQPractice();

  /* Initialize Topic MCQ interface */
  initTopicMCQ();

  /* Initialize Mock Test interface */
  initMockTest();

  /* Initialize Result screens */
  initResultScreen();

  /* Animate stat counters */
  animateCounters();

  /* Search filter on listing pages */
  initSearchFilter();
});

/* ---------- MCQ Practice Interface (practice.html) ---------- */
function initMCQPractice() {
  var container = document.getElementById('sk-practice-container');
  if (!container) return;

  var questions = SK_SAMPLE_QUESTIONS.slice(0, 6);
  var currentIndex = 0;
  var userAnswers = new Array(questions.length).fill(null);
  var checked = new Array(questions.length).fill(false);

  function render() {
    var q = questions[currentIndex];
    var progress = ((currentIndex + 1) / questions.length) * 100;
    var answeredCount = userAnswers.filter(function(a) { return a !== null; }).length;

    container.innerHTML = `
      <div class="d-flex justify-content-between align-items-center mb-3">
        <span class="sk-badge sk-badge-navy">Question ${currentIndex + 1} of ${questions.length}</span>
        <span class="sk-badge sk-badge-cyan">${answeredCount} Answered</span>
      </div>
      <div class="sk-progress mb-3">
        <div class="sk-progress-bar" style="width: ${progress}%"></div>
      </div>
      <div class="sk-info-box mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
          <div>
            <span class="sk-badge sk-badge-light">${q.subject}</span>
            <span class="sk-badge sk-badge-light ms-1">${q.topic}</span>
            <span class="sk-badge sk-badge-${q.difficulty === 'easy' ? 'easy' : q.difficulty === 'medium' ? 'medium' : 'hard'} ms-1">${q.difficulty.charAt(0).toUpperCase() + q.difficulty.slice(1)}</span>
          </div>
        </div>
      </div>
      <h4 class="mb-3">${q.question}</h4>
      <div id="sk-mcq-options">
        ${q.options.map(function(opt, i) {
          var cls = 'sk-mcq-option';
          var letterCls = '';
          if (checked[currentIndex]) {
            cls += ' disabled';
            if (i === q.correct) { cls += ' correct'; }
            else if (i === userAnswers[currentIndex]) { cls += ' incorrect'; }
          } else if (userAnswers[currentIndex] === i) {
            cls += ' selected';
          }
          var iconHtml = '';
          if (checked[currentIndex]) {
            if (i === q.correct) { iconHtml = '<i class="bi bi-check-circle-fill sk-mcq-option-icon text-success"></i>'; }
            else if (i === userAnswers[currentIndex]) { iconHtml = '<i class="bi bi-x-circle-fill sk-mcq-option-icon text-danger"></i>'; }
          }
          return `<div class="${cls}" data-option="${i}">
            <span class="sk-mcq-option-letter">${String.fromCharCode(65 + i)}</span>
            <span class="sk-mcq-option-text">${opt}</span>
            ${iconHtml}
          </div>`;
        }).join('')}
      </div>
      <div id="sk-mcq-feedback" class="mt-3"></div>
      <div id="sk-mcq-actions" class="mt-3 d-flex gap-2 flex-wrap"></div>
    `;

    /* Attach option click handlers */
    container.querySelectorAll('.sk-mcq-option').forEach(function(opt) {
      opt.addEventListener('click', function() {
        if (checked[currentIndex]) return;
        var idx = parseInt(opt.getAttribute('data-option'));
        userAnswers[currentIndex] = idx;
        render();
      });
    });

    /* Feedback */
    var feedbackEl = container.querySelector('#sk-mcq-feedback');
    var actionsEl = container.querySelector('#sk-mcq-actions');

    if (checked[currentIndex]) {
      var isCorrect = userAnswers[currentIndex] === q.correct;
      feedbackEl.innerHTML = `
        <div class="alert ${isCorrect ? 'alert-success' : 'alert-danger'} d-flex align-items-start gap-2" role="alert">
          <i class="bi ${isCorrect ? 'bi-check-circle-fill' : 'bi-x-circle-fill'} mt-1"></i>
          <div>
            <strong>${isCorrect ? 'Correct!' : 'Incorrect!'}</strong>
            <p class="mb-1 mt-1">${q.explanation}</p>
          </div>
        </div>
      `;
    }

    /* Actions */
    var actionsHtml = '';
    if (!checked[currentIndex]) {
      actionsHtml += `<button class="btn btn-light btn-sm-sk" id="sk-hint-btn" type="button"><i class="bi bi-lightbulb me-1"></i>Hint</button>`;
      actionsHtml += `<button class="btn btn-sk-cyan btn-sm-sk" id="sk-check-btn" type="button" ${userAnswers[currentIndex] === null ? 'disabled' : ''}>Check Answer</button>`;
    }
    if (currentIndex > 0) {
      actionsHtml += `<button class="btn btn-sk-outline btn-sm-sk" id="sk-prev-btn" type="button"><i class="bi bi-arrow-left me-1"></i>Previous</button>`;
    }
    if (currentIndex < questions.length - 1) {
      actionsHtml += `<button class="btn btn-sk-navy btn-sm-sk" id="sk-next-btn" type="button">Next<i class="bi bi-arrow-right ms-1"></i></button>`;
    } else if (checked[currentIndex]) {
      actionsHtml += `<a href="topic-result.html" class="btn btn-sk-gold btn-sm-sk">View Results<i class="bi bi-arrow-right ms-1"></i></a>`;
    }
    actionsEl.innerHTML = actionsHtml;

    var hintBtn = document.getElementById('sk-hint-btn');
    if (hintBtn) {
      hintBtn.addEventListener('click', function() {
        if (feedbackEl.innerHTML.indexOf('alert-info') === -1) {
          feedbackEl.innerHTML = `<div class="alert alert-info d-flex align-items-start gap-2" role="alert"><i class="bi bi-lightbulb-fill mt-1"></i><div><strong>Hint:</strong> ${q.hint}</div></div>` + feedbackEl.innerHTML;
        }
      });
    }

    var checkBtn = document.getElementById('sk-check-btn');
    if (checkBtn) {
      checkBtn.addEventListener('click', function() {
        checked[currentIndex] = true;
        render();
      });
    }

    var prevBtn = document.getElementById('sk-prev-btn');
    if (prevBtn) prevBtn.addEventListener('click', function() { currentIndex--; render(); });
    var nextBtn = document.getElementById('sk-next-btn');
    if (nextBtn) nextBtn.addEventListener('click', function() { currentIndex++; render(); });
  }

  render();
}

/* ---------- Topic MCQ Interface (topic.html) ---------- */
function initTopicMCQ() {
  var container = document.getElementById('sk-topic-mcq');
  if (!container) return;

  var questions = SK_SAMPLE_QUESTIONS.slice(0, 8);
  var currentIndex = 0;
  var userAnswers = new Array(questions.length).fill(null);
  var checked = new Array(questions.length).fill(false);

  function renderPalette() {
    var paletteHtml = questions.map(function(q, i) {
      var cls = 'sk-palette-item';
      if (i === currentIndex) cls += ' current';
      else if (checked[i] && userAnswers[i] === q.correct) cls += ' answered';
      else if (userAnswers[i] !== null) cls += ' answered';
      return `<span class="${cls}" data-idx="${i}">${i + 1}</span>`;
    }).join('');
    var paletteContainer = document.getElementById('sk-palette');
    if (paletteContainer) {
      paletteContainer.innerHTML = paletteHtml;
      paletteContainer.querySelectorAll('.sk-palette-item').forEach(function(item) {
        item.addEventListener('click', function() {
          currentIndex = parseInt(item.getAttribute('data-idx'));
          render();
        });
      });
    }
  }

  function render() {
    var q = questions[currentIndex];
    var progress = ((currentIndex + 1) / questions.length) * 100;
    var answeredCount = userAnswers.filter(function(a) { return a !== null; }).length;

    var mainEl = container.querySelector('#sk-topic-main');
    if (mainEl) {
      mainEl.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <span class="sk-badge sk-badge-navy">Question ${currentIndex + 1} of ${questions.length}</span>
          <div class="d-flex gap-2">
            <span class="sk-badge sk-badge-cyan">${answeredCount} Answered</span>
            <span class="sk-badge sk-badge-${q.difficulty === 'easy' ? 'easy' : q.difficulty === 'medium' ? 'medium' : 'hard'}">${q.difficulty.charAt(0).toUpperCase() + q.difficulty.slice(1)}</span>
          </div>
        </div>
        <div class="sk-progress mb-4">
          <div class="sk-progress-bar bg-cyan" style="width: ${progress}%"></div>
        </div>
        <h4 class="mb-3">${q.question}</h4>
        <div id="sk-topic-options">
          ${q.options.map(function(opt, i) {
            var cls = 'sk-mcq-option';
            if (checked[currentIndex]) {
              cls += ' disabled';
              if (i === q.correct) cls += ' correct';
              else if (i === userAnswers[currentIndex]) cls += ' incorrect';
            } else if (userAnswers[currentIndex] === i) cls += ' selected';
            var iconHtml = '';
            if (checked[currentIndex]) {
              if (i === q.correct) iconHtml = '<i class="bi bi-check-circle-fill sk-mcq-option-icon text-success"></i>';
              else if (i === userAnswers[currentIndex]) iconHtml = '<i class="bi bi-x-circle-fill sk-mcq-option-icon text-danger"></i>';
            }
            return `<div class="${cls}" data-option="${i}">
              <span class="sk-mcq-option-letter">${String.fromCharCode(65 + i)}</span>
              <span class="sk-mcq-option-text">${opt}</span>
              ${iconHtml}
            </div>`;
          }).join('')}
        </div>
        <div id="sk-topic-feedback" class="mt-3"></div>
        <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
          <div class="d-flex gap-2">
            <button class="btn btn-sk-outline btn-sm-sk" id="sk-topic-prev" type="button" ${currentIndex === 0 ? 'disabled' : ''}><i class="bi bi-arrow-left me-1"></i>Previous</button>
            <button class="btn btn-sk-outline btn-sm-sk" id="sk-topic-next" type="button" ${currentIndex === questions.length - 1 ? 'disabled' : ''}>Next<i class="bi bi-arrow-right ms-1"></i></button>
          </div>
          <div class="d-flex gap-2">
            ${!checked[currentIndex] ? `<button class="btn btn-sk-cyan btn-sm-sk" id="sk-topic-check" type="button" ${userAnswers[currentIndex] === null ? 'disabled' : ''}>Check Answer</button>` : ''}
            ${currentIndex === questions.length - 1 && checked.filter(function(c){return c;}).length >= 1 ? `<a href="topic-result.html" class="btn btn-sk-gold btn-sm-sk">Finish<i class="bi bi-flag-fill ms-1"></i></a>` : ''}
          </div>
        </div>
      `;

      mainEl.querySelectorAll('.sk-mcq-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
          if (checked[currentIndex]) return;
          var idx = parseInt(opt.getAttribute('data-option'));
          userAnswers[currentIndex] = idx;
          render();
        });
      });

      var feedbackEl = mainEl.querySelector('#sk-topic-feedback');
      if (checked[currentIndex]) {
        var isCorrect = userAnswers[currentIndex] === q.correct;
        feedbackEl.innerHTML = `
          <div class="alert ${isCorrect ? 'alert-success' : 'alert-danger'} d-flex align-items-start gap-2">
            <i class="bi ${isCorrect ? 'bi-check-circle-fill' : 'bi-x-circle-fill'} mt-1"></i>
            <div><strong>${isCorrect ? 'Correct!' : 'Incorrect!'}</strong><p class="mb-0 mt-1">${q.explanation}</p></div>
          </div>`;
      }

      var prevBtn = document.getElementById('sk-topic-prev');
      if (prevBtn) prevBtn.addEventListener('click', function() { if (currentIndex > 0) { currentIndex--; render(); } });
      var nextBtn = document.getElementById('sk-topic-next');
      if (nextBtn) nextBtn.addEventListener('click', function() { if (currentIndex < questions.length - 1) { currentIndex++; render(); } });
      var checkBtn = document.getElementById('sk-topic-check');
      if (checkBtn) checkBtn.addEventListener('click', function() { checked[currentIndex] = true; render(); });
    }
    renderPalette();
  }

  render();
}

/* ---------- Mock Test Interface (take-mock-test.html) ---------- */
function initMockTest() {
  var container = document.getElementById('sk-mock-test-container');
  if (!container) return;

  var questions = SK_SAMPLE_MOCK_QUESTIONS;
  var currentIndex = 0;
  var userAnswers = new Array(questions.length).fill(null);
  var markedForReview = new Array(questions.length).fill(false);
  var totalTime = 30 * 60; /* 30 minutes in seconds */
  var timeRemaining = totalTime;
  var timerInterval = null;

  function formatTime(seconds) {
    var m = Math.floor(seconds / 60);
    var s = seconds % 60;
    return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
  }

  function updateTimer() {
    var timerEl = document.getElementById('sk-timer');
    if (timerEl) {
      timerEl.textContent = formatTime(timeRemaining);
      if (timeRemaining < 300) {
        timerEl.parentElement.classList.remove('warning');
        timerEl.parentElement.classList.add('danger');
      } else if (timeRemaining < 600) {
        timerEl.parentElement.classList.add('warning');
      }
    }
  }

  timerInterval = setInterval(function() {
    timeRemaining--;
    updateTimer();
    if (timeRemaining <= 0) {
      clearInterval(timerInterval);
      submitTest();
    }
  }, 1000);

  function renderPalette() {
    var paletteEl = document.getElementById('sk-mock-palette');
    if (!paletteEl) return;
    paletteEl.innerHTML = questions.map(function(q, i) {
      var cls = 'sk-palette-item';
      if (i === currentIndex) cls += ' current';
      else if (markedForReview[i] && userAnswers[i] !== null) cls += ' answered-marked';
      else if (markedForReview[i]) cls += ' marked';
      else if (userAnswers[i] !== null) cls += ' answered';
      return `<span class="${cls}" data-idx="${i}">${i + 1}</span>`;
    }).join('');
    paletteEl.querySelectorAll('.sk-palette-item').forEach(function(item) {
      item.addEventListener('click', function() {
        currentIndex = parseInt(item.getAttribute('data-idx'));
        render();
      });
    });

    /* Update legend counts */
    var answered = userAnswers.filter(function(a) { return a !== null; }).length;
    var marked = markedForReview.filter(function(m) { return m; }).length;
    var notAnswered = questions.length - answered;
    var legendEl = document.getElementById('sk-palette-legend');
    if (legendEl) {
      legendEl.innerHTML = `
        <div class="d-flex flex-wrap gap-3 mb-2">
          <span class="d-flex align-items-center gap-1"><span class="sk-palette-item answered" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Answered (${answered})</span>
          <span class="d-flex align-items-center gap-1"><span class="sk-palette-item" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Not Answered (${notAnswered})</span>
          <span class="d-flex align-items-center gap-1"><span class="sk-palette-item marked" style="cursor:default;width:20px;height:20px;font-size:0.7rem;"></span> Marked (${marked})</span>
        </div>`;
    }
  }

  function render() {
    var q = questions[currentIndex];
    var progress = ((currentIndex + 1) / questions.length) * 100;

    var mainEl = container.querySelector('#sk-mock-main');
    if (mainEl) {
      mainEl.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <span class="sk-badge sk-badge-navy">Question ${currentIndex + 1} of ${questions.length}</span>
          <div class="d-flex gap-2">
            <span class="sk-badge sk-badge-light">${q.subject}</span>
            <span class="sk-badge sk-badge-light">${q.topic}</span>
          </div>
        </div>
        <div class="sk-progress mb-4">
          <div class="sk-progress-bar" style="width: ${progress}%"></div>
        </div>
        <h4 class="mb-3">${q.question}</h4>
        <div id="sk-mock-options">
          ${q.options.map(function(opt, i) {
            var cls = 'sk-mcq-option';
            if (userAnswers[currentIndex] === i) cls += ' selected';
            return `<div class="${cls}" data-option="${i}">
              <span class="sk-mcq-option-letter">${String.fromCharCode(65 + i)}</span>
              <span class="sk-mcq-option-text">${opt}</span>
            </div>`;
          }).join('')}
        </div>
        <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
          <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-sk-outline btn-sm-sk" id="sk-mock-prev" type="button" ${currentIndex === 0 ? 'disabled' : ''}><i class="bi bi-arrow-left me-1"></i>Previous</button>
            <button class="btn btn-sk-outline btn-sm-sk" id="sk-mock-mark" type="button">${markedForReview[currentIndex] ? '<i class="bi bi-bookmark-fill me-1 text-warning"></i>Unmark' : '<i class="bi bi-bookmark me-1"></i>Mark for Review'}</button>
            <button class="btn btn-sk-outline btn-sm-sk" id="sk-mock-clear" type="button" ${userAnswers[currentIndex] === null ? 'disabled' : ''}><i class="bi bi-eraser me-1"></i>Clear</button>
          </div>
          <div class="d-flex gap-2">
            ${currentIndex < questions.length - 1 ? `<button class="btn btn-sk-navy btn-sm-sk" id="sk-mock-next" type="button">Next<i class="bi bi-arrow-right ms-1"></i></button>` : `<button class="btn btn-sk-gold btn-sm-sk" id="sk-mock-submit" type="button"><i class="bi bi-check2-all me-1"></i>Submit Test</button>`}
          </div>
        </div>
      `;

      mainEl.querySelectorAll('.sk-mcq-option').forEach(function(opt) {
        opt.addEventListener('click', function() {
          var idx = parseInt(opt.getAttribute('data-option'));
          if (userAnswers[currentIndex] === idx) {
            userAnswers[currentIndex] = null;
          } else {
            userAnswers[currentIndex] = idx;
          }
          render();
        });
      });

      var prevBtn = document.getElementById('sk-mock-prev');
      if (prevBtn) prevBtn.addEventListener('click', function() { if (currentIndex > 0) { currentIndex--; render(); } });
      var nextBtn = document.getElementById('sk-mock-next');
      if (nextBtn) nextBtn.addEventListener('click', function() { if (currentIndex < questions.length - 1) { currentIndex++; render(); } });
      var markBtn = document.getElementById('sk-mock-mark');
      if (markBtn) markBtn.addEventListener('click', function() { markedForReview[currentIndex] = !markedForReview[currentIndex]; render(); });
      var clearBtn = document.getElementById('sk-mock-clear');
      if (clearBtn) clearBtn.addEventListener('click', function() { userAnswers[currentIndex] = null; render(); });
      var submitBtn = document.getElementById('sk-mock-submit');
      if (submitBtn) submitBtn.addEventListener('click', function() { showSubmitConfirm(); });
    }
    renderPalette();
  }

  function showSubmitConfirm() {
    var answered = userAnswers.filter(function(a) { return a !== null; }).length;
    var notAnswered = questions.length - answered;
    var marked = markedForReview.filter(function(m) { return m; }).length;

    var modalHtml = `
      <div class="modal fade" id="sk-submit-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-dark-navy text-white">
              <h5 class="modal-title"><i class="bi bi-check2-circle me-2"></i>Submit Test?</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>You are about to submit your test. Here's a summary:</p>
              <div class="sk-info-box mb-3">
                <div class="sk-info-row"><span class="sk-info-label">Total Questions</span><span class="sk-info-value">${questions.length}</span></div>
                <div class="sk-info-row"><span class="sk-info-label">Answered</span><span class="sk-info-value text-success">${answered}</span></div>
                <div class="sk-info-row"><span class="sk-info-label">Not Answered</span><span class="sk-info-value text-danger">${notAnswered}</span></div>
                <div class="sk-info-row"><span class="sk-info-label">Marked for Review</span><span class="sk-info-value text-warning">${marked}</span></div>
                <div class="sk-info-row"><span class="sk-info-label">Time Used</span><span class="sk-info-value">${formatTime(totalTime - timeRemaining)}</span></div>
              </div>
              ${notAnswered > 0 ? '<div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>You have unanswered questions. Are you sure you want to submit?</div>' : ''}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sk-light" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-sk-gold" id="sk-confirm-submit">Submit Test</button>
            </div>
          </div>
        </div>
      </div>
    `;
    var modalDiv = document.createElement('div');
    modalDiv.innerHTML = modalHtml;
    document.body.appendChild(modalDiv);
    var modal = new bootstrap.Modal(modalDiv.querySelector('#sk-submit-modal'));
    modal.show();
    document.getElementById('sk-confirm-submit').addEventListener('click', function() {
      modal.hide();
      modalDiv.remove();
      submitTest();
    });
    modalDiv.querySelector('#sk-submit-modal').addEventListener('hidden.bs.modal', function() {
      modalDiv.remove();
    });
  }

  function submitTest() {
    clearInterval(timerInterval);
    /* Store results in sessionStorage for the result page */
    var results = {
      total: questions.length,
      answers: userAnswers,
      questions: questions.map(function(q) {
        return { id: q.id, question: q.question, options: q.options, correct: q.correct, explanation: q.explanation, topic: q.topic, subject: q.subject };
      }),
      timeUsed: totalTime - timeRemaining,
      totalTime: totalTime
    };
    try { sessionStorage.setItem('sk_mock_results', JSON.stringify(results)); } catch(e) {}
    window.location.href = 'mock-test-result.html';
  }

  updateTimer();
  render();
}

/* ---------- Result Screens ---------- */
function initResultScreen() {
  var container = document.getElementById('sk-result-container');
  if (!container) return;

  var isMock = container.getAttribute('data-type') === 'mock';
  var results = null;

  if (isMock) {
    try {
      results = JSON.parse(sessionStorage.getItem('sk_mock_results'));
    } catch(e) {}
    if (!results) {
      /* Fallback to sample data */
      results = {
        total: SK_SAMPLE_MOCK_QUESTIONS.length,
        answers: [1, 1, 2, 1, 1, 2, 1, 1, 1, 2],
        questions: SK_SAMPLE_MOCK_QUESTIONS.map(function(q) {
          return { id: q.id, question: q.question, options: q.options, correct: q.correct, explanation: q.explanation, topic: q.topic, subject: q.subject };
        }),
        timeUsed: 18 * 60 + 45,
        totalTime: 30 * 60
      };
    }
  } else {
    /* Use sample data for topic/subject results */
    var questions = SK_SAMPLE_QUESTIONS.slice(0, 8);
    var sampleAnswers = [1, 2, 2, 1, 2, 2, 2, 1];
    results = {
      total: questions.length,
      answers: sampleAnswers,
      questions: questions.map(function(q) {
        return { id: q.id, question: q.question, options: q.options, correct: q.correct, explanation: q.explanation, topic: q.topic, subject: q.subject };
      }),
      timeUsed: 12 * 60,
      totalTime: 20 * 60
    };
  }

  var correctCount = 0;
  var wrongCount = 0;
  var unanswered = 0;
  results.questions.forEach(function(q, i) {
    if (results.answers[i] === null) unanswered++;
    else if (results.answers[i] === q.correct) correctCount++;
    else wrongCount++;
  });
  var percentage = Math.round((correctCount / results.total) * 100);

  /* Performance message */
  var perfMsg = '';
  var perfClass = '';
  if (percentage >= 80) { perfMsg = 'Excellent work! You have a strong understanding of the material.'; perfClass = 'alert-success'; }
  else if (percentage >= 60) { perfMsg = 'Good job! You are on the right track. Review the areas you missed.'; perfClass = 'alert-info'; }
  else if (percentage >= 40) { perfMsg = 'You need more practice. Focus on the topics where you made mistakes.'; perfClass = 'alert-warning'; }
  else { perfMsg = 'Keep practicing! Review the material and try again.'; perfClass = 'alert-danger'; }

  /* Ring conic-gradient */
  var ringColor = percentage >= 80 ? '#16A34A' : percentage >= 60 ? '#0EA5E9' : percentage >= 40 ? '#F59E0B' : '#DC2626';
  var ringStyle = `background: conic-gradient(${ringColor} 0% ${percentage}%, #E2E8F0 ${percentage}% 100%);`;

  /* Time info */
  var timeUsedStr = Math.floor(results.timeUsed / 60) + 'm ' + (results.timeUsed % 60) + 's';
  var totalTimeStr = Math.floor(results.totalTime / 60) + 'm ' + (results.totalTime % 60) + 's';

  /* Build summary */
  var summaryHtml = `
    <div class="row g-4 align-items-center mb-4">
      <div class="col-md-3 text-center">
        <div class="sk-result-ring" style="${ringStyle}">
          <div class="sk-result-ring-content">
            <div class="sk-result-percent">${percentage}%</div>
            <div class="sk-result-label">Your Score</div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="alert ${perfClass} mb-3"><i class="bi bi-info-circle-fill me-2"></i>${perfMsg}</div>
        <div class="row g-3">
          <div class="col-6 col-md-3">
            <div class="sk-stat" style="border-left: 4px solid var(--sk-navy);">
              <div class="sk-stat-number">${results.total}</div>
              <div class="sk-stat-label">Total Questions</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="sk-stat" style="border-left: 4px solid var(--sk-success);">
              <div class="sk-stat-number text-success">${correctCount}</div>
              <div class="sk-stat-label">Correct</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="sk-stat" style="border-left: 4px solid var(--sk-error);">
              <div class="sk-stat-number text-danger">${wrongCount}</div>
              <div class="sk-stat-label">Wrong</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="sk-stat" style="border-left: 4px solid var(--sk-text-muted);">
              <div class="sk-stat-number text-secondary-custom">${unanswered}</div>
              <div class="sk-stat-label">Unanswered</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  /* Time info for mock */
  if (isMock) {
    summaryHtml += `
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="sk-info-box">
            <h6><i class="bi bi-clock me-1"></i>Time Information</h6>
            <div class="sk-info-row"><span class="sk-info-label">Time Used</span><span class="sk-info-value">${timeUsedStr}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Total Time Allowed</span><span class="sk-info-value">${totalTimeStr}</span></div>
            <div class="sk-info-row"><span class="sk-info-label">Avg Time / Question</span><span class="sk-info-value">${Math.round(results.timeUsed / results.total)}s</span></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="sk-info-box">
            <h6><i class="bi bi-bar-chart me-1"></i>Performance Breakdown</h6>
            <div class="mb-2"><small class="text-secondary-custom">Correct (${correctCount})</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-success" style="width:${(correctCount/results.total)*100}%"></div></div></div>
            <div class="mb-2"><small class="text-secondary-custom">Wrong (${wrongCount})</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-error" style="width:${(wrongCount/results.total)*100}%"></div></div></div>
            <div><small class="text-secondary-custom">Unanswered (${unanswered})</small><div class="sk-progress mt-1"><div class="sk-progress-bar" style="width:${(unanswered/results.total)*100}%"></div></div></div>
          </div>
        </div>
      </div>
    `;
  }

  /* Question review */
  var reviewHtml = '<h4 class="sk-section-title mb-3">Question Review</h4>';
  results.questions.forEach(function(q, i) {
    var userAns = results.answers[i];
    var status = 'unanswered';
    var statusBadge = '<span class="sk-badge sk-badge-light">Unanswered</span>';
    if (userAns !== null) {
      if (userAns === q.correct) {
        status = 'correct';
        statusBadge = '<span class="sk-badge sk-badge-easy"><i class="bi bi-check-circle-fill"></i> Correct</span>';
      } else {
        status = 'incorrect';
        statusBadge = '<span class="sk-badge sk-badge-hard"><i class="bi bi-x-circle-fill"></i> Incorrect</span>';
      }
    }

    reviewHtml += `
      <div class="sk-review-item ${status}">
        <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
          <div><span class="sk-badge sk-badge-navy me-1">Q${i + 1}</span> ${statusBadge}</div>
          <div><span class="sk-badge sk-badge-light">${q.subject}</span> <span class="sk-badge sk-badge-light">${q.topic}</span></div>
        </div>
        <p class="fw-semibold mb-2">${q.question}</p>
        <div class="ps-3 border-start ms-1 mb-2">
          ${q.options.map(function(opt, j) {
            var cls = 'd-flex align-items-center gap-2 py-1';
            var icon = '';
            if (j === q.correct) { icon = '<i class="bi bi-check-circle-fill text-success"></i>'; cls += ' text-success fw-semibold'; }
            else if (j === userAns && userAns !== q.correct) { icon = '<i class="bi bi-x-circle-fill text-danger"></i>'; cls += ' text-danger'; }
            else { icon = '<i class="bi bi-circle text-muted"></i>'; }
            return `<div class="${cls}">${icon}<span>${String.fromCharCode(65 + j)}. ${opt}</span></div>`;
          }).join('')}
        </div>
        <div class="alert alert-light border mt-2 mb-0 py-2"><small><strong><i class="bi bi-info-circle me-1"></i>Explanation:</strong> ${q.explanation}</small></div>
      </div>
    `;
  });

  /* Action buttons */
  var actionHtml = `
    <div class="d-flex gap-2 flex-wrap mt-4">
      <a href="${isMock ? 'take-mock-test.html' : 'practice.html'}" class="btn btn-sk-gold"><i class="bi bi-arrow-repeat me-2"></i>Retake Test</a>
      <a href="${isMock ? 'mock-tests.html' : 'topic.html'}" class="btn btn-sk-outline"><i class="bi bi-arrow-left me-2"></i>Back to ${isMock ? 'Mock Tests' : 'Topic'}</a>
      <a href="index.html" class="btn btn-sk-light"><i class="bi bi-house me-2"></i>Home</a>
    </div>
  `;

  container.innerHTML = summaryHtml + '<hr class="sk-divider">' + reviewHtml + actionHtml;
}

/* ---------- Animate stat counters ---------- */
function animateCounters() {
  document.querySelectorAll('[data-counter]').forEach(function(el) {
    var target = parseInt(el.getAttribute('data-counter'));
    var duration = 1200;
    var startTime = null;
    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var value = Math.floor(progress * target);
      el.textContent = value.toLocaleString();
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target.toLocaleString();
    }
    requestAnimationFrame(step);
  });
}

/* ---------- Search filter on listing pages ---------- */
function initSearchFilter() {
  var searchInput = document.getElementById('sk-listing-search');
  if (!searchInput) return;
  var items = document.querySelectorAll('[data-searchable]');
  searchInput.addEventListener('input', function() {
    var query = searchInput.value.toLowerCase().trim();
    items.forEach(function(item) {
      var text = (item.getAttribute('data-searchable') || '').toLowerCase();
      if (text.indexOf(query) !== -1) {
        item.style.display = '';
      } else {
        item.style.display = 'none';
      }
    });
  });

  /* Difficulty filter chips */
  var diffChips = document.querySelectorAll('.sk-filter-chip[data-filter="difficulty"]');
  if (diffChips.length > 0) {
    diffChips.forEach(function(chip) {
      chip.addEventListener('click', function() {
        var val = chip.getAttribute('data-value');
        diffChips.forEach(function(c) { c.classList.remove('active'); });
        chip.classList.add('active');
        items.forEach(function(item) {
          var diff = item.getAttribute('data-difficulty') || '';
          if (val === 'all' || diff === val) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }
}
