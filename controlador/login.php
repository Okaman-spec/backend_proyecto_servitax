<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering

header('Access-Control-Allow-Origin: *');
// Corrected: X-Requested-Wiht to X-Requested-With
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Ensure all necessary methods are allowed
header('Content-Type: application/json');

// Handle OPTIONS request for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { 
    ob_end_clean(); // Clean any buffered output
    http_response_code(200);
    exit(); 
}

require_once("../conexion.php");
require_once("../modelo/login.php");

// It's highly recommended to use POST for sensitive data like login credentials
// For now, we'll keep GET as per your current setup for debugging.
// In a production environment, you should change this to $_POST and send via a POST request from the frontend.
$email = $_GET['email'] ?? null;
$clave = $_GET['clave'] ?? null;

if ($email === null || $clave === null) {
    ob_end_clean();
    echo json_encode(['validar' => 'error', 'mensaje' => 'Email o clave no especificados.']);
    exit();
}

$login = new Login($conexion);

$vec = $login->consulta($email, $clave);

$datosj = json_encode($vec);

ob_end_clean(); // Clean any buffered output before echoing JSON
echo $datosj;
?>