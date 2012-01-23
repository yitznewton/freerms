var FreermsBackend = {
};

$(document).ready(function() {
  var forms = document.getElementsByTagName('FORM');
  var form = forms[0];

  $(document.getElementsByTagName('INPUT')).each(function() {
    this.onchange = function() {
      form.isDirty = true;
    };
  });

  $(document.getElementsByTagName('SELECT')).each(function() {
    this.onchange = function() {
      form.isDirty = true;
    };
  });

  $(document.getElementsByTagName('TEXTAREA')).each(function() {
    this.onchange = function() {
      form.isDirty = true;
    };
  });

  $('.link-clone').click(function() {
    if ($('form').get(0).isDirty) {
      var a = confirm('You have unsaved changes; press OK to continue or '
                    + 'Cancel to return to editing.');

      return a;
    }
  });
});

