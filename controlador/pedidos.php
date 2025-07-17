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

// Incluir archivos necesarios
require_once ("../conexion.php"); 
require_once ("../modelo/pedido.php"); 

// Inicializar la variable de respuesta con un error por defecto
$vec = ['error' => 'Operación no válida'];

// Verificar si la solicitud es de tipo OPTIONS (preflight request de CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    http_response_code(200);
    exit();
}

// Obtener el valor del parámetro 'control' de la URL o del cuerpo de la solicitud (para POST/PUT)
$control = $_GET['control'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    $control = $input['control'] ?? $control; 
}

if ($control === null) {
    ob_end_clean();
    echo json_encode(['error' => 'Parámetro "control" no especificado.']);
    exit();
}

// Crear una instancia del modelo PedidoModel
if (!class_exists('PedidoModel')) {
    ob_end_clean();
    error_log("Error fatal: La clase PedidoModel no está definida en pedido.php (modelo).");
    echo json_encode(['error' => 'Error interno del servidor: Modelo de pedido no encontrado.']);
    exit();
}
$pedido_model_instancia = new PedidoModel($conexion);

// Manejar las diferentes acciones según el valor de 'control'
switch ($control) {
    case 'consultar':
        $vec = $pedido_model_instancia->consulta();
        break;
    case 'insertar':
        $params = $input ?? json_decode(file_get_contents('php://input'), true);
        if ($params === null && json_last_error() !== JSON_ERROR_NONE) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'Datos JSON inválidos: ' . json_last_error_msg()];
        } else {
            $vec = $pedido_model_instancia->insertar($params);
        }
        break;
    case 'editar':
        $id = $_GET['id'] ?? null;
        $params = $input ?? json_decode(file_get_contents('php://input'), true);
        
        if ($id === null || ($params === null && json_last_error() !== JSON_ERROR_NONE)) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'Datos JSON o ID inválidos para editar.'];
        } else {
            $vec = $pedido_model_instancia->actualizar($id, $params);
        }
        break;
    case 'eliminar': // Caso para la eliminación
        $id = $_GET['id'] ?? null;
        if ($id === null) {
            $vec = ['resultado' => 'Error', 'mensaje' => 'ID no especificado para eliminar.'];
        } else {
            $vec = $pedido_model_instancia->eliminar($id); // Llama al método 'eliminar' del modelo
        }
        break;
    default:
        $vec = ['error' => 'Controlador no reconocido: ' . $control];
        break;
}

// Codificar la respuesta final a JSON
$datosj = json_encode($vec);

ob_end_clean();
echo $datosj;

?>