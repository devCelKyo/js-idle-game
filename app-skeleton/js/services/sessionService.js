app.factory('sessionService', ['$http', function($http) {
    return {
        set:function(key, value) {
            return sessionStorage.setItem(key, value);
        },
        get:function(key) {
            return sessionStorage.getItem(key)
        },
        destroy:function(key) {
            return sessionStorage.removeItem(key);
        }
    };
}]);