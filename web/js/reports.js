x$.ready(function() {
  var libraryFilter = FR.$$('filter-library');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
  }

  var uList = x$('ul', libraryFilter)[0];

  if (uList) {
    FR.Reports.prepareLibraryFilter(uList);
  }

  var graphCanvas = FR.$$('primary-graph-canvas');
  var graph = new FR.Reports.LineGraph.Flot(FR.$$('primary-data'));
  graph.render(FR.$$('primary-graph-target'));

  FR.$$('primary-graph').style.display = 'block';
});

