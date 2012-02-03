/**
 * Represents a jQuery UI Sortable linked to an input
 *
 * @constructor
 * @param {string} id - The desired ID for the <ul>
 */
FR.Backend.Sorter = function(id) {
  this.ul;
  this.connections  = [];
  this.isWeighted; 
  this.isRendered   = false;
  this.rows         = [];
  this.rowsToRender = [];

  this._init(id);
};

/**
 * @param {string} v
 */
FR.Backend.Sorter.prototype.setWeighted = function(v) {
};

/**
 * @param {array} FR.Backend.Sorter[] connections
 */
FR.Backend.Sorter.prototype.setConnections = function(connections) {
};

/**
 * @param {FR.Backend.SorterRow} row
 */
FR.Backend.Sorter.prototype.pushRow = function(row) {
};

/**
 * @return {HTMLUListElement}
 */
FR.Backend.Sorter.prototype.render = function() {
};

FR.Backend.Sorter.prototype._init = function() {
};

