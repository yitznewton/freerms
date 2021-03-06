FR.Backend = {
  rootUrl: function() {
    var url_matches = window.location.href.match(/^.+admin[^\.]*\.php/);
    
    if ( url_matches ) {
      return url_matches[0];
    }
    else {
      throw new Error( 'Could not parse URL' );
    }
  },

  /**
   * @param {HTMLTableRowElement} tr
   * @param {String} urlMask
   */
  getSorterRow: function(tr, urlMask) {
    var row = new FR.Backend.SorterRow(
      $('label', tr).html(),
      $('.weight', tr).get(0)
    );

    if (urlMask) {
      var databaseId = $('.database-id', tr).val();

      // swap in database ID for placeholder in URL mask, and inject
      // AJAX as onRemove listener via this closure
      row.setOnRemove(function(onRemoveOptions) {
        return function(url) {
          var options = {url: url};

          if (typeof onRemoveOptions.success !== 'undefined') {
            options.success = onRemoveOptions.success;
          }

          if (typeof onRemoveOptions.error !== 'undefined') {
            options.error = onRemoveOptions.error;
          }

          $.ajax(options);
        }(urlMask.replace('%25', databaseId));
      });
    }
    
    return row;
  }
};

