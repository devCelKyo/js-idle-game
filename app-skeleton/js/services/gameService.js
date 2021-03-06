app.factory('gameService', ["$http", "sessionService", "databaseService", function($http, sessionService, databaseService) {
    return {
        click:function() {
            let user = sessionService.getUser();
            $http.post('http://localhost:8000/click/'+ user.id)
                .then(function() {
                    databaseService.updateUser();
                });
        },
        buyFactory:function(id) {
            let user = sessionService.getUser();
            Swal.showLoading();
            $http.post('http://localhost:8000/buy_factory/'+user.id+'/'+id)
                .then(function(response) {
                    let rep = response.data;
                    let icon;
                    if (rep.error) {
                        icon = "error";
                    }
                    else {
                        icon = "success";
                        databaseService.updateUser();
                    }

                    Swal.close();
                    Swal.fire({
                        icon: icon,
                        title: rep.message
                    });
                });
        },
        upgradeFactory:function(id) {
            Swal.showLoading();
            $http.post('http://localhost:8000/upgrade_factory/'+id)
            .then(function(response) {
                let rep = response.data;
                let icon;
                if (rep.error) {
                    icon = "error";
                }
                else {
                    icon = "success";
                    databaseService.updateUser();
                }

                Swal.close();
                Swal.fire({
                    icon: icon,
                    title: rep.message
                });
            });
        },
        claim:function() {
            let user = sessionService.getUser();
            Swal.showLoading();
            $http.post('http://localhost:8000/update/'+user.id)
                .then(function(response) {
                    databaseService.updateUser();
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: response.data.message
                    });
                });
        },
        getRate:function() {
            let user = sessionService.getUser();
            let rate = 0;
            for (const factory of user.factories) {
                rate += factory.rate;
            }
            return rate;
        },
        buyIron:function(price, amount) {
            let user = sessionService.getUser();
            Swal.showLoading();
            $http.post('http://localhost:8000/buy_iron/'+user.id, {price:price,amount:amount})
                .then(function(response) {
                    let rep = response.data;
                    let icon;
                    if(rep.error) {
                        icon = "error";
                    }
                    else {
                        icon = "success";
                        databaseService.updateUser();
                    }
                    Swal.close();
                    Swal.fire({
                        icon: icon,
                        title: rep.message
                    });
                })
        },
        buyGold:function(price, amount) {
            let user = sessionService.getUser();
            Swal.showLoading();
            $http.post('http://localhost:8000/buy_gold/'+user.id, {price:price,amount:amount})
                .then(function(response) {
                    let rep = response.data;
                    let icon;
                    if(rep.error) {
                        icon = "error";
                    }
                    else {
                        icon = "success";
                        databaseService.updateUser();
                    }
                    Swal.close();
                    Swal.fire({
                        icon: icon,
                        title: rep.message
                    });
                })
        }
    };
}]);