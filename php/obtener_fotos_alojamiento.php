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

?>