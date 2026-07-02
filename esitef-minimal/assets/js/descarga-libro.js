(function () {
  var form = document.querySelector('.descarga-libro-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    var email = form.querySelector('#descarga-email');
    if (!email) return;

    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    email.setCustomValidity('');
    if (!emailRe.test(email.value.trim())) {
      e.preventDefault();
      email.setCustomValidity('Introduce un email válido.');
      email.reportValidity();
    }
  });
})();
