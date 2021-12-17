app.controller("InventoryController", ["$scope", "sessionService", "inventoryService", "gameService", "$http", function($scope, sessionService, inventoryService, gameService, $http) {
    $scope.inventoryService = inventoryService;
    $scope.sessionService = sessionService;
    $scope.gameService = gameService;

    $http.get("https://financialmodelingprep.com/api/v3/quote-short/SI?apikey=ab392410bfefdb2a377a3780b42cb3aa")
        .then(function(response) {
            $scope.ironPrice = parseInt(response.data[0].price);
        });
    
    $http.get("https://financialmodelingprep.com/api/v3/quote-short/GOLD?apikey=ab392410bfefdb2a377a3780b42cb3aa")
        .then(function(response) {
            $scope.goldPrice = parseInt(response.data[0].price*100);
        });
    
    $scope.buyIron = function() {
        gameService.buyIron($scope.ironPrice, $scope.amountIron);
        $scope.amountIron = "";
    }

    $scope.buyGold = function() {
        gameService.buyGold($scope.goldPrice, $scope.amountGold);
        $scope.amountGold = "";
    }

    $scope.maxIron = function() {
        $scope.amountIron = Math.floor(sessionService.getUser().money/$scope.ironPrice);
    }

    $scope.maxGold = function() {
        $scope.amountGold = Math.floor(sessionService.getUser().money/$scope.goldPrice);
    }
}]);