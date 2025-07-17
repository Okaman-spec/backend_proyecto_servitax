<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-Wiht,Type,Accept");

    require_once("../conexion.php");
    require_once("../modelo/categoria.php");

    if (isset($_GET['control'])) {
    $control = $_GET['control'];
} else {   
    echo json_encode(['error' => 'Parámetro "control" no especificado en la URL.']);
    header('content-type: application/json');
    exit();
}
    $cate = new categoria($conexion);
    switch ($control) {
        case 'consulta':
           $vec = $cate->consulta();
        break;
        case 'insertar':
            $json = file_get_contents('php://input');
            //$json = '{"nombre":"Prueba 15"}';
            $params = json_decode($json);
            $vec = $cate->insertar($params);
        break;
        case 'eliminar':
            $id = $_GET['id'];
            $vec = $cate->eliminar($id);
        break;
        case 'editar':  
            $json = file_get_contents('php://input');
            $params = json_decode($json);
            $id = $_GET['id'];
            $vec = $cate->editar($id,$params);
        break;
        case 'filtro':
            $dato = $_GET['dato'];
            $vec = $cate->filtro($dato);
        break;
    }
    $datosj = json_encode($vec);
    echo $datosj;
    header('content-type: application/json');