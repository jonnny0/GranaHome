<?php

include_once './conexion_bd.php';
include_once './obtener_habitaciones_disponibles_por_tipo.php';
include_once './funciones_reservas.php';


if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
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
                    $habitaciones_marcadas = 0;
                    $exito = false;
                    while ($fila_tipos = mysql_fetch_array($resultado_tipos)) {
                        $id_tipo_habitacion = $fila_tipos['id_tipo_habitacion'];
                        if (isset($_POST[$id_tipo_habitacion])) {
                            $n_habitaciones = (float) $_POST[$id_tipo_habitacion];
                            $n_habitaciones = $n_habitaciones / $fila_tipos['precio'];

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
                    }
                    if ($exito) {
                        echo '<script>
                            alert("Se han reservado todas las habitaciones con éxito.");
                            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                        </script>';
                    }
                    if ($habitaciones_marcadas == 0) {
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

?>