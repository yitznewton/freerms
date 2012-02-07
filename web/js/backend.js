$(document).ready(function() {
  // setup subject sorters

  var databaseFormContainer = FR.$$('sf_admin_form_field_DatabaseSubject');

  if (databaseFormContainer) {
    var nonfeatured_sorter = new FR.Backend.Sorter('databases-nonfeatured');
    var featured_sorter    = new FR.Backend.Sorter('databases-featured');

    featured_sorter.setWeighted(true);
    featured_sorter.setConnection(nonfeatured_sorter);
    nonfeatured_sorter.setWeighted(false);
    nonfeatured_sorter.setConnection(featured_sorter);
    
    var subjectId = FR.$$('subject_id').value;
    var urlMaskEl = FR.$$('delete-url-mask');

    $('table table tr', databaseFormContainer).each( function() {
      var weightInputEl = $('.weight', this).get(0);
      var title = $('label', this).html();
      var row  = new FR.Backend.SorterRow(title, weightInputEl);

      if (urlMaskEl) {
        var databaseId = $('.database-id', this).val();

        // swap in database ID for placeholder in URL mask, and inject
        // as listener via this closure
        row.setOnRemove(function() {
          return function(url) {
            jQuery.ajax(url);
          }(urlMaskEl.title.replace('%25', databaseId));
        });
      }

      if (row.getWeight() === -1) {
        nonfeatured_sorter.pushRow(row);
      }
      else {
        featured_sorter.pushRow(row); 
      }
    });
    
    $(databaseFormContainer)
      .append($('<h3>Featured databases</h3>'))
      .append(featured_sorter.render())
      .append($('<h3>Non-featured databases</h3>'))
      .append(nonfeatured_sorter.render())
      ;

    // FIXME do we have to wait til here to hide this?
    $('table', databaseFormContainer).hide();

    $('#sf_admin_content form').submit(function() {
      featured_sorter.update();
      nonfeatured_sorter.update();
    });
  }

  // setup form dirty detection
  var forms = document.getElementsByTagName('FORM');
  var form = forms[0];

  form.isDirty = false;

  $.each(document.getElementsByTagName('INPUT'), function() {
    this.onchange = function() {
      form.isDirty = true;
    };
  });

  $.each(document.getElementsByTagName('SELECT'), function() {
    this.onchange = function() {
      form.isDirty = true;
    };
  });

  $.each(document.getElementsByTagName('TEXTAREA'), function() {
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

