(function () {
  document.querySelectorAll('.ayudar-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = tab.getAttribute('data-target');
      document.querySelectorAll('.ayudar-tab').forEach(function (t) {
        t.classList.remove('active');
      });
      document.querySelectorAll('.ayudar-tab-pane').forEach(function (p) {
        p.classList.remove('active');
      });
      tab.classList.add('active');
      var pane = document.getElementById(target);
      if (pane) pane.classList.add('active');
    });
  });
})();
