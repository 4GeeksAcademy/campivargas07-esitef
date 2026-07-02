(function () {
  var accordionItems = document.querySelectorAll('.presencial-page .accordion-item, .course-syllabus .accordion-item');
  accordionItems.forEach(function (item) {
    var header = item.querySelector('.accordion-header');
    var content = item.querySelector('.accordion-content');
    if (!header || !content) return;

    header.addEventListener('click', function () {
      var isActive = item.classList.contains('active');

      accordionItems.forEach(function (acc) {
        acc.classList.remove('active');
        var h = acc.querySelector('.accordion-header');
        var c = acc.querySelector('.accordion-content');
        if (h) h.setAttribute('aria-expanded', 'false');
        if (c) c.style.maxHeight = null;
      });

      if (!isActive) {
        item.classList.add('active');
        header.setAttribute('aria-expanded', 'true');
        content.style.maxHeight = content.scrollHeight + 'px';
      }
    });
  });
})();
