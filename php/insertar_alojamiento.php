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
                $resultado = alojamiento_completo($id_alojamiento, $tipo_alojamiento, $_POST['capacidad'], $_POST['precio']);
            } else {
                $resultado = alojamiento_habitacion($id_alojamiento, $tipo_alojamiento, $_POST['numero_estrellas']);
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



                        // ********************** INICIO DE IMAGENES **************************

                        if ($_FILES["foto" . $i]["error"] > 0) {
                            salir("Ha ocurrido un error en la carga de la imagen", -3);
                        } else {
                            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                            $limite_kb = 500;

                            if (in_array($_FILES["foto" . $i]['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
                                $carpeta = "../imagenes/" . $_POST['nombre_alojamiento'];
                                if (!is_dir($carpeta)) {
                                    mkdir($carpeta);
                                }
                                $nombre_archivo = $_FILES["foto" . $i]['name'];
                                $ruta = $carpeta . "/" . $nombre_archivo;
                                if (!file_exists($ruta)) {
                                    $resultado_subida = @move_uploaded_file($_FILES["foto" . $i]['tmp_name'], $ruta);
                                    if ($resultado_subida) {
                                        $url = $url = "imagenes/" . $_POST['nombre_alojamiento'] . "/" . $_FILES["foto" . $i]['name'];
                                        if (!insertar_imagen($id_alojamiento, $url)) {
                                            $error = true;
                                        }
                                    }
                                }
                            }
                        }
                        // ********************** FIN DE IMAGENES **************************   
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
    } else {
        echo '<script>
            alert("El alojamiento ha sido añadido.");
            location.href= "../index.php?sec=opciones_usuario";
        </script>';
    }
}

function alojamiento_completo($id, $tipo, $capacidad, $precio) {
    $consulta = 'INSERT INTO alquiler_completo (id_alojamiento_completo, tipo_alquiler_completo, capacidad, precio) VALUES ('
            . $id . ', "'
            . $tipo . '", '
            . $capacidad . ', "'
            . $precio . '") ';
    $resultado = conexionBD($consulta);
    return $resultado;
}

function alojamiento_habitacion($id, $tipo, $n_estrellas) {
    $consulta = 'INSERT INTO alquiler_habitaciones (id_alojamiento_habitaciones, tipo_alquiler_habitacion, numero_estrellas) VALUES ('
            . $id . ', "'
            . $tipo . '", '
            . $n_estrellas . ') ';
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

function insertar_imagen($id_alojamiento, $url) {
    $consulta = 'INSERT INTO foto_alojamiento (id_alojamiento, url) VALUES (' . $id_alojamiento . ', "' . $url . '")';
    $resultado = conexionBD($consulta);
    return $resultado;
}

function salir($str, $code) {
    echo '<script>
            alert("' . $str . '");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    return $code;
}

?>
