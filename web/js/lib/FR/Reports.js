FR.Reports = {
  prepareGraphFilter: function(uList, graph) {
    var trCollection = x$('tbody tr', graph.getTable());

    for (i = 5; i < trCollection.length; i++) {
      // only display the first five by default
      trCollection[i].className += ' suppress';
    }

    x$('input', uList).each(function(e, i) {
      var matches = this.id.match(/^graph_(.*)$/);
      var $row    = x$('#library-' + matches[1]);

      if (!$row.hasClass('suppress')) {
        e.checked = true;
      }

      e.onchange = function() {
        this.checked ? $row.removeClass('suppress')
          : $row.addClass('suppress')

        // refresh graph
        graph.render();
      };
    });

    var selectAllInput = document.createElement('input');
    selectAllInput.id = 'library-select-all';
    selectAllInput.type = 'checkbox';
    selectAllInput.checked = false;
    selectAllInput.onchange = function() {
      FR.Reports.librarySelectAllToggle(this, uList);
    };

    selectAllLabel = document.createElement('label');
    selectAllLabel.setAttribute('for', 'library-select-all');
    selectAllLabel.innerHTML = '\nSelect All/None';

    var selectAllLI = document.createElement('li');
    selectAllLI.className = 'all';
    selectAllLI.appendChild(selectAllInput);
    selectAllLI.appendChild(selectAllLabel);
    uList.appendChild(selectAllLI);
  },

  librarySelectAllToggle: function(item, uList) {
    x$('li', uList).each(function(e) {
      if (e.className !== 'all') {
        var input = x$('input', e)[0];
        input.checked = item.checked;
        input.onchange();
      }
    });
  }
}

