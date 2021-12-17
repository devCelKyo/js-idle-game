app.factory("stockService", ["$http", function($http) {
    return {
        getIronPrice:function() {
            $http.get('https://financialmodelingprep.com/api/v3/quote-short/SI?apikey=a3554eb700284aca5446d9f6e61d17b5')
                .then(function(response) {
                    response.data;
                });
        },
        getGoldPrice:function() {
            $http.get('https://financialmodelingprep.com/api/v3/quote-short/GOLD?apikey=a3554eb700284aca5446d9f6e61d17b5')
            .then(function(response) {
                return response.data.price;
            });
        }
    }
}]);