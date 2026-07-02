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
