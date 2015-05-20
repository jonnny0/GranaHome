<?php

include_once 'conexion_bd.php';

function obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin) {

    $n_habitaciones_total = obtener_numero_total_habitaciones($id_alojamiento, $id_tipo);

    $n_habitaciones_reservadas = obtener_numero_habitaciones_reservadas($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin);
    
    return ($n_habitaciones_total - $n_habitaciones_reservadas);
}

function obtener_numero_total_habitaciones($id_alojamiento, $id_tipo){
    $resultado_n_habitaciones = obtener_total_habitaciones($id_alojamiento, $id_tipo);

    if (!$resultado_n_habitaciones) {
        error();
    }

    return mysql_num_rows($resultado_n_habitaciones);
}

function obtener_total_habitaciones($id_alojamiento, $id_tipo){
    $consulta_n_habitaciones = 'SELECT id_habitacion FROM habitacion WHERE id_tipo_habitacion=' . $id_tipo . ' AND '
            . 'id_alojamiento=' . $id_alojamiento;
    $resultado_n_habitaciones = conexionBD($consulta_n_habitaciones);

    return $resultado_n_habitaciones;
}

function obtener_numero_habitaciones_reservadas($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin){
    $resultado_hay_reservadas = obtener_habitaciones_reservadas($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin);
    
    if (!$resultado_hay_reservadas) {
        error();
    }

    return mysql_num_rows($resultado_hay_reservadas);
}

function obtener_habitaciones_reservadas($id_alojamiento, $id_tipo, $fecha_inicio, $fecha_fin){
    $consulta_hay_reservadas = "SELECT habitacion.id_habitacion FROM cliente_reserva, reserva_habitacion, habitacion WHERE "
            . "habitacion.id_alojamiento=" . $id_alojamiento . " AND "
            . "habitacion.id_tipo_habitacion=" . $id_tipo . " AND "
            . "habitacion.id_habitacion=reserva_habitacion.id_habitacion AND "
            . "cliente_reserva.id_reserva=reserva_habitacion.id_reserva AND ( "
            . "('" . $fecha_inicio . "'>=fecha_inicio AND '" . $fecha_inicio . "'<fecha_fin) OR "
            . "('" . $fecha_fin . "'>fecha_inicio AND '" . $fecha_fin . "'<=fecha_fin) ) ";

    $resultado_hay_reservadas = conexionBD($consulta_hay_reservadas);

    return $resultado_hay_reservadas;
}

function obtener_id_habitaciones_libres_reserva($id_alojamiento, $id_tipo_habitacion, $fecha_inicio, $fecha_fin){
    $consulta_existen = "SELECT id_habitacion FROM habitacion WHERE id_tipo_habitacion=" . $id_tipo_habitacion . " AND "
            . "id_alojamiento=" . $id_alojamiento . " ";
    
    $consulta_reservadas = "SELECT habitacion.id_habitacion FROM cliente_reserva, reserva_habitacion, habitacion WHERE "
            . "habitacion.id_alojamiento=" . $id_alojamiento . " AND "
            . "habitacion.id_tipo_habitacion=" . $id_tipo_habitacion . " AND "
            . "habitacion.id_habitacion=reserva_habitacion.id_habitacion AND "
            . "cliente_reserva.id_reserva=reserva_habitacion.id_reserva AND ( "
            . "(cliente_reserva.fecha_inicio>='" . $fecha_inicio . "' AND "
            . "cliente_reserva.fecha_inicio<'" . $fecha_fin . "') OR "
            . "(cliente_reserva.fecha_fin>'" . $fecha_inicio . "' AND "
            . "cliente_reserva.fecha_fin<='" . $fecha_fin . "') )";
    
    $consulta = $consulta_existen . " AND id_habitacion NOT IN (" . $consulta_reservadas . ")";
    $resultado = conexionBD($consulta);
    
    return $resultado;
}

function error() {
    return -1;
}

?>