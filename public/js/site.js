const menuToggle = document.querySelector('[data-menu-toggle]');
const nav = document.querySelector('[data-nav]');

const closeGroups = except => {
  document.querySelectorAll('[data-nav-group]').forEach(group => {
    if (group === except) return;
    group.classList.remove('open', 'dropdown-open');
    const trigger = group.querySelector('[data-nav-trigger]');
    if (trigger) trigger.setAttribute('aria-expanded', 'false');
  });
};

if (menuToggle && nav) {
  const setMenu = open => {
    nav.classList.toggle('open', open);
    menuToggle.setAttribute('aria-expanded', String(open));
    document.documentElement.classList.toggle('nav-open', open);
    if (!open) closeGroups();
  };
  menuToggle.addEventListener('click', () => setMenu(!nav.classList.contains('open')));
  nav.addEventListener('click', event => {
    if (window.innerWidth <= 980 && event.target.closest('a')) setMenu(false);
  });
  window.addEventListener('resize', () => {
    if (window.innerWidth > 980 && nav.classList.contains('open')) setMenu(false);
  });
}

document.querySelectorAll('[data-nav-group]').forEach(group => {
  const trigger = group.querySelector('[data-nav-trigger]');
  if (!trigger) return;
  trigger.addEventListener('click', event => {
    event.preventDefault();
    event.stopPropagation();
    const opening = !group.classList.contains('open');
    closeGroups(group);
    group.classList.toggle('open', opening);
    group.classList.toggle('dropdown-open', opening);
    trigger.setAttribute('aria-expanded', String(opening));
  });
});

document.addEventListener('click', event => {
  if (!event.target.closest('[data-nav-group]')) closeGroups();
});
document.addEventListener('keydown', event => {
  if (event.key !== 'Escape') return;
  closeGroups();
  if (nav) nav.classList.remove('open');
  if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
});

const header = document.querySelector('[data-header]');
if (header) {
  const updateHeader = () => header.classList.toggle('scrolled', window.scrollY > 8);
  updateHeader();
  window.addEventListener('scroll', updateHeader, { passive: true });
}

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
if (!reducedMotion && 'IntersectionObserver' in window) {
  const targets = [
    ...document.querySelectorAll('main > section:not(.hero):not(.page-hero)'),
    ...document.querySelectorAll('.quick-grid > a,.process-grid > div,.content-cards > article,.news-card,.bulletin-list > a')
  ];
  const unique = [...new Set(targets)];
  unique.forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(18px)';
    item.style.transition = 'opacity .55s ease ' + Math.min(index % 5, 4) * 45 + 'ms, transform .55s ease ' + Math.min(index % 5, 4) * 45 + 'ms';
  });
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      observer.unobserve(entry.target);
    });
  }, { rootMargin: '0px 0px -7% 0px', threshold: 0.05 });
  unique.forEach(item => observer.observe(item));
}
