/**
 * Represents a jQuery UI Sortable linked to an input
 *
 * @constructor
 * @param {string} id - The desired ID for the <ul>
 */
function FRSorter(id)
{
  this.ul;
  this.connections  = [];
  this.isWeighted; 
  this.isRendered   = false;
  this.rows         = [];
  this.rowsToRender = [];

  this._init(id);
}

/**
 * @param {string} v
 */
FRSorter.prototype.setWeighted = function(v) {
}

/**
 * @param {array} FRSorter[] connections
 */
FRSorter.prototype.setConnections = function(connections) {
}

/**
 * @param {FRSorterRow} row
 */
FRSorter.prototype.pushRow = function(row) {
}

/**
 * @return {HTMLUListElement}
 */
FRSorter.prototype.render = function() {
}

FRSorter.prototype._init = function() {
}

