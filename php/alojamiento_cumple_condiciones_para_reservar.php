<?php

include_once './conexion_bd.php';
include_once './obtener_habitaciones_disponibles_por_tipo.php';

function alojamiento_cumple_condiciones_para_reservar($id_alojamiento, $tipo_alquiler, $capacidad, $fecha_inicio, $fecha_fin) {

    if ($tipo_alquiler == 'piso' || $tipo_alquiler == 'casa_rural') {
        $libre = alojamiento_completo_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin);
    } else {
        $libre = alojamiento_habitaciones_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin);
    }
    return $libre;
}

function alojamiento_completo_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin) {
    $libre = false;
    alert($id_alojamiento);
    $consulta_esta_reservada = "SELECT * FROM cliente_reserva, alquiler_completo WHERE "
            . "alquiler_completo.id_alojamiento_completo=cliente_reserva.id_alojamiento" . " AND "
            . "cliente_reserva.id_alojamiento=" . $id_alojamiento . " AND ( "
            . "(cliente_reserva.fecha_inicio>='" . $fecha_inicio . "' AND "
            . "cliente_reserva.fecha_inicio<'" . $fecha_fin . "') OR "
            . "(cliente_reserva.fecha_fin>'" . $fecha_inicio . "' AND "
            . "cliente_reserva.fecha_fin<='" . $fecha_fin . "') )";

    $resultado_esta_reservada = conexionBD($consulta_esta_reservada);

    if ($resultado_esta_reservada) {
        $n_tuplas = mysql_num_rows($resultado_esta_reservada);
        if ($n_tuplas == 0) {
            $libre = true;
        }
    }

    return $libre;
}

function alojamiento_habitaciones_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin) {
    $consulta = 'SELECT DISTINCT habitacion.id_tipo_habitacion FROM habitacion, tipo_habitacion WHERE '
            . 'habitacion.id_tipo_habitacion=tipo_habitacion.id_tipo_habitacion AND '
            . 'id_alojamiento=' . $id_alojamiento . ' AND '
            . 'capacidad=' . $capacidad;

    $resultado = conexionBD($consulta);

    if ($resultado) {
        while ($fila = mysql_fetch_array($resultado)) {
            $n_hab_libres = obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $fila['id_tipo_habitacion'], $fecha_inicio, $fecha_fin);
            if($n_hab_libres > 0){
                return true;
            }
        }
    }
    return false;
}

function alert($str) {
    echo "<script>"
    . "alert('" . $str . "');"
    . "</script>";
}

?>