<?php

include_once '/conexion_bd.php';

function obtener_id_usuario($nombre_usuario) {


    $consulta = 'SELECT * FROM usuario WHERE nombre_usuario="' . $nombre_usuario . '"';

    $resultado = conexionBD($consulta);

    $id = -1;
    if ($resultado){
        $fila = mysql_fetch_array($resultado);
        $id = $fila['id_usuario'];
    }
    return $id;
}

?>