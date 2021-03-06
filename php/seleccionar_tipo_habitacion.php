<?php

include_once 'conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

if (isset($_POST['id_tipo_habitacion'])) {
    $id_tipo_habitacion = $_POST['id_tipo_habitacion'];
    if ($id_tipo_habitacion == -1) {
        echo '<h2>Nuevo tipo de habitación a crear</h2>';
        echo '<hr/>';
        echo '<label for = "nombre_tipo_alojamiento">Nombre del tipo de habitación: </label>';
        echo '<input type = "text" size = "60" id = "nombre_tipo_alojamiento" name = "nombre_tipo_alojamiento" maxlength = "50" required />';
        echo '<br><br>';
        echo '<label for = "capacidad"> Capacidad: </label>';
        echo '<input type = "number" min = "0" max = "65535" id = "capacidad" name = "capacidad" required/>';
        echo '&nbsp;&nbsp;';
        echo '<label for="precio_noche">Precio por noche: </label>';
        echo '<input type="number" min = "0" step="any" id="precio_noche" name="precio" required/>';
        echo '<br><br>';
        echo '<label for="num_fotos">Número de imágenes: </label>';
        echo '<select name="num_fotos" id="num_fotos" onchange="add_campos_imagenes(this)">';
        echo '<option value="1">1</option>';
        echo '<option value="2">2</option>';
        echo '<option value="3">3</option>';
        echo '<option value="4">4</option>';
        echo '<option value="5">5</option>';
        echo '</select>';
        echo '<br><br>';
        echo '<label for="foto0">Introduce el nombre de la imagen 1: </label>';
        echo '<input type="file" id="foto0" name="foto0" maxlength="50" size="50" required/>';
        echo '<br /><br />';
        echo '<label for="descripcion0">Introduce la descripción para la imagen 1:</label>';
        echo '<br />';
        echo '<textarea id="descripcion0" cols="85" rows="2" maxlength="150" name="descripcion0" required></textarea>';
        
        echo '<div id="mas_imagenes"></div>';
        echo '<br>';

        $consulta = 'SELECT * FROM caracteristica_tipo_habitacion';
        $resultado = conexionBD($consulta);

        if ($resultado) {
            while ($fila = mysql_fetch_array($resultado)) {
                $id_caract = $fila['id_caracteristica_tipo_habitacion'];
                $nombre_caract = $fila['nombre_caracteristica'];
                echo '<input type = "checkbox" id = "caract' . $id_caract . '" name = "caracteristica_tipo_habitacion[]" value = "' . $id_caract . '">';
                echo '<label for = "caract' . $id_caract . '">' . $nombre_caract . '</label>';
                echo '<br/>';
            }
        }

        echo '<br/>';
        echo '<button type="submit" title="Crear Habitaciones" name="crear_habitaciones"> Crear habitaciones </button>';
        echo '</form>';
    } else if ($id_tipo_habitacion != -2) {
        $consulta = 'SELECT * FROM tipo_habitacion WHERE id_tipo_habitacion=' . $id_tipo_habitacion;
        $resultado = conexionBD($consulta);

        if ($resultado) {
            $fila = mysql_fetch_array($resultado);

            echo '<h2>Datos del tipo de la habitación a crear</h2>';
            echo '<hr/>';
            echo '<label for = "nombre_tipo_alojamiento">Nombre del tipo de habitación: </label>';
            echo '<input type = "text" size = "60" id = "nombre_tipo_alojamiento" name = "nombre_tipo_alojamiento" value="' . $fila['nombre_tipo'] . '" disabled />';
            echo '<br><br>';
            echo '<label for = "capacidad"> Capacidad: </label>';
            echo '<input type = "number" id = "capacidad" name = "capacidad" value="' . $fila['capacidad'] . '" disabled/>';
            echo '&nbsp;&nbsp;';
            echo '<label for="precio_noche">Precio por noche: </label>';
            echo '<input type="number" min = "0" step="any" id="precio_noche" name="precio" value="' . $fila['precio'] . '" disabled/>';
            echo '<br><br>';

        }

        $consulta = 'SELECT * FROM caracteristica_tipo_habitacion';
        $resultado = conexionBD($consulta);

        if ($resultado) {
            while ($fila = mysql_fetch_array($resultado)) {
                $id_caract = $fila['id_caracteristica_tipo_habitacion'];
                $nombre_caract = $fila['nombre_caracteristica'];
                echo '<input type = "checkbox" id = "caract' . $id_caract . '" name = "caracteristica_tipo_habitacion[]" value = "' . $id_caract . '" disabled>';
                echo '<label for = "caract' . $id_caract . '">' . $nombre_caract . '</label>';
                echo '<br/>';
            }
        }

        $consulta_habitacion = 'SELECT * FROM tipo_habitacion_tiene_caracteristica WHERE id_tipo_habitacion=' . $id_tipo_habitacion;
        $resultado_habitacion = conexionBD($consulta_habitacion);
        if ($resultado_habitacion) {
            while ($fila = mysql_fetch_array($resultado_habitacion)) {
                $id_caract = $fila['id_caracteristica_tipo_habitacion'];
                echo '<script> 
                    var caracteristica = document.getElementById("caract" + ' . $id_caract . ');
                    caracteristica.checked = 1;
                </script>';
            }
        }

        echo '<br/>';
        echo '<button type="submit" title="Crear Habitaciones" name="crear_habitaciones"> Crear habitaciones </button>';
        echo '</form>';
    } else {
        echo '<hr/>';
        echo '</form>';
    }
}
?>


