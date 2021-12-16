app.controller('loginController', ["$scope", "loginService", function($scope, loginService) {
    
    $scope.login = function() {
        let data = {"username": $scope.username, "password": $scope.password};
        loginService.login(data, $scope);
    }
}]);