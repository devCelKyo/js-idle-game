app.factory("inventoryService", ["sessionService", function(sessionService) {
    return {
        getIron:function() {
            let user = sessionService.getUser();
            let inventory = user.inventory;
            return inventory.amounts[0];
        },
        getGold:function() {
            let user = sessionService.getUser();
            let inventory = user.inventory;
            return inventory.amounts[1];
        }
    };
}]);