<?php

include_once 'conexion_bd.php';
include_once 'obtener_habitaciones_disponibles_por_tipo.php';
include_once 'php/obtener_fotos_alojamiento.php';

//$id_alojamiento = $_POST['id_alojamiento'];
//$consulta = 'SELECT * FROM alojamiento WHERE id_alojamiento=' . $id_alojamiento;
$consulta = "
    SELECT nombre_alojamiento, descripcion_detallada, direccion, localidad, tipo_alquiler_completo AS tipo_alquiler
    FROM alojamiento, alquiler_completo
    WHERE id_alojamiento=id_alojamiento_completo AND id_alojamiento=" . $id_alojamiento . "
    UNION
    SELECT nombre_alojamiento, descripcion_detallada, direccion, localidad, tipo_alquiler_habitacion AS tipo_alquiler
    FROM alojamiento, alquiler_habitaciones
    WHERE id_alojamiento=id_alojamiento_habitaciones AND id_alojamiento=" . $id_alojamiento;

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("ERROR: No se ha podido mostrar el alojamiento seleccionado.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    $fila = mysql_fetch_array($resultado);
    if ($fila['tipo_alquiler'] == 'piso' || $fila['tipo_alquiler'] == 'casa_rural') {
        $es_alquiler_por_habitaciones = false;
    } else {
        $es_alquiler_por_habitaciones = true;
    }

    if ($es_alquiler_por_habitaciones) {
        echo '<h1> ' . $fila['nombre_alojamiento'] . ' <img src="imagenes/ico_estrella_4.png" alt="4 Estrellas" /></h1>';
    } else {
        echo '<h1> ' . $fila['nombre_alojamiento'] . ' </h1>';
    }

    echo '<p id="direccion">';
    echo '<i> ' . $fila['direccion'] . ', ' . $fila['localidad'] . ', España </i>';
    echo '</p>';

    echo '<div class="centrado_horizontal">';
    echo '<img id="foto_principal" src="' . obtener_foto_alojamiento($id_alojamiento) . '" alt="Foto ' . $fila['nombre_alojamiento'] . '" />';
    echo '</div>';

    $fotos = obtener_array_fotos_alojamiento($id_alojamiento);
    echo '<table class="tablaFotoAlojamientos">';
    echo '<tr>';
    $pos = [3, 1, 0, 2, 4];
    for ($i = 0; $i < 5; $i++) {
        echo '<td>';
        if ($fotos[$pos[$i]]) {
            echo '<div class="centrado_horizontal">';
            echo '<img src="' . $fotos[$pos[$i]] . '" alt="Foto ' . $fila['nombre_alojamiento'] . '" onclick="cambiar_foto_principal(this)"/>';
            echo '</div>';
        }
        echo '</td>';
    }
    echo '</tr>';
    echo '</table>';


    echo '<h2> Descripción detallada </h2>';
    echo '<p class="resumen">';
    echo $fila['descripcion_detallada'];
    echo '</p>';

    if (!$es_alquiler_por_habitaciones) {
        
        $consulta_alojamiento_completo = "SELECT precio FROM alquiler_completo WHERE id_alojamiento_completo=" . $id_alojamiento;
        
        $resultado_alojamiento_completo = conexionBD($consulta_alojamiento_completo);
        
        if ($resultado_alojamiento_completo){
            $fila_alojamiento_completo = mysql_fetch_array($resultado_alojamiento_completo);
            
            echo '<h2>Reservar</h2>';

            echo '<form method="post" action="php/crear_reserva.php">';
                echo '<input type="hidden" name="id_alojamiento" value="' . $id_alojamiento . '"/>';
                echo '<input type="hidden" name="tipo_alquiler" value="' . $fila['tipo_alquiler'] . '"/>';
                echo '<table>';
                echo '<tr>';
                    echo '<td name="precio_total">Precio ' . $fila_alojamiento_completo['precio'] . ' € &nbsp;&nbsp;&nbsp;</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td><button type="submit" id="reservar" name="reservar">Reservar</button></td>';
                echo '</tr>';
                echo '</table>';
            echo '</form>';
        }
    } else {

        echo '<h2>Habitaciones disponibles</h2>';

        $consulta = 'SELECT DISTINCT id_tipo_habitacion FROM habitacion WHERE id_alojamiento=' . $id_alojamiento;
        $resultado = conexionBD($consulta);

        if (!$resultado) {
            echo '<script>
                alert("ERROR: No se ha podido mostrar el alojamiento seleccionado.");
                location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
            </script>';
        } else {
            $n_habitaciones = mysql_num_rows($resultado);
            $i_habitacion = 0;
            echo '<form method="post" action="php/crear_reserva.php">';
            echo '<input type="hidden" name="id_alojamiento" value="' . $id_alojamiento . '"/>';
            echo '<input type="hidden" name="tipo_alquiler" value="' . $fila['tipo_alquiler'] . '"/>';
            echo '<table class="tablaHabitaciones">';

            while ($fila = mysql_fetch_array($resultado)) {
                $id_tipo_habitacion = $fila['id_tipo_habitacion'];
                $consulta_tipo_habitacion = 'SELECT * FROM tipo_habitacion WHERE id_tipo_habitacion=' . $id_tipo_habitacion;
                $resultado_tipo_habitacion = conexionBD($consulta_tipo_habitacion);

                if (!$resultado_tipo_habitacion) {
                    echo '<script>
                        alert("ERROR: No se ha podido mostrar el alojamiento seleccionado.");
                        location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
                    </script>';
                } else {
                    $fila_tipo_habitacion = mysql_fetch_array($resultado_tipo_habitacion);

                    $n_habitaciones_disponibles = obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $id_tipo_habitacion, '2015-05-15', '2015-06-15');

                    echo '<tr>
                        <td class="negrita">
                            Nombre:
                        </td>
                        <td colspan="5">';
                    echo $fila_tipo_habitacion['nombre_tipo'];
                    echo '</td>
                    </tr>
                    <tr>
                        <td class="negrita separacion">
                            Capacidad:
                        </td>
                        <td class="separacion">';
                    echo $fila_tipo_habitacion['capacidad'];
                    if ($fila_tipo_habitacion['capacidad'] == 1) {
                        echo ' Persona';
                    } else {
                        echo ' Personas';
                    }
                    echo '</td>
                        <td class="negrita separacion">
                            Precio:
                        </td>
                        <td class="separacion">';
                    echo $fila_tipo_habitacion['precio'] . ' €';
                    echo '</td>
                        <td class="negrita separacion">
                            Número Habitaciones:
                        </td>
                        <td class="separacion">';
                    echo '<select name="' . $id_tipo_habitacion . '" id="numero_habitaciones_'
                    . $i_habitacion . '" onchange="actualizar_precio_reserva(' . $n_habitaciones . ')">';
                    for ($i = 0; $i <= $n_habitaciones_disponibles and $i <= 10; $i++) {
                        echo '<option value="' . $i * $fila_tipo_habitacion['precio'] . '">' . $i . '</option>';
                    }
                    $i_habitacion++;
                    echo '</select>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            echo '<tr>
                <td></td>
                <td></td>
                <td class="negrita">Precio:</td>
                <td id="precio_total" colspan="2">0 €</td>
                <td><button type="submit" id="reservar" name="reservar">Reservar</button></td></tr>';
            echo '</table>';
            echo '</form>';
        }
    }

    echo '<h2>Características</h2>';

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

    echo '<h2>Comentarios</h2>';
    echo '<table>';

    $consulta_comentarios = "SELECT puntuacion, comentario, nombre_usuario FROM cliente_reserva, usuario "
            . "WHERE id_cliente = id_usuario AND id_alojamiento=" . $id_alojamiento . " AND puntuacion IS NOT NULL";
    $resultado_comentarios = conexionBD($consulta_comentarios);

    while ($fila_comentarios = mysql_fetch_array($resultado_comentarios)) {
        echo '<tr>';
        echo '<td class="negrita">';
        echo $fila_comentarios['nombre_usuario'] . ' &nbsp;&nbsp;&nbsp;&nbsp; Valoración: ' . $fila_comentarios['puntuacion'];
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo $fila_comentarios['comentario'];
        echo '<br/><br/>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>