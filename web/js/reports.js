x$.ready(function() {
  var libraryFilter = FR.$$('filter-library');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
  }

  var monthlyToggle = FR.$$('monthly-toggle');

  if (monthlyToggle) {
    var primaryData = FR.$$('primary-data');

    var $toToggle = x$('thead th:not(:first-child):not(:last-child), td',
      primaryData);

    monthlyToggle.onclick = function() {
      for (i = 0; i < $toToggle.length; i++) {
        $toToggle[i].style.display =
          ($toToggle[i].style.display == 'table-cell'
            ? 'none' : 'table-cell');
      }

      return false;
    };
  }

  var graphCanvas = FR.$$('primary-graph-canvas');
  var graph = new FR.Reports.LineGraph.Flot(FR.$$('primary-data'));
  graph.setTarget(FR.$$('primary-graph-target'));
  graph.render();

  var uLists = x$('ul', libraryFilter);

  if (uLists.length > 0) {
    FR.Reports.prepareLibraryFilter(uLists[0], graph);
  }

  FR.$$('primary-graph').style.display = 'block';
});

