<?php
// backend/modelo/producto.php
// Este archivo NO DEBE TENER ESPACIOS, SALTOS DE LÍNEA, O CUALQUIER CARÁCTER
// ANTES DE LA ETIQUETA <?php O DESPUÉS DEL CÓDIGO PHP.
// Es la causa #1 de JSON malformado.

class ProductoModel { // Asegúrate de que la clase se llame 'ProductoModel'
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consulta() {
        // Asegúrate de que los nombres de las columnas en tu tabla 'servicios'
        // (a la izquierda del 'AS') existan EXACTAMENTE en tu base de datos.
        $con = "SELECT 
                    id_servicio AS id, 
                    producto AS name, 
                    descripcion AS description, 
                    total AS price,  -- Usamos 'total' como 'price' si no hay una columna 'precio'
                    'https://placehold.co/100x100/000000/FFFFFF?text=Producto' AS imageUrl, 
                    100 AS stock 
                FROM 
                    servicios 
                ORDER BY 
                    id_servicio DESC";
        
        $res = mysqli_query($this->conexion, $con);

        if (!$res) {
            error_log("Error en la consulta (ProductoModel->consulta()): " . mysqli_error($this->conexion));
            return ['error' => 'Error en la consulta de productos: ' . mysqli_error($this->conexion)];
        }

        $vec = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $vec[] = $row;
        }
        return $vec;
    }
}