$(document).ready(function() {
  // setup subject sorters
  var databaseFormContainer = FR.$$('sf_admin_form_field_DatabaseSubject');

  if (databaseFormContainer) {
    $('table', databaseFormContainer).hide();

    var nonfeatured_sorter = new FR.Backend.Sorter('databases-nonfeatured');
    var featured_sorter    = new FR.Backend.Sorter('databases-featured');

    featured_sorter.setWeighted(true);
    featured_sorter.setConnection(nonfeatured_sorter);
    nonfeatured_sorter.setWeighted(false);
    nonfeatured_sorter.setConnection(featured_sorter);
    
    var urlMaskEl = FR.$$('delete-url-mask');

    $('table table tr', databaseFormContainer).each( function() {
      var row = new FR.Backend.SorterRow(
        $('label', this).html(),
        $('.weight', this).get(0));

      if (urlMaskEl) {
        var databaseId = $('.database-id', this).val();

        // swap in database ID for placeholder in URL mask, and inject
        // AJAX as onRemove listener via this closure
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

    $('#sf_admin_content form').submit(function() {
      featured_sorter.update();
      nonfeatured_sorter.update();
    });
  }

  var homepageFeaturedContainer = FR.$$('featured-databases');

  if (homepageFeaturedContainer) {
    $('table', homepageFeaturedContainer).hide();

    var sorter = new FR.Backend.Sorter('featured-sorter');
    sorter.setWeighted(true);
    
    //var urlMaskEl = FR.$$('delete-url-mask');
    var urlMaskEl = null;

    $('table table table tr', homepageFeaturedContainer).each( function() {
      var row = new FR.Backend.SorterRow(
        $('label', this).html(),
        $('.weight', this).get(0));

      if (urlMaskEl) {
        var databaseId = $('.database-id', this).val();

        // swap in database ID for placeholder in URL mask, and inject
        // AJAX as onRemove listener via this closure
        row.setOnRemove(function() {
          return function(url) {
            jQuery.ajax(url);
          }(urlMaskEl.title.replace('%25', databaseId));
        });
      }

      sorter.pushRow(row); 
    });
    
    $(homepageFeaturedContainer).prepend(sorter.render());

    $('#sf_admin_content form').submit(function() {
      sorter.update();
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

