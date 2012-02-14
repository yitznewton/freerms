x$.ready(function() {
  x$('.databases').each(function() {
    var description = x$('.description', this)[0];

    if (description) {
      description.style.display = 'none';
      x$('.sep', this)[0].style.display = 'none';

      var img           = x$('img', this)[0];
      img.title         = FR.trim(description.innerHTML);
      img.style.display = 'inline';
    }
  });

  x$('.subject-widget select').each(function() {
    this.onchange = function() {
      this.parentNode.submit();
    };
  });

  x$('.subject-widget input').setStyle('display', 'none');
});

