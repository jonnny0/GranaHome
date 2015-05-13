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
    $tipo_alojamiento = $_POST['tipo_alojamiento'];

    $consulta = 'INSERT INTO alojamiento (id_propietario, nombre_alojamiento, descripcion_breve, descripcion_detallada, telefono, direccion, localidad) VALUES ('
            . $id . ', "'
            . $_POST['nombre_alojamiento'] . '", "'
            . $_POST['descripcion_breve'] . '", "'
            . $_POST['descripcion_detallada'] . '", '
            . $_POST['telefono'] . ', "'
            . $_POST['direccion'] . '", "'
            . $_POST['localidad'] . '") ';

    $resultado = conexionBD($consulta);

    if (!$resultado) {
        $error = true;
    } else {
        $consulta = 'SELECT * FROM alojamiento WHERE nombre_alojamiento="' . $_POST['nombre_alojamiento'] . '"';

        $resultado = conexionBD($consulta);

        if (!$resultado) {
            $error = true;
        } else {
            $fila = mysql_fetch_array($resultado);
            $id_alojamiento = $fila['id_alojamiento'];

            if ($tipo_alojamiento == "piso" || $tipo_alojamiento == "casa_rural") {
                $resultado = alojamiento_completo($id_alojamiento, $tipo_alojamiento, $_POST['precio']);
            } else {
                $resultado = alojamiento_habitacion($id_alojamiento, $tipo_alojamiento);
            }

            if (!$resultado) {
                $error = true;
            } else {
                if (isset($_POST['caracteristica_alojamiento'])) {
                    $resultado = alojamiento_tiene_caracteristicas($id_alojamiento, $_POST['caracteristica_alojamiento']);
                }
                if (!$resultado) {
                    $error = true;
                } else {
                    $n_fotos = $_POST['num_fotos'];
                    for ($i = 0; $i < $n_fotos; $i++) {
                        $url = "imagenes/" . $_POST['nombre_alojamiento'] . "/" . $_POST['foto'.$i];
                        if(!insertar_imagen($id_alojamiento, $url)){
                            $error = true;
                        }
                    }
                }
            }
        }
    }
    if ($error) {
        echo '<script>
            alert("No se ha podido insertar el alojamiento.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    }else{
        echo '<script>
            alert("El alojamiento ha sido añadido.");
            location.href= "../index.php?sec=opciones_usuario";
        </script>';
    }
}

function alojamiento_completo($id, $tipo, $precio) {
    $consulta = 'INSERT INTO alquiler_completo (id_alojamiento_completo, tipo_alquiler_completo, precio) VALUES ('
            . $id . ', "'
            . $tipo . '", "'
            . $precio . '") ';
    $resultado = conexionBD($consulta);
    return $resultado;
}

function alojamiento_habitacion($id, $tipo) {
    $consulta = 'INSERT INTO alquiler_habitaciones (id_alojamiento_habitaciones, tipo_alquiler_habitacion) VALUES ('
            . $id . ', "'
            . $tipo . '") ';
    $resultado = conexionBD($consulta);
    return $resultado;
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

function insertar_imagen($id_alojamiento, $url){
    $consulta = 'INSERT INTO foto_alojamiento (id_alojamiento, url) VALUES (' . $id_alojamiento . ', "' . $url . '")';
    $resultado = conexionBD($consulta);
    return $resultado;
}
?>
