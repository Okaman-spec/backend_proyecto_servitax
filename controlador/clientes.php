<?php
// Habilitar la visualización de errores de PHP (solo para desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// INICIO DEL BUFFER DE SALIDA: Captura cualquier salida inesperada.
ob_start();

// Encabezados CORS para permitir peticiones desde cualquier origen
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Content-Type: application/json');

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    http_response_code(200);
    exit();
}

// Incluir archivos necesarios
require_once ("../conexion.php");
require_once ("../modelo/cliente.php"); 

$vec = ['error' => 'Operación no válida'];

$control = $_GET['control'] ?? null;

if ($control === null) {
    ob_end_clean();
    echo json_encode(['error' => 'Parámetro "control" no especificado en la URL.']);
    exit();
}

if (!class_exists('ClienteModel')) {
    ob_end_clean();
    error_log("Error fatal: La clase ClienteModel no está definida en cliente.php (modelo).");
    echo json_encode(['error' => 'Error interno del servidor: Modelo de cliente no encontrado.']);
    exit();
}
$cliente_model_instancia = new ClienteModel($conexion);

switch ($control) {
    case 'consultar':
        $vec = $cliente_model_instancia->consulta();
        break;
    default:
        $vec = ['error' => 'Controlador no reconocido: ' . $control];
        break;
}

$datosj = json_encode($vec);

ob_end_clean();
echo $datosj;

?>