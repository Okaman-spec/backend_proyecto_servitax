<?php
// backend/modelo/pedido.php
// Este archivo NO DEBE TENER ESPACIOS, SALTOS DE LÍNEA, O CUALQUIER CARÁCTER
// ANTES DE LA ETIQUETA <?php O DESPUÉS DEL CÓDIGO PHP.

class PedidoModel {
    public $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consulta() {
        $con = "SELECT 
                    p.id_pedido, 
                    p.fo_cliente, 
                    c.nombre AS cliente_nombre,    -- Nombre del cliente
                    p.fo_conductor,                -- Incluir fo_conductor
                    co.nombre AS conductor_nombre, -- Nombre del conductor
                    p.fo_servicio,                 -- Incluir fo_servicio
                    s.producto AS nombre_servicio,   -- Nombre del servicio de la tabla 'servicios'
                    s.descripcion AS descripcion_servicio, -- Descripción del servicio de la tabla 'servicios'
                    s.total AS precio_servicio,   -- Precio del servicio de la tabla 'servicios'
                    p.total, 
                    p.fecha
                FROM 
                    pedidos p
                JOIN 
                    clientes c ON p.fo_cliente = c.id_cliente
                LEFT JOIN -- Usamos LEFT JOIN en caso de que un pedido no tenga conductor asignado aún
                    conductores co ON p.fo_conductor = co.fo_conductores 
                LEFT JOIN -- JOIN con la tabla de servicios
                    servicios s ON p.fo_servicio = s.id_servicio
                ORDER BY 
                    p.id_pedido DESC";
        
        $res = mysqli_query($this->conexion, $con);

        if (!$res) {
            error_log("Error en la consulta (PedidoModel->consulta()): " . mysqli_error($this->conexion));
            return ['error' => 'Error en la consulta de pedidos: ' . mysqli_error($this->conexion)];
        }

        $vec = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $vec[] = $row;
        }
        return $vec;
    }

    public function insertar($params) {
        // Asegúrate de que la tabla 'pedidos' tenga las columnas 'fo_cliente', 'fo_conductor', 'fo_servicio', 'total', 'fecha'
        $stmt = mysqli_prepare($this->conexion, "INSERT INTO pedidos (fo_cliente, fo_conductor, fo_servicio, total, fecha) VALUES (?, ?, ?, ?, NOW())");
        
        $fo_cliente = $params['fo_cliente'] ?? null;
        $fo_conductor = $params['fo_conductor'] ?? null; 
        $fo_servicio = $params['fo_servicio'] ?? null; // Campo para servicio
        $total = $params['total'] ?? null;

        if ($fo_cliente === null || $fo_conductor === null || $fo_servicio === null || $total === null) {
            return ['resultado' => 'Error', 'mensaje' => 'Datos incompletos para insertar pedido (cliente, conductor, servicio o total).'];
        }

        // 'i' para entero, 'd' para decimal/double
        // Ajustado: 'iii' para 3 enteros (cliente, conductor, servicio), 'd' para total
        mysqli_stmt_bind_param($stmt, "iiid", $fo_cliente, $fo_conductor, $fo_servicio, $total); 
        $ejecucion = mysqli_stmt_execute($stmt);

        if (!$ejecucion) {
            error_log("Error al ejecutar INSERT de pedido: " . mysqli_stmt_error($stmt));
            return ['resultado' => 'Error', 'mensaje' => 'Error al insertar pedido: ' . mysqli_stmt_error($stmt)];
        }

        mysqli_stmt_close($stmt);
        return ['resultado' => 'OK', 'mensaje' => 'Pedido insertado exitosamente.'];
    }

    // Método para actualizar un pedido existente
    public function actualizar($id, $params) {
        $sql_update = "UPDATE pedidos SET fo_cliente = ?, fo_conductor = ?, fo_servicio = ?, total = ? WHERE id_pedido = ?";
        $stmt = mysqli_prepare($this->conexion, $sql_update);
        
        if (!$stmt) {
            error_log("Error al preparar UPDATE de pedido: " . mysqli_error($this->conexion) . " SQL: " . $sql_update);
            return ['resultado' => 'Error', 'mensaje' => 'Error al preparar la consulta de actualización: ' . mysqli_error($this->conexion)];
        }

        $fo_cliente = $params['fo_cliente'] ?? null;
        $fo_conductor = $params['fo_conductor'] ?? null; 
        $fo_servicio = $params['fo_servicio'] ?? null; // Campo para servicio
        $total = $params['total'] ?? null;

        if ($fo_cliente === null || $fo_conductor === null || $fo_servicio === null || $total === null || $id === null) {
            return ['resultado' => 'Error', 'mensaje' => 'Datos incompletos para actualizar pedido.'];
        }

        mysqli_stmt_bind_param($stmt, "iiidi", $fo_cliente, $fo_conductor, $fo_servicio, $total, $id); 
        $ejecucion = mysqli_stmt_execute($stmt);

        if (!$ejecucion) {
            error_log("Error al ejecutar UPDATE de pedido: " . mysqli_stmt_error($stmt) . " SQL: " . $sql_update . " Params: " . json_encode($params) . " ID: " . $id);
            return ['resultado' => 'Error', 'mensaje' => 'Error al actualizar pedido: ' . mysqli_stmt_error($stmt)];
        }

        mysqli_stmt_close($stmt);
        return ['resultado' => 'OK', 'mensaje' => 'Pedido actualizado exitosamente.'];
    }

    // Puedes añadir métodos para eliminar, filtro, etc. aquí
    public function eliminar($id) {
        $stmt = mysqli_prepare($this->conexion, "DELETE FROM pedidos WHERE id_pedido = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        $ejecucion = mysqli_stmt_execute($stmt);

        if (!$ejecucion) {
            error_log("Error al ejecutar DELETE de pedido: " . mysqli_stmt_error($stmt));
            return ['resultado' => 'Error', 'mensaje' => 'Error al eliminar pedido: ' . mysqli_stmt_error($stmt)];
        }
        mysqli_stmt_close($stmt);
        return ['resultado' => 'OK', 'mensaje' => 'Pedido eliminado exitosamente.'];
    }
}