app.factory('gameService', ["$http", "sessionService", function($http, sessionService) {
    return {
        click:function() {
            let user = sessionService.getUser();
            $http.post('http://localhost:8000/click/'+ user.id);
        }
    };
}]);