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
// ¡CORREGIDO! Asegúrate de que esta ruta apunte al nombre de archivo correcto de tu modelo
require_once ("../modelo/conductores.php"); 

$vec = ['error' => 'Operación no válida'];

$control = $_GET['control'] ?? null;

if ($control === null) {
    ob_end_clean();
    echo json_encode(['error' => 'Parámetro "control" no especificado en la URL.']);
    exit();
}

// La clase dentro del archivo 'conductores.php' sigue siendo 'ConductorModel'
if (!class_exists('ConductorModel')) {
    ob_end_clean();
    error_log("Error fatal: La clase ConductorModel no está definida en conductores.php (modelo).");
    echo json_encode(['error' => 'Error interno del servidor: Modelo de conductor no encontrado.']);
    exit();
}
$conductor_model_instancia = new ConductorModel($conexion);

switch ($control) {
    case 'consultar':
        $vec = $conductor_model_instancia->consulta();
        break;
    default:
        $vec = ['error' => 'Controlador no reconocido: ' . $control];
        break;
}

$datosj = json_encode($vec);

ob_end_clean();
echo $datosj;

?>