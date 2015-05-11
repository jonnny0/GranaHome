<?php

include_once 'conexion_bd.php';

function obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin) {

    $consulta_n_habitaciones = 'SELECT * FROM habitacion WHERE id_tipo_habitacion=' . $id_tipo . ' AND '
            . 'id_alojamiento=' . $id_alojamiento;
    $resultado_n_habitaciones = conexionBD($consulta_n_habitaciones);

    if (!$resultado_n_habitaciones) {
        error();
    }
    
    $n_habitaciones_total = mysql_num_rows($resultado_n_habitaciones);

    $consulta_hay_reservadas = 'SELECT * FROM cliente_reserva, reserva_habitacion, habitacion WHERE '
            . 'habitacion.id_tipo_habitacion=' . $id_alojamiento . ' AND '
            . 'habitacion.id_alojamiento=' . $id_tipo . ' AND '
            . 'habitacion.id_habitacion=reserva_habitacion.id_habitacion AND '
            . 'reserva_habitacion.id_reserva=cliente_reserva.id_reserva AND '
            . 'cliente_reserva.fecha_inicio>=' . $fecha_inicio . ' AND '
            . 'cliente_reserva.fecha_inicio<=' . $fecha_fin . ' AND '
            . 'cliente_reserva.fecha_fin>=' . $fecha_inicio . ' AND '
            . 'cliente_reserva.fecha_fin<=' . $fecha_fin;

    $resultado_hay_reservadas = conexionBD($consulta_hay_reservadas);
    
    if (!$resultado_hay_reservadas) {
        error();
    }
    
    $n_habitaciones_reservadas = mysql_num_rows($resultado_hay_reservadas);
    
    echo '<script>
        alert( "hay: ' . $resultado_n_habitaciones . ' reservadas: ' . $resultado_hay_reservadas . ' quedan disponibles: '
            . ($n_habitaciones_total-$n_habitaciones_reservadas) . '");
    </script>';
    return $n_habitaciones_total-$n_habitaciones_reservadas;
}

function error() {
    return -1;
}

?>