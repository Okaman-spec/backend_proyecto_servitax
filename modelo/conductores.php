<?php
// backend/modelo/conductores.php
// Este archivo NO DEBE TENER ESPACIOS, SALTOS DE LÍNEA, O CUALQUIER CARÁCTER
// ANTES DE LA ETIQUETA <?php O DESPUÉS DEL CÓDIGO PHP.

class ConductorModel { // La clase se sigue llamando ConductorModel
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consulta() {
        // Asegúrate de que los nombres de las columnas coincidan exactamente con tu tabla 'conductores'
        $con = "SELECT fo_conductores, nombre, Cédula, direccion, celular, licencia, vehi_asig, `E-mail`, fo_usuario FROM conductores ORDER BY nombre ASC";
        
        $res = mysqli_query($this->conexion, $con);

        if (!$res) {
            error_log("Error en la consulta (ConductorModel->consulta()): " . mysqli_error($this->conexion));
            return ['error' => 'Error en la consulta de conductores: ' . mysqli_error($this->conexion)];
        }

        $vec = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}