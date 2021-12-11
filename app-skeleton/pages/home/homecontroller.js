app.controller('HomeController', ["$scope", "$state", "$http",

	function($scope, $state, $http) {

		console.log('this is the homecontroller, hi!');

		$scope.userString = "default value";

		$scope.gotogame = function() {
			$state.go("game");
		}

		$scope.gotosignin = function() {
			$state.go("signin");
		}

		$scope.op1 = 0;
		$scope.op2 = 0;
		$scope.operation = "";
  }

  
]);
