<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript">
    function actualizar(select) {
        var id_alojamiento = select.value;
        $("#datos_alojamiento_a_modificar").load("php/seleccionar_alojamiento_para_modificar.php", {id_alojamiento: id_alojamiento});
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
    $consulta = 'SELECT id_alojamiento, nombre_alojamiento FROM alojamiento WHERE id_propietario=' . $id_propietario;

    $resultado = conexionBD($consulta);

    if ($resultado) {
      echo '<div id="selector">';
//        echo '<label for="alojamiento_seleccionado">Selecciona el alojamiento: </label>';
        echo '<select name="alojamiento_seleccionado" id="alojamiento_seleccionado" onchange="actualizar(this)">';
        echo '<option value="-1"> Selecciona alojamiento</option>';
        while ($fila = mysql_fetch_array($resultado)) {
            $id_aloj = $fila['id_alojamiento'];
            $nombre_aloj = $fila['nombre_alojamiento'];
            echo '<option value="' . $id_aloj . '">' . $nombre_aloj . '</option>';
        }
        echo '</select>';
        echo '</div>';
    }
}
?>
<div id="datos_alojamiento_a_modificar" class="opciones_usuario insertar_alojamiento movedown">

</div>