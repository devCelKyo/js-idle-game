app.factory('databaseService', ["$http", "sessionService", function($http, sessionService) {
    return {
        updateUser:function() {
            let user = sessionService.getUser();
            $http.get("http://localhost:8000/user/"+user.id)
                .then(function(response) {
                    user = JSON.stringify(response.data);
                    sessionService.set("user", user);
                });
        }
    }
}]);