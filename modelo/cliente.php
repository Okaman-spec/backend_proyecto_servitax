<?php
// backend/modelo/cliente.php
// Este archivo NO DEBE TENER ESPACIOS, SALTOS DE LÍNEA, O CUALQUIER CARÁCTER
// ANTES DE LA ETIQUETA <?php O DESPUÉS DEL CÓDIGO PHP.

class ClienteModel {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consulta() {
        // CORREGIDO: Eliminada la columna 'apellido' de la consulta SELECT
        $con = "SELECT id_cliente, nombre, telefono, email FROM clientes ORDER BY nombre ASC";
        
        $res = mysqli_query($this->conexion, $con);

        if (!$res) {
            error_log("Error en la consulta (ClienteModel->consulta()): " . mysqli_error($this->conexion));
            return ['error' => 'Error en la consulta de clientes: ' . mysqli_error($this->conexion)];
        }

        $vec = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}
