app.factory('sampleFactory', function() {
	
	var sampleFunction = function() {
		console.log('hello, I am sampleFunction!');
	}

	return {
		sampleFunction : sampleFunction
	};
});
