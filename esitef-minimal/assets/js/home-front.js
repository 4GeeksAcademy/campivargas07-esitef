/* ESITEF front page — typing, accordion, hero height */
(function () {
  var palabras = ['avanza', 'trasciende', 'inspira'];
  var idx = 0;
  var charIdx = 0;
  var eliminando = false;
  var enPausa = false;
  var elAnimado = document.getElementById('texto-animado');

  function typeWriter() {
    if (!elAnimado) return;
    if (enPausa) {
      enPausa = false;
      setTimeout(typeWriter, 1500);
      return;
    }
    var palabra = palabras[idx];
    if (!eliminando) {
      elAnimado.textContent = palabra.substring(0, charIdx + 1);
      charIdx++;
      if (charIdx === palabra.length) {
        eliminando = true;
        enPausa = true;
      }
    } else {
      elAnimado.textContent = palabra.substring(0, charIdx - 1);
      charIdx--;
      if (charIdx === 0) {
        eliminando = false;
        idx = (idx + 1) % palabras.length;
        enPausa = true;
      }
    }
    setTimeout(typeWriter, eliminando ? 45 : 85);
  }

  if (elAnimado) typeWriter();

  if (!document.querySelector('.header-navbar-v2')) {
    var btnToggle = document.getElementById('menu-toggle');
    var btnClose = document.getElementById('menu-close');
    var navMenu = document.getElementById('menu-menu-principal');

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
          link.parentElement.classList.toggle('sub-open');
        }
      });
    });
  }

  var accordionItems = document.querySelectorAll('.accordion-item');
  accordionItems.forEach(function (item) {
    item.addEventListener('mouseenter', function () {
      accordionItems.forEach(function (i) {
        i.classList.remove('active');
      });
      item.classList.add('active');
    });
    item.addEventListener('click', function () {
      accordionItems.forEach(function (i) {
        i.classList.remove('active');
      });
      item.classList.add('active');
      var href = item.getAttribute('data-href');
      if (href && window.innerWidth < 992) {
        window.location.href = href;
      }
    });
  });

  function ajustarHero() {
    var hero = document.querySelector('.hero-section');
    if (!hero) return;
    var topHero = hero.getBoundingClientRect().top + window.scrollY;
    var nuevaAltura = window.innerHeight - topHero;
    if (nuevaAltura > 100) {
      hero.style.height = nuevaAltura + 'px';
    }
  }

  ajustarHero();
  window.addEventListener('load', ajustarHero);
  window.addEventListener('resize', ajustarHero);
  if (window.visualViewport) {
    window.visualViewport.addEventListener('resize', ajustarHero);
    window.visualViewport.addEventListener('scroll', ajustarHero);
  }
})();
