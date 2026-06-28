/* ESITEF Navbar v2 — menú mobile/tablet estilo ESE Agency */
(function () {
  const header = document.querySelector('.header-navbar-v2');
  if (!header) return;

  const MQ = window.matchMedia('(max-width: 991px)');
  const btnToggle = document.getElementById('menu-toggle');
  const btnClose = document.getElementById('menu-close');
  const navMenu = document.getElementById('menu-menu-principal');
  const overlay = header.querySelector('.navbar-v2-overlay');
  const root = document.documentElement;

  if (!navMenu) return;

  let scrollY = 0;

  function setStaggerIndices() {
    let i = 0;
    navMenu.querySelectorAll(':scope > li:not(.nav-close)').forEach(function (li) {
      li.style.setProperty('--nav-i', String(i++));
    });
  }

  function lockScroll() {
    scrollY = window.scrollY || window.pageYOffset;
    root.classList.add('nav-v2-locked');
    document.body.style.position = 'fixed';
    document.body.style.top = '-' + scrollY + 'px';
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  }

  function unlockScroll() {
    root.classList.remove('nav-v2-locked');
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    document.body.style.width = '';
    window.scrollTo(0, scrollY);
  }

  function openMenu() {
    if (!MQ.matches) return;
    setStaggerIndices();
    lockScroll();
    header.classList.add('menu-open');
    navMenu.classList.add('active');
    btnToggle?.setAttribute('aria-expanded', 'true');
    btnToggle?.setAttribute('aria-label', 'Cerrar menú');
  }

  function closeMenu() {
    header.classList.remove('menu-open');
    navMenu.classList.remove('active');
    unlockScroll();
    navMenu.querySelectorAll('.sub-open').forEach(function (el) {
      el.classList.remove('sub-open');
    });
    navMenu.scrollTop = 0;
    btnToggle?.setAttribute('aria-expanded', 'false');
    btnToggle?.setAttribute('aria-label', 'Abrir menú');
  }

  function toggleMenu() {
    header.classList.contains('menu-open') ? closeMenu() : openMenu();
  }

  btnToggle?.addEventListener('click', toggleMenu);
  btnClose?.addEventListener('click', closeMenu);
  overlay?.addEventListener('click', closeMenu);

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && header.classList.contains('menu-open')) closeMenu();
  });

  MQ.addEventListener('change', function () {
    if (!MQ.matches) closeMenu();
  });

  navMenu.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (!MQ.matches) return;
      e.preventDefault();
      const parent = this.parentElement;
      const wasOpen = parent.classList.contains('sub-open');
      navMenu.querySelectorAll('.menu-item-has-children.sub-open').forEach(function (el) {
        if (el !== parent) el.classList.remove('sub-open');
      });
      parent.classList.toggle('sub-open', !wasOpen);
    });
  });

  setStaggerIndices();
})();
