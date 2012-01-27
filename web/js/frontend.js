x$.ready(function() {
  x$('.databases').each(function() {
    var description = x$('.description', this)[0];
    var img         = x$('img', this)[0];

    description.style.display = 'none';
    x$('.sep', this)[0].style.display = 'none';

    img.title = FR.trim(description.innerHTML);
    img.style.display = 'inline';
  });
});

