SorterRowTest = TestCase('SorterRowTest');

SorterRowTest.prototype.testConstructor_InvalidTitle_ThrowsError = function() {
  var inputEl = document.createElement('input');

  assertException(function() {
    var row = new FR.Backend.SorterRow(['foo'], inputEl);
  });
};

SorterRowTest.prototype.testConstructor_InvalidInputEl_ThrowsError = function() {
  assertException(function() {
    var row = new FR.Backend.SorterRow('foo', 'bar');
  });
};

SorterRowTest.prototype.testRender_ReturnsLi = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertTagName('LI', row.render());
};

SorterRowTest.prototype.testRender_ExpectedClassName = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertClassName('ui-state-default', row.render());
};

SorterRowTest.prototype.testRender_ExpectedTitle = function() {
  var inputEl = document.createElement('input');
  var row     = new FR.Backend.SorterRow('foo', inputEl);

  assertEquals('foo', row.render().innerHTML);
};

