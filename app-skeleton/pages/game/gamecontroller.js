app.controller('GameController', ["$scope", "$state", "sessionService",
	
	function($scope, $state, sessionService) {
		$scope.user = sessionService.getUser();
	}	
]);
