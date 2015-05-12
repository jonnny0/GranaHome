<?php

include_once './conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

if (isset($_SESSION['nombre_usuario'])) {

    if ($_POST['tipo_alquiler'] == "hotel") {


        //comprobación de que el usuario exista
        $consulta = '';

        //Envio la consulta a MySQL.
        $resultado = conexionBD($consulta);

        if (!$resultado) {
            echo '<script>
            alert("ERROR: No se ha podido hacer la reserva.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
        } else {
            echo '<script>
            alert("La reserva se ha realizado correctamente.");
            location.href="../index.php";
        </script>';
        }
    } else {
        
    }
} else {
    header('Location: ../index.php');
}

function reservar() {

    //inserción
    $consulta = 'INSERT INTO cliente_reserva '
            . '(id_cliente, id_alojamiento, fecha_inicio, fecha_fin) '
            . 'VALUES ' . $id_cliente . ', ' . $id_alojamiento . ', ' . $fecha_inicio . ', ' . $fecha_fin;

    //Envio la consulta a MySQL.
    $resultado = conexionBD($consulta);

    if (!$resultado) {
        return -1;
    } else {
        $consulta = "SELECT * FROM cliente_reserva WHERE id_alojamiento=" . $id_alojamiento . " AND "
                . "id_cliente=" . $id_cliente . " AND "
                . "fecha_inicio=" . $fecha_inicio . " AND "
                . "fecha_fin=" . $fecha_fin . " ORDER BY id_reserva DESC";

        //Envio la consulta a MySQL.
        $resultado = conexionBD($consulta);
        
        $fila = mysql_fetch_array($resultado);

        return $fila['id_reserva'];
    }
}

?>