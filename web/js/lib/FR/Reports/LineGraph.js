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
 * @returns {HTMLTableElement}
 */
FR.Reports.LineGraph.prototype.getTable = function() {
  return this.table;
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

