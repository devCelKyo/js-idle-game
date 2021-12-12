var app = angular.module('App', ['ui.router']);

app.config(function($stateProvider, $urlRouterProvider) {

	$stateProvider
    .state('home', {
       url: '/home',
       templateUrl: 'pages/home/home.html'
    })
    .state('game', {
       url: '/game',
       templateUrl: 'pages/game/game.html'
    })
    .state('signin', {
      url: '/signin',
      templateUrl: 'pages/signin/signin.html'
   })
   .state('login', {
      url:'/login',
      templateUrl: 'pages/login/login.html'
   });

    $urlRouterProvider.otherwise('home');
});

app.controller("navbarController", ["$scope", "loginService", function($scope, loginService) {
	$scope.loginService = loginService;
}]);
