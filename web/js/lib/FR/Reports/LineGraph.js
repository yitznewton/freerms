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
  /** 
   * @type HTMLElement
   */
  this.target;
};

/**
 * @param {HTMLElement} target
 */
FR.Reports.LineGraph.prototype.setTarget = function(target) {
  this.target = target;
};

FR.Reports.LineGraph.prototype.render = function() {
  throw new Error('abstract');
};

