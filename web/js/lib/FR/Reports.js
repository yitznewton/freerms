FR.Reports = {
  prepareLibraryFilter: function(uList, graph) {
    x$('input', uList).each(function(e) {
      e.checked = true;
      e.onchange = function() {
        var matches = this.id.match(/\d+$/);
        var $row    = x$('#library-' + matches[0]);

        this.checked ? $row.removeClass('suppress')
          : $row.addClass('suppress')

        // refresh graph
        graph.render();
      };
    });

    var selectAllInput = document.createElement('input');
    selectAllInput.id = 'library-select-all';
    selectAllInput.type = 'checkbox';
    selectAllInput.checked = true;
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

