<?php

include_once 'conexion_bd.php';

function obtener_fotos_alojamiento($id) {
    $consulta = "SELECT url FROM foto_alojamiento WHERE id_alojamiento=" . $id;

    $resultado = conexionBD($consulta);

    return $resultado;
}

function obtener_foto_alojamiento($id) {
    $resultado = obtener_fotos_alojamiento($id);
    $foto = "";
    if ($resultado) {
        $fila = mysql_fetch_array($resultado);
        $foto = $fila['url'];
    }
    return $foto;
}

function obtener_array_fotos_alojamiento($id) {
    $resultado = obtener_fotos_alojamiento($id);
    $fotos = [];
    if ($resultado) {
        $n_fotos = mysql_num_rows($resultado);
        for ($i = 0; $i < $n_fotos; $i++) {
            $fila = mysql_fetch_array($resultado);
            array_push($fotos, $fila['url']);
        }
        for ($i = $n_fotos; $i < 5; $i++) {
            array_push($fotos, false);
        }
    }
    return $fotos;
}

function obtener_foto_habitacion($id) {
    $resultado = obtener_fotos_habitacion($id);
    $foto = "";
    if ($resultado) {
        $fila = mysql_fetch_array($resultado);
        $foto = $fila['url'];
    }
    return $foto;
}

function obtener_fotos_habitacion($id) {
    $consulta = "SELECT url FROM foto_tipo_habitacion WHERE id_tipo_habitacion=" . $id;

    $resultado = conexionBD($consulta);

    return $resultado;
}

function obtener_array_fotos_habitacion($id) {
    $resultado = obtener_fotos_habitacion($id);
    $fotos = [];
    if ($resultado) {
        $n_fotos = mysql_num_rows($resultado);
        for ($i = 0; $i < $n_fotos; $i++) {
            $fila = mysql_fetch_array($resultado);
            array_push($fotos, $fila['url']);
        }
        for ($i = $n_fotos; $i < 5; $i++) {
            array_push($fotos, false);
        }
    }
    return $fotos;
}

function obtener_imagen_estrellas($id_alojamiento){
    $consulta_estrellas = "SELECT numero_estrellas FROM alquiler_habitaciones WHERE id_alojamiento_habitaciones=" . $id_alojamiento;
    $resultado_estrellas = conexionBD($consulta_estrellas);
    
    if($resultado_estrellas){
        $fila = mysql_fetch_array($resultado_estrellas);
        $estrellas = $fila['numero_estrellas'];
        return '"imagenes/ico_estrella_' . $estrellas . '.png" alt="' . $estrellas . ' Estrellas" ';
    }else{
        return "";
    }
}

function obtener_descripcion_foto_alojamiento($url){
    $consulta_foto = "SELECT * FROM foto_alojamiento WHERE url='" . $url . "'";
    $resultado_foto = conexionBD($consulta_foto);
    $descripcion = "";
    if($resultado_foto){
        $fila_foto = mysql_fetch_array($resultado_foto);
        $descripcion = $fila_foto['descripcion'];
    }
    return $descripcion;
}

function obtener_descripcion_foto_habitacion($url){
    $consulta_foto = "SELECT * FROM foto_tipo_habitacion WHERE url='" . $url . "'";
    $resultado_foto = conexionBD($consulta_foto);
    $descripcion = "";
    if($resultado_foto){
        $fila_foto = mysql_fetch_array($resultado_foto);
        $descripcion = $fila_foto['descripcion'];
    }
    return $descripcion;
}

?>