app.controller('GameController', ["$scope", "$http","sessionService", "gameService", "inventoryService",
	
	function($scope, $http, sessionService, gameService, inventoryService) {
		$scope.sessionService = sessionService;
		$scope.gameService = gameService;
		$scope.inventoryService = inventoryService;

		$scope.click = function() {
			gameService.click();
		}

		$http.get("http://localhost:8000/factory")
			.then(function(response) {
				$scope.factories = response.data.message;
			});
		
		$scope.buyFactory = async function(id) {
			gameService.buyFactory(id);
		}

		$scope.myFactories = sessionService.getUser().factories;
		$scope.claim = function() {
			gameService.claim();
		}

		$scope.rate = gameService.getRate();

		$scope.upgradeFactory = function(id) {
			gameService.upgradeFactory(id);
		}
	}	
]);
