<?php

include_once 'php/conexion_bd.php';

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

?>