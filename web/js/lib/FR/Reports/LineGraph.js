/**
 * @constructor
 * @param {HTMLTableElement} table - The table to graph
 */
/**
 * @class
 */
FR.Reports.LineGraph = function(table) {
  /**
   * @type HTMLTableElement
   */
  this.table = table;
};

/**
 * @param {HTMLElement} target
 */
FR.Reports.LineGraph.prototype.render = function(target) {
  throw new Error('abstract');
};

