<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="../js/formularios.js"></script>
<script type="text/javascript">
    function actualizar(select) {
        var id_tipo_habitacion = select.value;
        $("#datos_tipo_habitacion_a_incluir").load("php/seleccionar_tipo_habitacion.php", {id_tipo_habitacion: id_tipo_habitacion});
    }
</script>

<?php
include_once 'conexion_bd.php';
include_once 'obtener_id_usuario.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$id_propietario = obtener_id_usuario($_SESSION['nombre_usuario']);
if ($id_propietario != -1) {
    $consulta_hotel = 'SELECT id_alojamiento, nombre_alojamiento FROM alojamiento WHERE id_propietario=' . $id_propietario;
    $resultado_hotel = conexionBD($consulta_hotel);
    echo '<form method = "post" action = "php/insertar_tipo_habitacion.php" onsubmit="return comprueba_formulario_tipo_habitacion(this)">';
    if ($resultado_hotel) {
        echo '<div id="selector">';
//        echo '<label for="alojamiento_seleccionado">Selecciona el alojamiento: </label>';
        echo '<select name="alojamiento_seleccionado" id="alojamiento_seleccionado">';
        echo '<option value="-1"> Selecciona alojamiento</option>';
        while ($fila = mysql_fetch_array($resultado_hotel)) {
            $id_aloj = $fila['id_alojamiento'];
            $nombre_aloj = $fila['nombre_alojamiento'];
            echo '<option value="' . $id_aloj . '">' . $nombre_aloj . '</option>';
        }
        echo '</select>';
    }

    $consulta_habitacion = 'SELECT id_tipo_habitacion, nombre_tipo FROM tipo_habitacion WHERE id_propietario=' . $id_propietario;
    $resultado_habitacion = conexionBD($consulta_habitacion);

    if ($resultado_habitacion) {
        echo '&nbsp;&nbsp;';
        echo '<select name="habitacion_seleccionada" id="habitacion_seleccionada" onchange="actualizar(this)">';
        echo '<option value="-2"> Selecciona el tipo de habitación </option>';
        while ($fila = mysql_fetch_array($resultado_habitacion)) {
            $id_tipo = $fila['id_tipo_habitacion'];
            $nombre_tipo = $fila['nombre_tipo'];
            echo '<option value="' . $id_tipo . '">' . $nombre_tipo . '</option>';
        }
        echo '<option value="-1"> -------- Nueva -------- </option>';
        echo '</select>';
    }
    echo '&nbsp;&nbsp;';
    echo '<label for="numero_habitaciones">Numero de habitaciones: </label>';
    echo '<input type="number" id="numero_habitaciones" max="9999" name="numero_habitaciones" required/>';

}
?>
<div id="datos_tipo_habitacion_a_incluir" class="opciones_usuario insertar_alojamiento movedown">
    <hr/>
</form>
</div>
</div>