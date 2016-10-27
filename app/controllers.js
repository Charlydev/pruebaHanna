/**
 * List Controller
 * @version v1.0.0 - 2016-02-08 * @link http://www.mindtec.pe
 * @author MindTec <contacto@mindtec.pe>
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */
(function(){
  'use strict';

angular.module('Controllers', ['ui.bootstrap'])

.run(function() {
  
})

// Consulta externa
  .controller('usuarioController', ['$scope', '$http', function ($scope, $http) {

    //$scope.Departamentos=[{"Departamento":"Lima", "Codigo": "01"}, {"Departamento":"Lima", "Codigo": "01"}];
    
    var traemelo = function(){
      $http({
        method:'POST',
        url: 'https://soporte.intelecta.pe/demo/servicio.php',
        headers : { 'Content-Type': 'application/x-www-form-urlencoded' }})
        .success(function(response) {
            console.log(response);
            $scope.Departamentos = response;
        })
        .error(function() {
          
        });
      
    };

    console.log(traemelo());

  }]) // /#Consulta externa

  // Grilla
  .controller('grillaController', ['$scope', '$http', function ($scope, $http) {
      $scope.Listado = [];

      $scope.agregar = function(valor){
        console.log(valor.fechaemision.toLocaleDateString().split("/"))
        var fecha = valor.fechaemision.toLocaleDateString().split("/");

        valor.fecha2 = fecha[2]+'-'+fecha[1]+'-'+fecha[0];

        $scope.Listado.push(valor);
        console.log($scope.Listado);
        delete $scope.ncl;
      };

      $scope.calcular = function(valor){
        $scope.ncl.igv = valor*0.18;
        $scope.ncl.total = valor*1.18;          
      };

      $scope.guardarSAP = function(){
        $http({
          method:'POST',
          url: 'https://soporte.intelecta.pe/demo/guardarSAP.php',
          data: $.param({facturas: $scope.Listado}),
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' }})
          .success(function(response) {
              if(response=="ok") alert('Valores guardados exitosamente en SAP');
              else alert('Se encontró un error al tratar de guardar en SAP');
          })
          .error(function() {
            
          });
      };

  }]) // /#Grilla


})();
