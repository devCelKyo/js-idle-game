var app = angular.module('App', ['ui.router']);

app.config(function($stateProvider, $urlRouterProvider) {

	$stateProvider
    .state('home', {
       url: '/home',
       templateUrl: 'pages/home/home.html',
	   authenticate: false
    })
    .state('game', {
       url: '/game',
       templateUrl: 'pages/game/game.html',
	   authenticate: true
    })
    .state('signin', {
      url: '/signin',
      templateUrl: 'pages/signin/signin.html',
	  authenticate: false
   })
   .state('login', {
      url: '/login',
      templateUrl: 'pages/login/login.html',
	  authenticate: false
   })
   .state('inventory', {
      url: '/inventory',
      templateUrl: 'pages/inventory/inventory.html',
      authenticate: true
   });

    $urlRouterProvider.otherwise('home');
});

app.run(function($rootScope, $state, loginService) {
	$rootScope.$on("$stateChangeStart", function(event, toState) {
		if (toState.authenticate && !loginService.isLogged()) {
			$state.go("login");
			event.preventDefault();
		}
	});
});