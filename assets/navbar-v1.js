/* ESITEF Navbar v1 (backup) — menú hamburguesa original
 * Revertir v2 en cualquier página:
 *   1. Quitar class "header-navbar-v2" del <header>
 *   2. Quitar <div class="navbar-v2-overlay">
 *   3. Quitar <link href="assets/navbar-v2.css"> y <script src="assets/navbar-v2.js">
 *   4. Restaurar burger con <div class="toggle-icon"><span></span></div>
 *   5. Quitar <li class="nav-mobile-socials"> del menú
 * El CSS v1 sigue en el <style> inline de cada HTML.
 */
(function () {
  if (document.querySelector('.header-navbar-v2')) return;

  const btnToggle = document.getElementById('menu-toggle');
  const btnClose = document.getElementById('menu-close');
  const navMenu = document.getElementById('menu-menu-principal');

  if (btnToggle && navMenu) {
    btnToggle.addEventListener('click', function () {
      navMenu.classList.add('active');
    });
  }
  if (btnClose && navMenu) {
    btnClose.addEventListener('click', function () {
      navMenu.classList.remove('active');
    });
  }

  document.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (window.innerWidth < 992) {
        e.preventDefault();
        this.parentElement.classList.toggle('sub-open');
      }
    });
  });
})();
