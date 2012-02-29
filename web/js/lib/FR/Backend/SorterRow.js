/**
 * Represents a row in a Sorter
 *
 * @constructor
 * @param {string} title - The desired title for the item
 * @param {HTMLInputElement} inputEl - The weight input element to bind
 */
FR.Backend.SorterRow = function(title, inputEl) {
  /**
   * @type string
   */
  this.title;
  /**
   * @type HTMLInputElement
   */
  this.inputEl;
  /**
   * @type HTMLLiElement
   */
  this.liEL;
  /**
   * @type Boolean
   */
  this.isRendered = false;
  /**
   * @type function
   */
  this.onRemove;

  if (title.constructor != String) {
    throw new Error('title must be a string');
  }

  if (inputEl.tagName != 'INPUT') {
    throw new Error('inputEl must be an HTMLInputElement');
  }

  this.title   = title;
  this.inputEl = inputEl;
  this.liEl    = document.createElement('li');
};

/**
 * @param {Object} options
 * @returns {HTMLLIElement}
 */
FR.Backend.SorterRow.prototype.render = function(options) {
  if (typeof options === 'undefined') {
    options = {};
  }

  this.liEl.className = 'ui-state-default';
  this.liEl.innerHTML = this.title;
  this.liEl.sorterRow = this;  // needed for binding

  var spanArrow = document.createElement('span');
  spanArrow.className = 'ui-icon ui-icon-arrowthick-2-n-s';
  this.liEl.appendChild(spanArrow);

  if (typeof this.onRemove !== 'undefined') {
    // event handler was passed, therefore we should add button
    var spanClose = options.spanClose;

    if (!spanClose) {
      spanClose = document.createElement('span');
      spanClose.className = 'ui-icon ui-icon-close';
    }

    var spanSpinner = options.spanSpinner;

    if (!spanSpinner) {
      spanSpinner = document.createElement('span');
      spanSpinner.className = 'ui-icon ui-spinner';
    }

    spanClose.onclick = function(sorterRow) {
      return function() {
        if (!sorterRow.onRemove) {
          sorterRow.remove();
          return;
        }

        spanClose.style.display = 'none';
        spanSpinner.style.display = 'inline';

        sorterRow.onRemove({
          success: function() {
            sorterRow.remove();
          },

          error: function() {
            spanSpinner.style.display = 'none';
            spanClose.style.display = 'inline';
            alert('Action failed; please try again later.');
          },
        });
      }
    }(this)

    this.liEl.appendChild(spanClose);
    this.liEl.appendChild(spanSpinner);
  }

  this.isRendered = true;

  return this.liEl;
};

/**
 * @param {function} toFire
 */
FR.Backend.SorterRow.prototype.setOnRemove = function(onRemove) {
  this.onRemove = onRemove;
};

/**
 * @param {int} weight
 */
FR.Backend.SorterRow.prototype.setWeight = function(weight) {
  if (weight.constructor != Number) {
    throw new Error('weight must be a Number');
  }

  this.inputEl.value = weight;
};

/**
 * @returns {int}
 */
FR.Backend.SorterRow.prototype.getWeight = function() {
  return parseInt(this.inputEl.value);
};

FR.Backend.SorterRow.prototype.remove = function() {
  if (!this.isRendered) {
    return;
  }

  $(this.liEl).slideUp('fast', function() {
    if (this.parentNode) {
      this.parentNode.removeChild(this);
    }
  });
}

