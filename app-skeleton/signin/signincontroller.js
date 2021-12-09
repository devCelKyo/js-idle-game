myApp.controller('SigninController', ["$scope", "$state","sampleFactory", "$http",

  function($scope, $state, sampleFactory, $http) {

    console.log('this is the signincontroller, hi!');

    sampleFactory.sampleFunction();

    $scope.gotohome = function() {
      $state.go("home");
    };

    $scope.username = "";
    $scope.password = "";

    $scope.register = function() {
      var donnee = {
        username : $scope.username,
        password : $scope.password
      };
      donnee = JSON.stringify(donnee);
      console.log(donnee);
      $http.post('http://localhost:20000', donnee)
      .then(function(response) {
          console.log(response.data);
      });
    };

  }
]);
