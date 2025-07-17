<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');
require_once ("../conexion.php");
require_once ("../modelo/hoja_vida_taxis.php");
$vec = ['error' => 'Operación no válida'];
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
    ob_end_clean();
    http_response_code(200);
    exit(); 
}
$control = $_GET['control'] ?? null;
if ($control === null) {
    ob_end_clean();
    echo json_encode(['error' => 'Parámetro "control" no especificado en la URL.']);
    exit();
}
$hoja_vida_taxi_instancia = new hoja_vida_taxis($conexion);
switch ($control) {
    case 'consultar':
        $vec = $hoja_vida_taxi_instancia->consulta();
        break;
    case 'insertar':
        $json = file_get_contents('php://input');
        error_log("JSON recibido: " . $json);
        $params = json_decode($json, true);
        if ($params === null && json_last_error() !== JSON_ERROR_NONE) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'Datos JSON inválidos: ' . json_last_error_msg()];
        } else {            
            $vec = $hoja_vida_taxi_instancia->insertar($params);
        }
        break;
    case 'eliminar':
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'ID no especificado para eliminar.'];
        } else {
            $vec = $hoja_vida_taxi_instancia->eliminar($id);
        }
        break;
    case 'editar':
        $json = file_get_contents('php://input');
        $params = json_decode($json, true);
        $id = $_GET['id'] ?? null;
        if (($params === null && json_last_error() !== JSON_ERROR_NONE) || $id === null) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'Datos JSON o ID inválidos para editar.'];
        } else {
            $vec = $hoja_vida_taxi_instancia->editar($id, $params);
        }
        break;
    case 'filtro':
        $dato = $_GET['dato'] ?? null;
        if ($dato === null) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'Dato de filtro no especificado.'];
        } else {
            $vec = $hoja_vida_taxi_instancia->filtro($dato);
        }
        break;
    default:
        $vec = ['error' => 'Controlador no reconocido: ' . $control];
        break;
}
$datosj = json_encode($vec);
ob_end_clean();
echo $datosj;