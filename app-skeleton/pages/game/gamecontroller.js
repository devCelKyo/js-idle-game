app.controller('GameController', ["$scope", "$state","sampleFactory",
	function($scope, $state, sampleFactory) {
		console.log('this is the gamecontroller, hi!');
		sampleFactory.sampleFunction();
	}
]);