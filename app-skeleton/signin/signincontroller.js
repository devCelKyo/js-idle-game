myApp.controller('SigninController', ["$scope", "$state","sampleFactory",

  function($scope, $state, sampleFactory) {

    console.log('this is the signincontroller, hi!');

    sampleFactory.sampleFunction();

    $scope.gotohome = function() {
      $state.go("home");
    }

  }
]);
