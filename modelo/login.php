<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Login {
    // Attribute
    public $conexion;     

    // Constructor method
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Methods
    public function consulta($email, $clave) {
        // Use prepared statements to prevent SQL injection
        // Corrected: Compare 'clave' with the variable $clave
        $sql = "SELECT * FROM usuario WHERE email = ? AND clave = ?";
        
        // Prepare the statement
        if ($stmt = mysqli_prepare($this->conexion, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ss", $email, $clave); // "ss" indicates two string parameters
            
            // Execute the statement
            mysqli_stmt_execute($stmt);
            
            // Get the result set
            $res = mysqli_stmt_get_result($stmt);
            
            $vec = [];

            // Fetch rows
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) { // Use MYSQLI_ASSOC for associative array
                $vec[] = $row; 
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            if (empty($vec)) { // Check if the array is empty
                $vec[0] = ["validar" => "no valida"]; // Use associative array for consistency
            } else {
                $vec[0]['validar'] = "valida";
            }

            return $vec;
        } else {
            // Handle query preparation error
            error_log("Error preparing statement: " . mysqli_error($this->conexion));
            return [["validar" => "error", "mensaje" => "Error interno del servidor."]];
        }
    }
} 
?>      