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
  var graph = new FR.Reports.LineGraph.Bluff(FR.$$('primary-data'));
  graph.render(graphCanvas);

  FR.$$('primary-graph').style.display = 'block';
});

