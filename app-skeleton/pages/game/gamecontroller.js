app.controller('GameController', ["$scope", "$state","sampleFactory",
	function($scope, $state, sampleFactory) {
		console.log('this is the gamecontroller, hi!');
		sampleFactory.sampleFunction();

		let user = JSON.parse(sessionStorage.user);
		$scope.username = user.username;
	}
]);
