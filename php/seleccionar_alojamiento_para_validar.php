<?php
include_once 'conexion_bd.php';
include_once './obtener_id_usuario.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}
$id_administrador = obtener_id_usuario($_SESSION['nombre_usuario']);
if (isset($_POST['id_alojamiento'])) {
    $id_alojamiento = $_POST['id_alojamiento'];
    if ($id_alojamiento != -1) {
        $consulta = 'SELECT * FROM alojamiento WHERE id_alojamiento=' . $id_alojamiento;

        $resultado = conexionBD($consulta);

        if ($resultado) {
            $fila = mysql_fetch_array($resultado);
            echo '<h2>Datos del alojamiento a validar</h2>';
            echo '<hr/>';
            echo '<form method = "post" action = "php/validar_alojamiento.php">';
            echo '<input type=hidden name="id_administrador" value="' . $id_administrador .'"/>';
            echo '<input type=hidden name="id_alojamiento" value="' . $id_alojamiento .'"/>' ;
            echo '<label for = "nombre_alojamiento">Nombre del alojamiento: </label>';
            echo '<input type = "text" size = "60" id = "nombre_alojamiento" name = "nombre_alojamiento" maxlength = "50" value="' . $fila['nombre_alojamiento'] . '"disabled  />';
            echo '<br><br>';
            echo '<label for = "direccion">Dirección: </label>';
            echo '<input type = "text" size = "75" id = "direccion" maxlength = "100" name = "direccion" value="' . $fila['direccion'] . '"disabled/>';
            echo '<br><br>';
            echo '<label for = "localidad">Localidad: </label>';
            echo '<input type = "text" id = "localidad" maxlength = "50" name = "localidad" value="' . $fila['localidad'] . '" disabled/>';
            echo '&nbsp;&nbsp;';
            echo '<label for = "telefono">Telefono de contacto: </label>';
            echo '<input type = "number" max = "999999999" id = "telefono" name = "telefono" value="' . $fila['telefono'] . '" disabled/>';
            echo '<br><br>';
            echo '<label for = "descripcion_breve">Descripción breve (Máximo 200 caracteres): </label>';
            echo '<br>';
            echo '<textarea id = "descripcion_breve" cols = "85" rows = "2" maxlength = "200" name = "descripcion_breve" disabled>' . $fila['descripcion_breve'] . '</textarea>';
            echo '<br><br>';
            echo '<label for = "descripcion_detallada">Descripción detallada (Máximo 1000 caracteres): </label>';
            echo '<br>';
            echo '<textarea id = "descripcion_detallada" cols = "85" rows = "8" maxlength = "1000" name = "descripcion_detallada" disabled>' . $fila['descripcion_detallada'] . '</textarea>';
            echo '<br><br>';
            echo '<hr/>';
            echo '<h3> Características </h3>';

            $consulta = 'SELECT * FROM caracteristica_alojamiento';
            $resultado = conexionBD($consulta);

            if ($resultado) {
                while ($fila = mysql_fetch_array($resultado)) {
                    $id_caract = $fila['id_caracteristica_alojamiento'];
                    $nombre_caract = $fila['nombre_caracteristica'];
                    echo '<input type = "checkbox" id = "caract' . $id_caract . '" name = "caracteristica_alojamiento[]" value = "' . $id_caract . '" disabled >';
                    echo '<label for = "caract' . $id_caract . '">' . $nombre_caract . '</label>';
                    echo '<br/>';
                }
            }

            $consulta_hotel = 'SELECT * FROM alojamiento_tiene_caracteristica WHERE id_alojamiento=' . $id_alojamiento;
            $resultado_hotel = conexionBD($consulta_hotel);
            if ($resultado_hotel) {
                while ($fila = mysql_fetch_array($resultado_hotel)) {
                    $id_caract = $fila['id_caracteristica_alojamiento'];
                    echo '<script> 
                        var caracteristica = document.getElementById("caract" + ' . $id_caract . ');
                        caracteristica.checked = 1;
                    </script>';
                }
            }
            echo '<br/>';
            echo '<button type="submit" title="Validar alojamiento" name="validar"> Validar alojamiento </button>';
            echo '</form>';
        }
    }
}
?>


