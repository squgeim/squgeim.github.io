(function () {
  var toggle = document.getElementById('theme-toggle');
  if (!toggle) return;

  function current() {
    return document.documentElement.getAttribute('data-theme') || 'dark';
  }

  function apply(theme) {
    if (theme === 'light') {
      document.documentElement.setAttribute('data-theme', 'light');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
    toggle.title = theme === 'light' ? 'Switch to dark mode' : 'Switch to light mode';
    toggle.textContent = theme === 'light' ? '\u263e' : '\u2600';
  }

  apply(current());

  toggle.addEventListener('click', function () {
    var next = current() === 'light' ? 'dark' : 'light';
    localStorage.setItem('theme', next);
    apply(next);
  });

  window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function (e) {
    if (!localStorage.getItem('theme')) {
      apply(e.matches ? 'light' : 'dark');
    }
  });
})();
