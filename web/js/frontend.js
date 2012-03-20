x$.ready(function() {
  var infoIcon = x$('.info')[0];

  x$('.databases li').each(function() {
    var description = x$('.description', this)[0];

    if (description) {
      description.style.display = 'none';
      x$('.sep', this)[0].style.display = 'none';

      var img = infoIcon.cloneNode(true);
      img.title = FR.trim(description.innerHTML);
      img.style.display = 'inline';

      this.appendChild(img);
    }
  });

  x$('.subject-widget select').each(function() {
    this.onchange = function() {
      this.parentNode.submit();
    };
  });

  x$('.subject-widget input').setStyle('display', 'none');
});

