<?php

include_once './conexion_bd.php';

foreach ($_POST as $nombre_campo => $valor) {
    print $nombre_campo . "---" . $valor . "<br>";
}

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

foreach ($_SESSION as $nombre_campo => $valor) {
    print $nombre_campo . "---" . $valor . "<br>";
}



if (isset($_SESSION['nombre_usuario']) && $_SESSION['tipo_usuario'] == 'cliente') {

    $consulta = 'SELECT id_usuario AS id_cliente FROM usuario WHERE nombre_usuario="' . $_SESSION['nombre_usuario'] . '"';

    //Envio la consulta a MySQL.
    $resultado_nombre_usuario = conexionBD($consulta);

    $fila = mysql_fetch_array($resultado_nombre_usuario);

    if ($resultado_nombre_usuario) {
        if ($_POST['tipo_alquiler'] == 'piso' || $_POST['tipo_alquiler'] == 'casa_rural') {
            $es_alquiler_por_habitaciones = false;
        } else {
            $es_alquiler_por_habitaciones = true;
        }


        if ($es_alquiler_por_habitaciones) {
            $id_reserva = reservar($fila['id_cliente'], $_POST['id_alojamiento'], $_SESSION['fecha_inicio'], $_SESSION['fecha_fin']);
            echo "<br><br>ID_reserva: " . $id_reserva;
            if ($resultado == -1) {
                echo '<script>
                alert("ERROR: No se ha podido hacer la reserva.");
                location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                </script>';
            } else {

                $consulta = 'SELECT * FROM tipo_habitacion';
                $resultado_numero_tipo_habitacion = conexionBD($consulta);

                while ($fila = mysql_fetch_array($resultado_numero_tipo_habitacion)) {
                    echo "<br><br>ID_HAB:" . $_POST[$fila['id_tipo_habitacion']] . "<br><br>";
                    if (isset($_POST[$fila['id_tipo_habitacion']])) {
                        //reservo el número de veces que diga el select
                        for ($i = 0; $i < $_POST[$fila['id_tipo_habitacion']]; $i++) {
                            $resultado_reserva_habitacion = reservar_habitacion($id_reserva, $_POST['id_alojamiento'], $_POST[$fila['id_tipo_habitacion']]);
                            if (!$resultado_reserva_habitacion) {
//                                echo '<script>
//                            alert("ERROR: No se ha podido hacer la reserva.");
//                            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
//                            </script>';
                            }
                        }
                    }
//                                                    echo '<script>
//                            alert("ERROR: No se ha podido hacer la reserva.");
//                            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
//                            </script>';
                    
                }

//            $consulta = 'SELECT * FROM tipo_habitacion WHERE id_tipo_habitacion="' . $_POST['id_tipo_habitacion'] . '"';
//            $resultado_precio_habitacion = conexionBD($consulta);
//            $fila = mysql_fetch_array($resultado_precio_habitacion);

//                echo '<script>
//                alert("La reserva se ha realizado correctamente.");
//                location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
//                </script>';
            }
            //el tipo de reserva no es por habitaciones
        } else {
            $resultado = reservar($fila['id_cliente'], $_POST['id_alojamiento'], $_SESSION['fecha_inicio'], $_SESSION['fecha_fin']);

            if (!$resultado) {
                $resultado = reservar($fila['id_cliente'], $_POST['id_alojamiento'], $_SESSION['fecha_inicio'], $_SESSION['fecha_fin']);

                if ($resultado == -1) {
                    echo '<script>
                    alert("ERROR: No se ha podido hacer la reserva.");
                    location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                    </script>';
                } else {
                    echo '<script>
                    alert("La reserva se ha realizado correctamente.");
                    location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                    </script>';
                }
            }
        }
    } else {
        echo '<script>
            alert("Tiene que estar registrado como cliente.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    }
}

function reservar($id_cliente, $id_alojamiento, $fecha_inicio, $fecha_fin) {
    echo $id_alojamiento;
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

            echo "fila     "  . mysql_num_rows($resultado); 
        if (!$resultado) {
            return -1;
        } else {

            $fila = mysql_fetch_array($resultado);
            return $fila['id_reserva'];
        }
    }
}

function reservar_habitacion($id_reserva, $id_alojamiento, $id_habitacion) {

    $consulta = 'INSERT INTO reserva_habitacion (id_reserva, id_alojamiento, id_habitacion) VALUES (' . $id_reserva . ', ' . $id_alojamiento . ', ' . $id_habitacion . ')';
    
    $resultado = conexionBD($consulta);
    if (!$resultado) {
        return false;
    }
    return true;
}

?>