x$.ready(function() {
  var libraryFilter = FR.$$('graph-filter');

  if (libraryFilter) {
    libraryFilter.style.display = 'block';
  }

  var primaryData = FR.$$('primary-data-table');
  var monthlyToggle = FR.$$('monthly-toggle');

  if (!primaryData) {
    // this is the index page
    return;
  }

  if (monthlyToggle) {
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

  var graph = new FR.Reports.LineGraph.Flot(primaryData);

  var uLists = x$('ul', libraryFilter);

  if (uLists.length > 0) {
    FR.Reports.prepareGraphFilter(uLists[0], graph);
  }

  graph.setTarget(FR.$$('primary-graph-target'));
  graph.render();

  var onsiteShareDl = FR.$$('onsite-share-list');

  var onsiteGraph = new FR.Reports.PieChart(onsiteShareDl);
  onsiteGraph.setTitle('Onsite Share');
  onsiteGraph.setTarget(FR.$$('onsite-share-canvas'));
  onsiteGraph.render();
  onsiteShareDl.style.display = 'none';

  var mobileShareDl = FR.$$('mobile-share-list');

  var mobileGraph = new FR.Reports.PieChart(mobileShareDl);
  mobileGraph.setTitle('Mobile Share');
  mobileGraph.setTarget(FR.$$('mobile-share-canvas'));
  mobileGraph.render();
  mobileShareDl.style.display = 'none';

  FR.$$('primary-graph').style.display = 'block';
});

