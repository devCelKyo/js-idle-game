app.factory('loginService', ['$http', '$location', 'sessionService', function($http, $location, sessionService) {
    return {
        login:function(data, scope) {
            console.log(data);
            $http.post('http://localhost:8000/login', data)
                .then(function(response) {
                    let rep = response.data;
                    if (!rep.error) {
                        let userJson = JSON.stringify(rep.message.account);
                        sessionService.set('user', userJson);
                        $location.path('/home');
                    }
                    else {
                        scope.msgtext = rep.message.message;
                        $location.path('/login');
                    }
                });
        },
        logout:function() {
            sessionService.destroy('user');
            $location.path('/home');
        },
        isLogged:function() {
            if (sessionService.get('user')) {
                return true;
            }
            return false;
        }
    }
}]);