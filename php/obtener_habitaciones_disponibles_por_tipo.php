<?php

include_once 'conexion_bd.php';

function obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin) {

    $consulta = 'SELECT * FROM habitacion WHERE id_tipo_habitacion="' . $id_tipo . '" ';

    $resultado = conexionBD($consulta);

    
    $consulta = 'SELECT * FROM cliente_reserva '
    
    
    
    $id = -1;
    if ($resultado){
        $fila = mysql_fetch_array($resultado);
        $id = $fila['id_usuario'];
    }
    return $id;
}

?>