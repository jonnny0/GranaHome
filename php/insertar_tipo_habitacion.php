<?php

include_once 'conexion_bd.php';
include_once 'obtener_id_usuario.php';
if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$id_propietario = obtener_id_usuario($_SESSION['nombre_usuario']);

if ($id_propietario == -1) {
    $error_str = "No tienes permisos para realizar la acción.";
    $error = true;
} else {
    $error_str = "No se han podido insertar las habitaciones";
    $error = false;

    $id_tipo_habitacion = $_POST['habitacion_seleccionada'];
    $id_alojamiento = $_POST['alojamiento_seleccionado'];

    if ($id_tipo_habitacion == -1) {
        $consulta = 'INSERT INTO tipo_habitacion (nombre_tipo, capacidad, precio, id_propietario) VALUES ("'
                . $_POST['nombre_tipo_alojamiento'] . '", '
                . $_POST['capacidad'] . ', '
                . $_POST['precio'] . ', '
                . $id_propietario . ') ';

        $resultado = conexionBD($consulta);

        if (!$resultado) {
            $error_str = "Ya existe un tipo de habitación con ese nombre";
            $error = true;
        } else {
            $consulta = 'SELECT * FROM tipo_habitacion WHERE nombre_tipo="' . $_POST['nombre_tipo_alojamiento'] . '" '
                    . ' AND id_propietario=' . $id_propietario;

            $resultado = conexionBD($consulta);

            if (!$resultado) {
                $error = true;
            } else {
                $fila = mysql_fetch_array($resultado);
                $id_tipo_habitacion = $fila['id_tipo_habitacion'];

                // ********************** INICIO DE IMAGENES **************************
                $n_fotos = $_POST['num_fotos'];
                for ($i = 0; $i < $n_fotos; $i++) {
                    if ($_FILES['foto' . $i]["error"] > 0) {
                        salir("Ha ocurrido un error en la carga de la imagen", -3);
                    } else {
                        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $limite_kb = 2048;
                        if (in_array($_FILES['foto' . $i]['type'], $permitidos) && $_FILES['foto' . $i]['size'] <= $limite_kb * 1024) {
                            $carpeta = "../imagenes/habitacion_" . $id_tipo_habitacion;
                            if (!is_dir($carpeta)) {
                                mkdir($carpeta);
                            }
                            $nombre_archivo = $_FILES['foto' . $i]['name'];
                            $ruta = $carpeta . "/" . $nombre_archivo;
                            if (!file_exists($ruta)) {
                                $resultado_subida = @move_uploaded_file($_FILES['foto' . $i]['tmp_name'], $ruta);
                                if ($resultado_subida) {
                                    $url = $url = "imagenes/habitacion_" . $id_tipo_habitacion . "/" . $_FILES['foto' . $i]['name'];
                                    $descripcion = $_POST['descripcion' . $i];
                                    insertar_imagen($id_alojamiento, $url, $descripcion);
                                }
                            }
                        }
                    }
                }
                // ********************** FIN DE IMAGENES **************************   


                if (isset($_POST['caracteristica_tipo_habitacion'])) {
                    $resultado = tipo_habitacion_tiene_caracteristicas($id_tipo_habitacion, $_POST['caracteristica_tipo_habitacion']);
                }
                if (!$resultado) {
                    $error = true;
                }
            }
        }
    }

    $resultado = insertar_habitaciones($id_alojamiento, $id_tipo_habitacion, $_POST['numero_habitaciones']);
    if (!$resultado) {
        $error = true;
    } else {
        echo '<script>
                alert("Las habitaciones han sido creadas.");
                location.href= "../index.php?sec=opciones_usuario";
            </script>';
    }
}
if ($error) {
    echo '<script>
        alert("' . $error_str . '");
        location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
    </script>';
}

function insertar_habitaciones($id_alojamiento, $id_tipo_habitacion, $numero) {
    $consulta = 'DELETE FROM habitacion WHERE id_alojamiento=' . $id_alojamiento . ' AND '
            . 'id_tipo_habitacion=' . $id_tipo_habitacion;
    $resultado = conexionBD($consulta);
    if (!$resultado) {
        return false;
    }
    $consulta = 'INSERT INTO habitacion (id_alojamiento, id_tipo_habitacion) VALUES (' . $id_alojamiento . ', ' . $id_tipo_habitacion . ')';
    for ($i = 1; $i < $numero; $i++) {
        $consulta = $consulta . ', (' . $id_alojamiento . ', ' . $id_tipo_habitacion . ')';
    }
    $resultado = conexionBD($consulta);
    if (!$resultado) {
        return false;
    }
    return true;
}

function tipo_habitacion_tiene_caracteristicas($id_tipo_habitacion, $caracteristicas) {
    if (!empty($caracteristicas)) {
        $n_caracteristicas = count($caracteristicas);
        $consulta = 'INSERT INTO tipo_habitacion_tiene_caracteristica (id_tipo_habitacion, id_caracteristica_tipo_habitacion) '
                . 'VALUES (' . $id_tipo_habitacion . ', ' . $caracteristicas[0] . ')';
        for ($i = 1; $i < $n_caracteristicas; $i++) {
            $consulta = $consulta . ', (' . $id_tipo_habitacion . ', ' . $caracteristicas[$i] . ')';
        }
        $resultado = conexionBD($consulta);
        if (!$resultado) {
            return false;
        }
    }
    return true;
}

function insertar_imagen($id_tipo_habitacion, $url, $descripcion) {
    $consulta = 'INSERT INTO foto_tipo_habitacion (id_tipo_habitacion, url, descripcion) VALUES '
            . '(' . $id_tipo_habitacion . ', "' . $url . '", "' . $descripcion . '")';
    $resultado = conexionBD($consulta);
    return $resultado;
}

?>
