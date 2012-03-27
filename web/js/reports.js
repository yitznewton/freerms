x$.ready(function() {
  var libraryFilter = FR.$$('filter-library');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
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

