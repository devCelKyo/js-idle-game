var myApp = angular.module('myApp', ['ui.router']);


myApp.config(function($stateProvider, $urlRouterProvider) {

  $stateProvider

    .state('home', {
       url: '/home',
       templateUrl: 'home/home.html'
    })

    .state('page2', {
       url: '/page2',
       templateUrl: 'page2/page2.html'
    });

    $urlRouterProvider.otherwise('home');

});
