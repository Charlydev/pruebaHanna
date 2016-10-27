<?php
//header('Access-Control-Allow-Headers: *');
//Access-Control-Allow-Methods: GET, POST, OPTIONS
header('Access-Control-Allow-Origin: *');

$respuesta= array();
$array = array('Departamento' => 'Lima', 'Codigo' => '01');
array_push($respuesta, $array);
$array = array('Departamento' => 'Callao', 'Codigo' => '01');
array_push($respuesta, $array);
$array = array('Departamento' => 'Junin', 'Codigo' => '063');
array_push($respuesta, $array);

echo json_encode($respuesta);
?>