SorterRowTest = TestCase('SorterRowTest');

SorterRowTest.prototype.testConstructor_InvalidTitle_ThrowsError = function() {
  try {
    var row = new FR.Backend.SorterRow(['jim'], inputEl);
    fail();
  }
  catch (e) {
  }
};

SorterRowTest.prototype.testConstructor_InvalidInputEl_ThrowsError = function() {
};

SorterRowTest.prototype.testRender_ReturnsLi = function() {
};

