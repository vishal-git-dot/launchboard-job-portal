(() => {
  const root = document.documentElement;
  const themeButton = document.querySelector('.theme-toggle');
  const setTheme = (theme) => {
    root.dataset.theme = theme;
    try { localStorage.setItem('launchboard-theme', theme); } catch (_) {}
    if (themeButton) {
      const dark = theme === 'dark';
      themeButton.querySelector('.theme-icon').textContent = dark ? '☀' : '☾';
      themeButton.querySelector('.theme-label').textContent = dark ? 'Light Mode' : 'Dark Mode';
      themeButton.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
    }
  };
  setTheme(root.dataset.theme || 'light');
  themeButton?.addEventListener('click', () => setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark'));

  const menu = document.querySelector('.mobile-menu');
  const nav = document.querySelector('.main-nav');
  menu?.addEventListener('click', () => {
    const open = menu.getAttribute('aria-expanded') !== 'true';
    menu.setAttribute('aria-expanded', String(open)); nav?.classList.toggle('nav-open', open);
  });
  document.querySelector('.toast-close')?.addEventListener('click', () => document.querySelector('.toast')?.remove());
  document.querySelectorAll('.toast').forEach(t => { window.setTimeout(() => { t.classList.add('toast-out'); window.setTimeout(() => t.remove(), 300); }, 5200); });

  const role = document.querySelector('#account-role');
  const company = document.querySelector('#company-field');
  const syncRole = () => { if (role && company) { const show = role.value === 'admin'; company.hidden = !show; const input = company.querySelector('input'); if (input) input.required = show; } };
  role?.addEventListener('change', syncRole); syncRole();

  document.querySelectorAll('input[type="file"]').forEach(input => input.addEventListener('change', () => {
    const file = input.files?.[0]; const box = input.closest('.upload-box'); if (!box || !file) return;
    box.querySelector('strong').textContent = file.name; box.querySelector('small').textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB · ready to upload`; box.classList.add('upload-selected');
  }));

  const observer = ('IntersectionObserver' in window) ? new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } }), { threshold: 0.08 }) : null;
  document.querySelectorAll('.reveal').forEach(el => observer ? observer.observe(el) : el.classList.add('is-visible'));
})();
