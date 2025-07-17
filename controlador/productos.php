<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');
require_once ("../conexion.php");
require_once ("../modelo/producto.php");
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
if (!class_exists('ProductoModel')) {
    ob_end_clean();
    error_log("Error fatal: La clase ProductoModel no está definida en producto.php (modelo).");
    echo json_encode(['error' => 'Error interno del servidor: Modelo de producto no encontrado.']);
    exit();
}
$producto_model_instancia = new ProductoModel($conexion);
switch ($control) {
    case 'consultar':
        $vec = $producto_model_instancia->consulta();
        break;    
    default:
        $vec = ['error' => 'Controlador no reconocido: ' . $control];
        break;
}
$datosj = json_encode($vec);
ob_end_clean();
echo $datosj;