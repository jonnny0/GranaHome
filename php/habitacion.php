
<?php
include_once 'conexion_bd.php';
include_once 'obtener_fotos_alojamiento.php';

if (isset($_POST['id_habitacion'])) {
    $id_habitacion = $_POST['id_habitacion'];
}
?>

<div id="detalle_habitacion" class="modalmask">
    <div class="modalbox_habitacion moveright_habitacion">
        <a href="" title="Cerrar" class="close">X</a>
        <?php
        $consulta = "SELECT * FROM tipo_habitacion AS tipo LEFT JOIN foto_tipo_habitacion AS foto "
                . "ON tipo.id_tipo_habitacion=foto.id_tipo_habitacion WHERE tipo.id_tipo_habitacion=" . $id_habitacion;
        $resultado = conexionBD($consulta);
        if ($resultado) {
            $fila = mysql_fetch_array($resultado);
            echo "<h2>" . $fila['nombre_tipo'] . "</h2>";
            echo "<hr/>";
            $fotos = obtener_array_fotos_habitacion($id_habitacion);
            echo '<div id="div_img_habitacion_principal" class="centrado_horizontal">';
            echo '<img id="foto_habitacion_principal" src="' . $fotos[0] . '" alt="Foto ' . $fila['nombre_tipo'] . '" />';
            echo '</div>';
            echo '<div id="lista_img_habitaciones_izquierda">';
            echo '<table class="tablaFotoHabitaciones">';
            for ($i = 0; $i < 4; $i+=2) {
                echo '<tr>';
                echo '<td>';
                if ($fotos[$i]) {
                    echo '<div class="centrado_horizontal">';
                    echo '<img src="' . $fotos[$i] . '" alt="Foto ' . $fila['nombre_tipo'] . '" onclick="cambiar_foto_habitacion_principal(this)"/>';
                    echo '</div>';
                }
                echo '</td>';
                echo '<td>';
                if ($fotos[$i + 1]) {
                    echo '<div class="centrado_horizontal">';
                    echo '<img src="' . $fotos[$i + 1] . '" alt="Foto ' . $fila['nombre_tipo'] . '" onclick="cambiar_foto_habitacion_principal(this)"/>';
                    echo '</div>';
                }
                echo '</td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo '<td colspan="2">';
            if ($fotos[$i]) {
                echo '<div class="centrado_horizontal">';
                echo '<img src="' . $fotos[$i] . '" alt="Foto ' . $fila['nombre_tipo'] . '" onclick="cambiar_foto_habitacion_principal(this)"/>';
                echo '</div>';
            }
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
            
            $consulta = 'SELECT * FROM caracteristica_tipo_habitacion';
            $resultado = conexionBD($consulta);
            echo '<table id="tabla_caracteristicas_habitacion" class="centrado_horizontal">';
            echo "<tr>";
            echo '<td colspan="2">';
            echo '<h2>Características</h2>';
            echo '<td>';
            echo "</tr>";
            if ($resultado) {
                $i_caracteristica = 0;
                while ($fila = mysql_fetch_array($resultado)) {
                    if ($i_caracteristica % 2 == 0) {
                        echo "<tr>";
                    }
                    echo '<td>';
                    $id_caract = $fila['id_caracteristica_tipo_habitacion'];
                    $nombre_caract = $fila['nombre_caracteristica'];
                    echo '<input type = "checkbox" id = "caract' . $id_caract . '" name = "caracteristica_habitacion[]" value = "' . $id_caract . '" disabled >';
                    echo '<label for = "caract' . $id_caract . '">' . $nombre_caract . '</label>';
//                    echo '<br/>';
                    echo '</td>';
                    if ($i_caracteristica % 2 == 1) {
                        echo "</tr>";
                    }
                    $i_caracteristica++;
                }
            }
            echo '</table>';

            $consulta_caract_hab = 'SELECT * FROM tipo_habitacion_tiene_caracteristica WHERE id_tipo_habitacion=' . $id_habitacion;
            $resultado_caract_hab = conexionBD($consulta_caract_hab);
            if ($resultado_caract_hab) {
                while ($fila = mysql_fetch_array($resultado_caract_hab)) {
                    $id_caract = $fila['id_caracteristica_tipo_habitacion'];
                    echo '<script> 
                        var caracteristica = document.getElementById("caract" + ' . $id_caract . ');
                        caracteristica.checked = 1;
                    </script>';
                }
            }
//            echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
        } else {
            echo "<h2>No se ha encontrado la habitación</h2>";
        }
        ?>
    </div>
</div>
