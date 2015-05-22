<?php

function reservar($id_cliente, $id_alojamiento, $fecha_inicio, $fecha_fin) {
    //inserción
    $consulta = "INSERT INTO cliente_reserva "
            . "(id_cliente, id_alojamiento, fecha_inicio, fecha_fin) "
            . "VALUES (" . $id_cliente . ", " . $id_alojamiento . ", '"
            . $fecha_inicio . "', '" . $fecha_fin . "')";

    //Envio la consulta a MySQL.
    $resultado = conexionBD($consulta);

    if (!$resultado) {
        return -1;
    } else {
        $consulta = "SELECT * FROM cliente_reserva WHERE id_alojamiento=" . $id_alojamiento
                . " AND "
                . "id_cliente=" . $id_cliente . " AND "
                . "fecha_inicio='" . $fecha_inicio . "' AND "
                . "fecha_fin='" . $fecha_fin . "' ORDER BY id_reserva DESC";

        //Envio la consulta a MySQL.
        $resultado = conexionBD($consulta);

        if (!$resultado) {
            return -1;
        } else {

            $fila = mysql_fetch_array($resultado);
            return $fila['id_reserva'];
        }
    }
}

function reservar_habitacion($id_reserva, $fecha_inicio, $fecha_fin, $id_alojamiento, $id_tipo_habitacion, $n_habitaciones) {

    $resultado = obtener_id_habitaciones_libres_reserva($id_alojamiento, $id_tipo_habitacion, $fecha_inicio, $fecha_fin);

    if ($resultado) {
        $i = 0;
        while ($fila = mysql_fetch_array($resultado)) {
            if ($i < $n_habitaciones) {
                $consulta_insert = 'INSERT INTO reserva_habitacion (id_reserva, id_alojamiento, id_habitacion) VALUES (' . $id_reserva . ', ' . $id_alojamiento . ', ' . $fila['id_habitacion'] . ')';
                $resultado_insert = conexionBD($consulta_insert);
                if (!$resultado_insert) {
                    return false;
                }
            } else {
                return true;
            }
            $i++;
        }
        if ($i == $n_habitaciones) {
            return true;
        } else {
            return false;
        }
    }
}
?>