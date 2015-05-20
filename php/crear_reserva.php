<?php

include_once './conexion_bd.php';
include_once './obtener_habitaciones_disponibles_por_tipo.php';

echo '$_post <br>';
foreach ($_POST as $nombre_campo => $valor) {
    print $nombre_campo . "---" . $valor . "<br>";
}

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

echo '<br>$_session<br>';
foreach ($_SESSION as $nombre_campo => $valor) {
    print $nombre_campo . "---" . $valor . "<br>";
}

//if()


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
            if ($id_reserva == -1) {
                echo '<script>
                alert("ERROR: No se ha podido hacer la reserva.");
                location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                </script>';
            } else {

                $consulta_tipos = "SELECT DISTINCT habitacion.id_tipo_habitacion, precio FROM habitacion, tipo_habitacion WHERE "
                        . "habitacion.id_tipo_habitacion=tipo_habitacion.id_tipo_habitacion AND "
                        . "habitacion.id_alojamiento=" . $_POST['id_alojamiento'];

                $resultado_tipos = conexionBD($consulta_tipos);
                if ($resultado_tipos) {
                    $habitaciones_marcadas=0;
                    while ($fila_tipos = mysql_fetch_array($resultado_tipos)) {
                        $id_tipo_habitacion = $fila_tipos['id_tipo_habitacion'];
                        $n_habitaciones = (float) $_POST[$id_tipo_habitacion];
                        $n_habitaciones = $n_habitaciones / $fila_tipos['precio'];
                        echo "<br> " . $id_tipo_habitacion . "----" . $n_habitaciones . "<br>";
                        if ($n_habitaciones != 0) {
                            $habitaciones_marcadas++;
                            $exito = reservar_habitacion($id_reserva, $_SESSION['fecha_inicio'], $_SESSION['fecha_fin'], $_POST['id_alojamiento'], $id_tipo_habitacion, $n_habitaciones);
                            if (!$exito) {
                                echo '<script>
                                        alert("No se ha podido reservar alguna habitación.");
                                </script>';
                            }
                        }
                    }
                    if ($exito) {
                        echo '<script>
                            alert("Se han reservado todas las habitaciones con éxito.");
                            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
                    }
                    if($habitaciones_marcadas == 0){
                        echo '<script>
                            alert("No se ha seleccionado ninguna habitacion.");
                            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
                    }
                }
            }
            //el tipo de reserva no es por habitaciones
        } else {
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

        echo "fila     " . mysql_num_rows($resultado);
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
                echo "Habitacion libre: " . $fila['id_habitacion'] . "<br>";
                $consulta_insert = 'INSERT INTO reserva_habitacion (id_reserva, id_alojamiento, id_habitacion) VALUES (' . $id_reserva . ', ' . $id_alojamiento . ', ' . $fila['id_habitacion'] . ')';
                $resultado_insert = conexionBD($consulta_insert);
                if (!$resultado_insert) { return false; }
            } else {
                return true;
            }
            $i++;
        }
        if ($i == $n_habitaciones) {
            return true;
        }else{
            return false;
        }
    }
}

?>