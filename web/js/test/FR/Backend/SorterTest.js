SorterTest = TestCase('SorterTest');

SorterTest.prototype.testConstructor_InvalidArg_ThrowsError = function() {
  try {
    var sorter = new FR.Backend.Sorter(['jim']);
    fail();
  }
  catch (e) {
  }
};

SorterTest.prototype.testRender_ReturnsHTMLUListElement = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertEquals('[object HTMLUListElement]',
    Object.prototype.toString.call(sorter.render()));
};

SorterTest.prototype.testRender_ElementHasExpectedLiCount = function() {
  var sorter = new FR.Backend.Sorter('foo');

  sorter.pushRow(new FR.Backend.SorterRow(
    'xyz', document.createElement('input')));
  sorter.pushRow(new FR.Backend.SorterRow(
    'abs', document.createElement('input')));

  var ul = sorter.render();

  assertEquals(2, $('li', ul).length);
};

SorterTest.prototype.testRender_ElementHasExpectedId = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertEquals('foo', sorter.render().id); 
};

SorterTest.prototype.testRender_ElementHasExpectedClasses = function() {
  var sorter = new FR.Backend.Sorter('foo');

  assertEquals('sortable', sorter.render().className); 
};

SorterTest.prototype.testRender_ConnectionsSet_HasExpectedConnection = function() {
};

SorterTest.prototype.testRender_Weighted_ExpectedOrder = function() {
};

SorterTest.prototype.testPushRow_InvalidArg_ThrowsError = function() {
};

SorterTest.prototype.testSetConnections_InvalidArg_ThrowsError = function() {
};

