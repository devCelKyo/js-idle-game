app.controller("navbarController", ["$scope", "loginService", "sessionService", function($scope, loginService, sessionService) {
	$scope.loginService = loginService;
    $scope.sessionService = sessionService;
}]);
