(() => {
  const toggle = document.querySelector('[data-menu-toggle]');
  const nav = document.querySelector('[data-nav]');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!open));
      nav.classList.toggle('open', !open);
      document.body.classList.toggle('nav-open', !open);
    });
  }
  document.querySelectorAll('[data-nav-trigger]').forEach(button => {
    button.addEventListener('click', event => {
      if (window.innerWidth > 980) return;
      event.preventDefault();
      const group = button.closest('[data-nav-group]');
      const wasOpen = group.classList.contains('open');
      document.querySelectorAll('[data-nav-group].open').forEach(item => {
        item.classList.remove('open');
        item.querySelector('[data-nav-trigger]')?.setAttribute('aria-expanded','false');
      });
      group.classList.toggle('open', !wasOpen);
      button.setAttribute('aria-expanded', String(!wasOpen));
    });
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) {
      nav?.classList.remove('open');
      document.body.classList.remove('nav-open');
      toggle?.setAttribute('aria-expanded','false');
    }
  }, { passive:true });
})();