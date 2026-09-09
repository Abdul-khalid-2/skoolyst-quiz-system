/* ============================================================
   Skoolyst Smart Search — Google-style live search dropdown
   ============================================================ */
(function () {
  function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function highlight(text, term) {
    var safe = escapeHtml(text);
    var safeTerm = escapeHtml(term).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    if (!safeTerm) return safe;
    return safe.replace(new RegExp('(' + safeTerm + ')', 'ig'), '<mark>$1</mark>');
  }

  function initSmartSearch(root) {
    var input = root.querySelector('.sk-smart-search-input');
    var dropdown = root.querySelector('.sk-smart-search-dropdown');
    var clearBtn = root.querySelector('.sk-smart-search-clear');
    var apiUrl = root.getAttribute('data-search-api');
    var searchUrl = root.getAttribute('data-search-url');
    if (!input || !dropdown || !apiUrl) return;

    var debounceTimer = null;
    var currentController = null;
    var items = [];
    var activeIndex = -1;

    function closeDropdown() {
      dropdown.classList.remove('show');
      dropdown.innerHTML = '';
      items = [];
      activeIndex = -1;
    }

    function renderGroup(label, list) {
      if (!list.length) return '';
      var html = '<div class="sk-smart-search-group-label">' + label + '</div>';
      list.forEach(function (item) {
        html += '<a href="' + item.url + '" class="sk-smart-search-item" data-url="' + item.url + '">' +
            '<span class="sk-smart-search-item-icon"><i class="bi ' + item.icon + '"></i></span>' +
            '<span>' +
                '<span class="sk-smart-search-item-title d-block">' + highlight(item.title, input.value.trim()) + '</span>' +
                '<span class="sk-smart-search-item-meta">' + escapeHtml(item.meta) + '</span>' +
            '</span>' +
        '</a>';
      });
      return html;
    }

    function renderResults(data, term) {
      var total = data.subjects.length + data.topics.length + data.mcqs.length;

      if (total === 0) {
        dropdown.innerHTML = '<div class="sk-smart-search-empty"><i class="bi bi-emoji-frown me-1"></i>No matches for "' + escapeHtml(term) + '"</div>';
        dropdown.classList.add('show');
        items = [];
        activeIndex = -1;
        return;
      }

      var html = renderGroup('Subjects', data.subjects) + renderGroup('Topics', data.topics) + renderGroup('MCQs', data.mcqs);
      if (searchUrl) {
        html += '<div class="sk-smart-search-footer"><a href="' + searchUrl + '?q=' + encodeURIComponent(term) + '"><i class="bi bi-search me-1"></i>See all results for "' + escapeHtml(term) + '"</a></div>';
      }

      dropdown.innerHTML = html;
      dropdown.classList.add('show');
      items = Array.prototype.slice.call(dropdown.querySelectorAll('.sk-smart-search-item'));
      activeIndex = -1;
    }

    function fetchSuggestions(term) {
      if (currentController) currentController.abort();
      currentController = new AbortController();

      dropdown.innerHTML = '<div class="sk-smart-search-loading"><i class="bi bi-hourglass-split me-1"></i>Searching...</div>';
      dropdown.classList.add('show');

      fetch(apiUrl + '?q=' + encodeURIComponent(term), { signal: currentController.signal })
        .then(function (res) { return res.json(); })
        .then(function (data) { renderResults(data, term); })
        .catch(function (err) {
          if (err.name !== 'AbortError') closeDropdown();
        });
    }

    input.addEventListener('input', function () {
      var term = input.value.trim();
      clearBtn.classList.toggle('show', term.length > 0);
      clearTimeout(debounceTimer);

      if (term.length < 2) {
        closeDropdown();
        return;
      }

      debounceTimer = setTimeout(function () { fetchSuggestions(term); }, 250);
    });

    input.addEventListener('keydown', function (e) {
      if (!dropdown.classList.contains('show') || !items.length) return;

      if (e.key === 'ArrowDown') {
        e.preventDefault();
        activeIndex = (activeIndex + 1) % items.length;
        updateActive();
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        activeIndex = (activeIndex - 1 + items.length) % items.length;
        updateActive();
      } else if (e.key === 'Enter' && activeIndex >= 0) {
        e.preventDefault();
        window.location.href = items[activeIndex].getAttribute('data-url');
      } else if (e.key === 'Escape') {
        closeDropdown();
      }
    });

    function updateActive() {
      items.forEach(function (el, i) { el.classList.toggle('active', i === activeIndex); });
      if (activeIndex >= 0) items[activeIndex].scrollIntoView({ block: 'nearest' });
    }

    if (clearBtn) {
      clearBtn.addEventListener('click', function () {
        input.value = '';
        clearBtn.classList.remove('show');
        closeDropdown();
        input.focus();
      });
    }

    document.addEventListener('click', function (e) {
      if (!root.contains(e.target)) closeDropdown();
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sk-smart-search').forEach(initSmartSearch);
  });
})();
