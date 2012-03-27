/**
 * @constructor
 * @param {HTMLTableElement} table - The table to graph
 */
/**
 * @class
 */
FR.Reports.LineGraph.Bluff = function(table) {
  FR.Reports.LineGraph.call(this, table);
};

FR.Reports.LineGraph.Bluff.prototype = new FR.Reports.LineGraph();
FR.Reports.LineGraph.Bluff.prototype.constructor = FR.Reports.LineGraph.Bluff;

/**
 * @param {HTMLElement} target
 */
FR.Reports.LineGraph.Bluff.prototype.render = function(target) {
  var bluff = new Bluff.Line(target.id);

  bluff.tooltips = true;
  bluff.sort = false;
  bluff.hide_dots = true;

  bluff.theme_37signals();
  this._addRows(bluff);
  bluff.draw();
};

/**
 * @param {Bluff.Line} bluff
 */
FR.Reports.LineGraph.Bluff.prototype._addRows = function(bluff) {
  x$('tbody tr', this.table).each(function(tr) {
    if (tr.className.match(/\bsuppress\b/)) {
      return;
    }

    var data = [];

    x$('td', tr).each(function(td) {
      data.push(td.innerHTML);
    });

    bluff.data(x$('th', tr)[0].innerHTML, data);
  });

  var totalData = [];

  x$('tfoot td', this.table).each(function(td) {
    totalData.push(td.innerHTML);
  });

  bluff.data('Total', totalData);
};

