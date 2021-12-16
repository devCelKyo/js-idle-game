app.controller('GameController', ["$scope", "$http","sessionService", "gameService",
	
	function($scope, $http, sessionService, gameService) {
		$scope.sessionService = sessionService;
		$scope.gameService = gameService;

		$scope.click = function() {
			gameService.click();
		}

		$http.get("http://localhost:8000/factory")
			.then(function(response) {
				$scope.factories = response.data.message;
			});
		
		$scope.buyFactory = async function(id) {
			gameService.buyFactory(id);
			$scope.rate = gameService.getRate();
			$scope.myFactories = sessionService.getUser().factories;
		}

		$scope.myFactories = sessionService.getUser().factories;
		$scope.claim = function() {
			gameService.claim();
		}

		$scope.rate = gameService.getRate();
	}	
]);
