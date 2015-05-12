<?php

include_once 'php/conexion_bd.php';

function obtener_fotos_alojamiento($id){
    $consulta = "SELECT url FROM foto_alojamiento WHERE id_alojamiento=" . $id;
    
    $resultado = conexionBD($consulta);
    
    return $resultado;
}

function obtener_foto_alojamiento($id){
    $resultado = obtener_fotos_alojamiento($id);
    $foto = "";
    if($resultado){
        $fila = mysql_fetch_array($resultado);
        $foto = $fila['url'];
    }
    return $foto;
}

?>