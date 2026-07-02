/* ESITEF — transición difuminada hacia login */
(function () {
  var DURATION = 520;
  var KEY = 'esitef-login-transition';

  function isLoginPage() {
    return /login\.html$/i.test(location.pathname)
      || /\/ingresar\/?$/i.test(location.pathname);
  }

  function isLoginLink(link) {
    if (!link || link.tagName !== 'A') return false;
    if (link.target === '_blank') return false;
    var href = (link.getAttribute('href') || '').trim();
    return link.classList.contains('js-login-link')
      || href === 'login.html'
      || /\/login\.html$/.test(href)
      || /\/ingresar\/?$/.test(href);
  }

  function runExitTransition(url) {
    if (document.querySelector('.login-transition-veil')) return;

    var veil = document.createElement('div');
    veil.className = 'login-transition-veil';
    veil.setAttribute('aria-hidden', 'true');
    document.body.appendChild(veil);

    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        veil.classList.add('login-transition-veil--active');
      });
    });

    setTimeout(function () {
      window.location.href = url;
    }, DURATION);
  }

  document.addEventListener('click', function (e) {
    var link = e.target.closest('a');
    if (!isLoginLink(link)) return;
    e.preventDefault();
    sessionStorage.setItem(KEY, '1');
    runExitTransition(link.href);
  });

  if (isLoginPage() && sessionStorage.getItem(KEY)) {
    sessionStorage.removeItem(KEY);
    document.documentElement.classList.add('login-transition-enter');
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        document.documentElement.classList.add('login-transition-enter--done');
      });
    });
  }
})();
