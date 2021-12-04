
myApp.factory('sampleFactory', function() {

  var sampleFunction=function() {

    console.log('hello, I am sampleFunction!');
    // any code here

  }

  return {
    sampleFunction : sampleFunction
  };

});
