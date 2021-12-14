app.factory('loginService', ['$http', '$location', 'sessionService', function($http, $location, sessionService) {
    return {
        login:function(data, scope) {
            Swal.showLoading();
            $http.post('http://localhost:8000/login', data)
                .then(function(response) {
                    Swal.close();
                    let rep = response.data;
                    if (!rep.error) {
                        let userJson = JSON.stringify(rep.message.account);
                        sessionService.set('user', userJson);
                        $location.path('/game');
                    }
                    else {
                        Swal.close();
                        Swal.fire({
                            icon: "error",
                            title: "Identifiants incorrects"
                        });
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