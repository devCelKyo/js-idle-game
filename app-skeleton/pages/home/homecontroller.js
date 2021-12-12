app.controller('HomeController', ["$scope", "loginService",
	function($scope, loginService) {
		$scope.loginService = loginService;

		$scope.ok = function() {
			return true;
		}
	}
]);
