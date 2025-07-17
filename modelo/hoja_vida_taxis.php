<?php
    class hoja_vida_taxis{
        public $conexion;

        public function __construct($conexion){
            $this->conexion = $conexion;
        }

        public function consulta(){
            $con = "SELECT * FROM hoja_vida_taxis ORDER BY `id_hoja_vida_taxis` DESC"; // Ordenar por ID para ver los más recientes, o por `Marca` o `Modelo` si prefieres
            $res = mysqli_query($this->conexion, $con);

            if (!$res) {
                // Registro de errores para depuración en el log del servidor
                error_log("Error en la consulta (consulta()): " . mysqli_error($this->conexion));
                return ['error' => 'Error en la consulta: ' . mysqli_error($this->conexion)];
            }

            $vec = [];
            while($row = mysqli_fetch_assoc($res)){ // Usar mysqli_fetch_assoc para obtener solo nombres de columna, no índices numéricos duplicados
                $vec[] = $row;
            }
            return $vec;
        }

        public function eliminar($id){
            // Uso de sentencia preparada para seguridad
            $del = "DELETE FROM hoja_vida_taxis WHERE id_hoja_vida_taxis = ?";
            $stmt = mysqli_prepare($this->conexion, $del);

            if (!$stmt) {
                error_log("Error al preparar DELETE: " . mysqli_error($this->conexion));
                return ['resultado' => 'Error', 'mensaje' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
            }

            mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que $id es un entero (integer)
            $ejecucion = mysqli_stmt_execute($stmt);

            if (!$ejecucion) {
                error_log("Error al ejecutar DELETE: " . mysqli_stmt_error($stmt));
                return ['resultado' => 'Error', 'mensaje' => 'Error al ejecutar la eliminación: ' . mysqli_stmt_error($stmt)];
            }

            mysqli_stmt_close($stmt);

            return ['resultado' => "OK", 'mensaje' => "El Registro fue Eliminado"];
        }

        public function insertar($params){
            // Nombres de columnas de la base de datos (asegúrate que coincidan exactamente con tu tabla)
            // AJUSTADO: `Vencimiento_Seguro _Obligatorio` para coincidir con el nombre exacto de la base de datos (incluyendo el espacio)
            $columns = "`marca`, `categoria`, `modelo`, `fo_placa`, `No_Orden`, `Fecha_Ingreso`, `Fecha_Tecno_mecanica`, `Vencimiento_Seguro _Obligatorio`, `fo_Conductor`, `fo_Revisiones`";
            $placeholders = "?, ?, ?, ?, ?, ?, ?, ?, ?, ?"; // 10 placeholders para 10 columnas

            $ins = "INSERT INTO hoja_vida_taxis($columns) VALUES($placeholders)";
            $stmt = mysqli_prepare($this->conexion, $ins);

            if (!$stmt) {
                error_log("Error al preparar INSERT: " . mysqli_error($this->conexion));
                return ['resultado' => 'Error', 'mensaje' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
            }

            // Define los tipos de datos para bind_param
            // 's' = string, 'i' = integer
            $types = "ssssssssii"; // 10 tipos: 7 strings, 3 integers (fo_Conductor, fo_Revisiones)

            // Asigna los parámetros a variables para mejor depuración y claridad
            $marca = $params['marca'] ?? '';
            $categoria = $params['categoria'] ?? '';
            $modelo = $params['modelo'] ?? ''; // No se usa intval(), se pasa como string
            $fo_placa = $params['fo_placa'] ?? '';
            $no_orden = $params['No_Orden'] ?? '';
            $fecha_ingreso = $params['Fecha_Ingreso'] ?? '';
            $fecha_tecno_mecanica = $params['Fecha_Tecno_mecanica'] ?? '';
            // Se asume que el payload de Angular todavía envía 'Vencimiento_Seguro_Obligatorio' (sin espacio)
            // PERO LA COLUMNA DE LA DB ES CON ESPACIO. HAY UN POSIBLE MISMATCH AQUI ENTRE EL JSON Y LA DB COL.
            // Para la BD: $vencimiento_seguro_obligatorio = $params['Vencimiento_Seguro_Obligatorio'] ?? ''; // ESTE YA LO PASA SIN ESPACIO DEL JSON
            // Asumiendo que el JSON de Angular NO tiene el espacio, pero la DB SÍ lo tiene.
            // La variable PHP sigue siendo el nombre de la variable de Angular, no el nombre de la columna.
            $vencimiento_seguro_obligatorio = $params['Vencimiento_Seguro_Obligatorio'] ?? ''; 
            $fo_conductor = intval($params['fo_Conductor'] ?? 0); // intval() se mantiene para INT
            $fo_revisiones = intval($params['fo_Revisiones'] ?? 0); // intval() se mantiene para INT

            // **IMPORTANTE:** Acceder a $params como ARRAY asociativo (porque json_decode($json, true) se usó)
            // Se usa el operador de fusión de null (??) para asegurar que la clave existe y proporcionar un valor por defecto.
            mysqli_stmt_bind_param($stmt, $types,
                $marca,
                $categoria,
                $modelo, // Pasando como string
                $fo_placa,
                $no_orden,
                $fecha_ingreso,
                $fecha_tecno_mecanica,
                $vencimiento_seguro_obligatorio, // Valor de la variable PHP, que viene del JSON sin espacio en el nombre
                $fo_conductor,
                $fo_revisiones
            );

            $ejecucion = mysqli_stmt_execute($stmt);

            if (!$ejecucion) {
                error_log("Error al ejecutar INSERT: " . mysqli_stmt_error($stmt) . " (SQL: $ins)");
                return ['resultado' => 'Error', 'mensaje' => 'Error al ejecutar la inserción: ' . mysqli_stmt_error($stmt) . ' - JSON Last Error: ' . json_last_error_msg()];
            }

            mysqli_stmt_close($stmt);

            return ['resultado' => "OK", 'mensaje' => "El Registro ha sido guardado"];
        }

        public function editar($id, $params){
            // Sentencia preparada para seguridad
            // AJUSTADO: `Vencimiento_Seguro _Obligatorio` para coincidir con el nombre exacto de la base de datos (incluyendo el espacio)
            $editar = "UPDATE hoja_vida_taxis SET `marca` = ?, `categoria` = ?, `modelo` = ?, `fo_placa` = ?, `No_Orden` = ?, `Fecha_Ingreso` = ?, `Fecha_Tecno_mecanica` = ?, `Vencimiento_Seguro _Obligatorio` = ?, `fo_Conductor` = ?, `fo_Revisiones` = ? WHERE id_hoja_vida_taxis = ?";
            $stmt = mysqli_prepare($this->conexion, $editar);

            if (!$stmt) {
                error_log("Error al preparar UPDATE: " . mysqli_error($this->conexion));
                return ['resultado' => 'Error', 'mensaje' => 'Error al preparar la consulta: ' . mysqli_error($this->conexion)];
            }

            // Define los tipos de datos para bind_param (similar al insertar, más un 'i' final para el ID)
            $types = "ssssssssiii"; // 10 tipos de datos para los campos + 1 para el ID

            // Asigna los parámetros a variables para mejor depuración y claridad
            $marca = $params['marca'] ?? '';
            $categoria = $params['categoria'] ?? '';
            $modelo = $params['modelo'] ?? ''; // No se usa intval(), se pasa como string
            $fo_placa = $params['fo_placa'] ?? '';
            $no_orden = $params['No_Orden'] ?? '';
            $fecha_ingreso = $params['Fecha_Ingreso'] ?? '';
            $fecha_tecno_mecanica = $params['Fecha_Tecno_mecanica'] ?? '';
            // Se asume que el payload de Angular todavía envía 'Vencimiento_Seguro_Obligatorio' (sin espacio)
            $vencimiento_seguro_obligatorio = $params['Vencimiento_Seguro_Obligatorio'] ?? ''; 
            $fo_conductor = intval($params['fo_Conductor'] ?? 0);
            $fo_revisiones = intval($params['fo_Revisiones'] ?? 0);


            mysqli_stmt_bind_param($stmt, $types,
                $marca,
                $categoria,
                $modelo, // Pasando como string
                $fo_placa,
                $no_orden,
                $fecha_ingreso,
                $fecha_tecno_mecanica,
                $vencimiento_seguro_obligatorio, // Valor de la variable PHP, que viene del JSON sin espacio en el nombre
                $fo_conductor,
                $fo_revisiones,
                $id
            );

            $ejecucion = mysqli_stmt_execute($stmt);

            if (!$ejecucion) {
                error_log("Error al ejecutar UPDATE: " . mysqli_stmt_error($stmt));
                return ['resultado' => 'Error', 'mensaje' => 'Error al ejecutar la edición: ' . mysqli_stmt_error($stmt) . ' - JSON Last Error: ' . json_last_error_msg()];
            }

            mysqli_stmt_close($stmt);

            return ['resultado' => "OK", 'mensaje' => "El Registro ha sido editado"];
        }

        public function filtro($valor){
            $filtro = "SELECT * FROM hoja_vida_taxis WHERE `marca` LIKE ? OR `categoria` LIKE ? OR `modelo` LIKE ? OR `fo_placa` LIKE ?"; // Puedes añadir más columnas para buscar
            $stmt = mysqli_prepare($this->conexion, $filtro);

            if (!$stmt) {
                error_log("Error al preparar filtro: " . mysqli_error($this->conexion));
                return ['error' => 'Error al preparar la consulta de filtro: ' . mysqli_error($this->conexion)];
            }

            $valor_like = "%" . $valor . "%"; // Prepara el valor con comodines
            // bind_param para cada columna en el WHERE
            mysqli_stmt_bind_param($stmt, "ssss", $valor_like, $valor_like, $valor_like, $valor_like);

            $ejecucion = mysqli_stmt_execute($stmt);

            if (!$ejecucion) {
                error_log("Error al ejecutar filtro: " . mysqli_stmt_error($stmt));
                return ['error' => 'Error al ejecutar el filtro: ' . mysqli_stmt_error($stmt)];
            }

            $res = mysqli_stmt_get_result($stmt); // Obtener el conjunto de resultados

            $vec = [];
            while($row = mysqli_fetch_assoc($res)){ // Usar mysqli_fetch_assoc para consistencia
                $vec[] = $row;
            }
            mysqli_stmt_close($stmt);
            return $vec;
        }
    }

   