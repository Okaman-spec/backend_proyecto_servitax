<?php
    class categoria{     
        public $conexion;      
        public function __construct($conexion){
            $this->conexion = $conexion;
        }       
        public function consulta(){
            $con = "SELECT * FROM categoria ORDER BY nombre";
            $res = mysqli_query($this->conexion,$con);
            $vec = [];

            while($row = mysqli_fetch_array($res)){
            $vec[] = $row;  
        }
        return $vec;
        }      
        public function eliminar($id){
            $del = "DELETE FROM categoria WHERE id_categoria = $id";
            mysqli_query($this->conexion, $del);
            $vec = [];
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "la categoria ha sido eliminada";
            return $vec;
        }
        public function insertar($params){
            $ins = "INSERT INTO categoria(nombre) VALUES('$params->nombre')";
            mysqli_query($this->conexion, $ins);
            $vec = [];
            $vec['resultado'] = "OK";
            $vec['mensaje'] = "la categoria ha sido guardada";
            return $vec;
        }
        public function editar($id, $params){
            $editar = "UPDATE categoria set nombre = '$params-> nombre' WHERE id_categoria = $id";
            mysqli_query($this->conexion, $editar);
            $vec = [];
            $vec['resultado'] = "OK" ;
            $vec['mensaje'] = "la categoria ha sido editada";
            return $vec;
        }
        public function filtro($valor){
            $filtro = "SELECT * FROM categoria WHERE nombre LIKE '%$valor%'";
            $res = mysqli_query($this->conexion, $filtro);
            $vec = [];

            while($row = mysqli_fetch_array($res)){
                $vec[] = $row;
            }                
            return $vec;
        }
    }     