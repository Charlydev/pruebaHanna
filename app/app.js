(function(){

'use strict';

var app = angular.module('modalApp', [
  'ngRoute',
  'Controllers']);

    app.config(['$routeProvider', function($routeProvider){
      $routeProvider.
        when('/', {
          templateUrl: 'views/usuarios.html',
          caseInsensitiveMatch: true,
          controller: 'usuarioController'
        })
        .when('/usuario', {
          templateUrl: 'views/usuarios.html',
          caseInsensitiveMatch: true,
          controller: 'usuarioController'
        })
        .when('/grilla', {
          templateUrl: 'views/grilla.html',
          caseInsensitiveMatch: true,
          controller: 'grillaController'
        })
        .otherwise({
          redirectTo: '/'
        });

      }])
})();