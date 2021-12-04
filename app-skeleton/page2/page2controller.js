myApp.controller('Page2Controller', ["$scope", "$state","sampleFactory",

  function($scope, $state, sampleFactory) {

    console.log('this is the page2controller, hi!');

    sampleFactory.sampleFunction();

    $scope.gotohome = function() {
      $state.go("home");
    }

  }
]);
