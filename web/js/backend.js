$(document).ready(function() {
  // setup subject sorters
  var databaseFormContainer = FR.$$('sf_admin_form_field_DatabaseSubject');

  if (databaseFormContainer) {
    var contentDiv = FR.$$('database-embedded-container');

    $(contentDiv).children('table').hide();

    var nonfeatured_sorter = new FR.Backend.Sorter('databases-nonfeatured');
    var featured_sorter    = new FR.Backend.Sorter('databases-featured');

    featured_sorter.setWeighted(true);
    featured_sorter.setConnection(nonfeatured_sorter);
    nonfeatured_sorter.setWeighted(false);
    nonfeatured_sorter.setConnection(featured_sorter);
    
    var urlMaskEl = FR.$$('delete-url-mask');
    var urlMask = (urlMaskEl && urlMaskEl.title) || null;

    $('table', contentDiv).find('table').find('tr').each(function() {
      var row = FR.Backend.getSorterRow(this, urlMask);

      if (row.getWeight() === -1) {
        nonfeatured_sorter.pushRow(row);
      }
      else {
        featured_sorter.pushRow(row); 
      }
    });
    
    $(contentDiv)
      .append($('<h3>Featured databases</h3>'))
      .append(featured_sorter.render())
      .append($('<h3>Non-featured databases</h3>'))
      .append(nonfeatured_sorter.render());

    document.getElementsByTagName('FORM')[0].onsubmit = function() {
      featured_sorter.update();
      nonfeatured_sorter.update();
    };
  }

  var homepageFeaturedContainer = FR.$$('featured-databases');

  if (homepageFeaturedContainer) {
    var parentTable = FR.$$('featured-parent-table');
    parentTable.style.display = 'none';

    var sorter = new FR.Backend.Sorter('featured-sorter');
    sorter.setWeighted(true);
    
    var urlMaskEl = FR.$$('delete-url-mask');
    var urlMask = (urlMaskEl && urlMaskEl.title) || null;

    $('table', parentTable).find('table').find('tr').each(function() {
      sorter.pushRow(FR.Backend.getSorterRow(this, urlMask)); 
    });
    
    $(homepageFeaturedContainer).prepend(sorter.render());

    document.getElementsByTagName('FORM')[0].onsubmit = function() {
      sorter.update();
    };
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
      var a = window.confirm('You have unsaved changes; press OK to continue '
        + 'or Cancel to return to editing.');

      return a;
    }
  });
});

