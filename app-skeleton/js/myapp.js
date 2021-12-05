var myApp = angular.module('myApp', ['ui.router']);


myApp.config(function($stateProvider, $urlRouterProvider) {

  $stateProvider

    .state('home', {
       url: '/home',
       templateUrl: 'home/home.html'
    })

    .state('game', {
       url: '/game',
       templateUrl: 'game/game.html'
    })

    .state('signin', {
      url: '/signin',
      templateUrl: 'signin/signin.html'
   });

    $urlRouterProvider.otherwise('home');

});
