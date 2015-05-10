<?php

include_once 'conexion_bd.php';
include_once 'obtener_id_usuario.php';
if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$id = obtener_id_usuario($_SESSION['nombre_usuario']);

if ($id == -1) {
    echo '<script>
            alert("No tienes permisos para realizar la acción.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    $error = false;
    $id_alojamiento = $_POST['id_alojamiento'];

    $consulta = 'UPDATE alojamiento SET '
            . 'nombre_alojamiento="' . $_POST['nombre_alojamiento'] . '", '
            . 'descripcion_breve="' . $_POST['descripcion_breve'] . '", '
            . 'descripcion_detallada="' . $_POST['descripcion_detallada'] . '", '
            . 'direccion="' . $_POST['direccion'] . '", '
            . 'localidad="' . $_POST['localidad'] . '", '
            . 'telefono=' . $_POST['telefono'] . ' '
            . 'WHERE id_alojamiento=' . $id_alojamiento;

    $resultado = conexionBD($consulta);

    if (!$resultado) {
        $error = true;
    } else {
        $consulta = 'SELECT * FROM alojamiento WHERE nombre_alojamiento="' . $_POST['nombre_alojamiento'] . '"';

        $resultado = conexionBD($consulta);

        if (!$resultado) {
            $error = true;
        } else {
            $consulta = 'DELETE FROM alojamiento_tiene_caracteristica WHERE id_alojamiento=' . $id_alojamiento;

            $resultado = conexionBD($consulta);

            if (!$resultado) {
                $error = true;
            } else {
                if (isset($_POST['caracteristica_alojamiento'])) {
                    $resultado = alojamiento_tiene_caracteristicas($id_alojamiento, $_POST['caracteristica_alojamiento']);
                }
                if (!$resultado) {
                    $error = true;
                } else {
                    echo '<script>
                    alert("El alojamiento ha sido actualizado.");
                    location.href= "../index.php?sec=opciones_usuario";
                </script>';
                }
            }
        }
    }
    if ($error) {
        echo '<script>
            alert("No se ha podido actualizar el alojamiento.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    }
}

function alojamiento_tiene_caracteristicas($id_alojamiento, $caracteristicas) {
    if (!empty($caracteristicas)) {
        $n_caracteristicas = count($caracteristicas);
//        $consulta = "";
        for ($i = 0; $i < $n_caracteristicas; $i++) {
            $consulta = 'INSERT INTO alojamiento_tiene_caracteristica (id_alojamiento, id_caracteristica_alojamiento) VALUES ('
                    . $id_alojamiento . ', '
                    . $caracteristicas[$i] . '); ';
            $resultado = conexionBD($consulta);
            if (!$resultado) {
                return false;
            }
        }
    }
    return true;
}

?>
