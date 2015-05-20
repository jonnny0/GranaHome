<?php

include_once 'conexion_bd.php';
include_once 'obtener_habitaciones_disponibles_por_tipo.php';

function alojamiento_cumple_condiciones_para_reservar($id_alojamiento, $tipo_alquiler, $n_habitaciones, $capacidad, $fecha_inicio, $fecha_fin, $n_estrellas) {

    if ($tipo_alquiler == 'piso' || $tipo_alquiler == 'casa_rural') {
        $libre = alojamiento_completo_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin);
    } else {
        $libre = alojamiento_habitaciones_cumple_condiciones_para_reservar($id_alojamiento, $n_habitaciones, $capacidad, $fecha_inicio, $fecha_fin, $n_estrellas);
    }
    return $libre;
}

function alojamiento_completo_cumple_condiciones_para_reservar($id_alojamiento, $capacidad, $fecha_inicio, $fecha_fin) {
    $libre = false;
    
    $consulta_capacidad = "SELECT * FROM alquiler_completo WHERE id_alojamiento_completo=" . $id_alojamiento . " AND capacidad>=" . $capacidad;
    
    $resultado_capacidad = conexionBD($consulta_capacidad);
    if($resultado_capacidad){
        $n_tuplas = mysql_num_rows($resultado_capacidad);
        if($n_tuplas != 0){
            $consulta_esta_reservada = "SELECT * FROM cliente_reserva, alquiler_completo WHERE id_alojamiento_completo=id_alojamiento" . ' AND ' . "id_alojamiento=" . $id_alojamiento . " AND " . 'capacidad>=' . $capacidad . " AND ( " . "(cliente_reserva.fecha_inicio>='" . $fecha_inicio . "' AND " . "cliente_reserva.fecha_inicio<'" . $fecha_fin . "') OR " . "(cliente_reserva.fecha_fin>'" . $fecha_inicio . "' AND " . "cliente_reserva.fecha_fin<='" . $fecha_fin . "') )";

            $resultado_esta_reservada = conexionBD($consulta_esta_reservada);
            
            if ($resultado_esta_reservada) {
                $n_tuplas = mysql_num_rows($resultado_esta_reservada);
                
                if ($n_tuplas == 0) {
                    $libre = true;
                }
            }
        }
    }

    return $libre;
}

function alojamiento_habitaciones_cumple_condiciones_para_reservar($id_alojamiento, $n_habitaciones, $capacidad, $fecha_inicio, $fecha_fin, $n_estrellas) {
    $consulta = 'SELECT DISTINCT habitacion.id_tipo_habitacion FROM habitacion, alquiler_habitaciones, tipo_habitacion WHERE '
            . 'habitacion.id_tipo_habitacion=tipo_habitacion.id_tipo_habitacion AND '
            . 'alquiler_habitaciones.id_alojamiento_habitaciones=id_alojamiento AND '
            . 'id_alojamiento=' . $id_alojamiento . ' AND '
            . 'capacidad=' . $capacidad . ' AND '
            . 'numero_estrellas>=' . $n_estrellas;

    $resultado = conexionBD($consulta);

    if ($resultado) {
        while ($fila = mysql_fetch_array($resultado)) {
            $n_hab_libres = obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $fila['id_tipo_habitacion'], $fecha_inicio, $fecha_fin);
            
            if($n_hab_libres >= $n_habitaciones){
                return true;
            }
        }
    }
    return false;
}

function alojamiento_completo_libre($id_alojamiento, $fecha_inicio, $fecha_fin){
    return alojamiento_completo_cumple_condiciones_para_reservar($id_alojamiento, 0, $fecha_inicio, $fecha_fin);
}

?>