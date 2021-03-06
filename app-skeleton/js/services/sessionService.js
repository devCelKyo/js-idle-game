app.factory('sessionService', function() {
    return {
        set:function(key, value) {
            return sessionStorage.setItem(key, value);
        },
        get:function(key) {
            return sessionStorage.getItem(key)
        },
        destroy:function(key) {
            return sessionStorage.removeItem(key);
        },
        getUser:function() {
            return JSON.parse(sessionStorage.getItem("user"));
        }
    };
});