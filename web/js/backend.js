var FRBackend = {
  rootUrl: function() {
    var url_matches = window.location.href.match(/^.+backend[^\.]*\.php/);
    
    if (url_matches) {
      return url_matches[0];
    }
    else {
      throw new Error('Could not parse URL');
    }
  }
};

$(document).ready(function() {
  // setup subject sorters

  var databaseFormContainer = FR.$$('sf_admin_form_field_DatabaseSubject');

  if (databaseFormContainer) {
    var nonfeatured_sorter = new FRSorter('databases-nonfeatured');
    var featured_sorter    = new FRSorter('databases-featured');

    featured_sorter.setWeighted(true);
    featured_sorter.setConnections([nonfeatured_sorter]);
    nonfeatured_sorter.setWeighted(false);
    nonfeatured_sorter.setConnections([featured_sorter]);
    
    var subjectId = FR.$$('subject_id').value;

    $('input', databaseFormContainer).each( function() {
      var row  = new FRSorterRow('sometitle', this);
      var erId = 'somemungedthing';

      //FIXME relative URL
      var url = '/subject/ajax/remove/er_id/' + erId
                + '/subject_id/' + subjectId;

      row.setAjaxOnRemove(url);

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

    $('#sf_admin_content form').submit( function() {
      featured_sorter.bindInputs();
      nonfeatured_sorter.bindInputs();
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

