myApp.controller('HomeController', ["$scope", "$state", "$http",

  function($scope, $state, $http) {

    console.log('this is the homecontroller, hi!');

    $scope.userString = "default value";

    $scope.gotopage2 = function() {
      $state.go("page2");
    }

    $scope.op1 = 0;
    $scope.op2 = 0;
    $scope.operation = "";

    $scope.calc = function() {
      var donnee = {
        op1 : $scope.op1,
        op2 : $scope.op2,
        operation : $scope.operation
      };
      donnee = JSON.stringify(donnee);
      $http.post('http://lummerland.int-evry.fr:20000', donnee)
      .then(function(response) {
          console.log(response.data);
      });
    };

  }

  
]);
