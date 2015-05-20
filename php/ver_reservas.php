<?php

include_once 'conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}
?>
<div id="menuOpcionesUsuario">
    <ul>
	<li>
            <a href="index.php?sec=comentar">Añadir un comentario</a>
	</li>
	<li id="active">
	    <a href="index.php?sec=ver_reservas">Ver reservas</a>
	</li>
	<li>
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>
</div>
<br><br><br>
<?php
echo '<h2>Próximas reservas</h2>';

$fecha_actual = date("Y-m-d");

$consulta = "SELECT * FROM usuario, cliente_reserva, alojamiento WHERE "
        . "id_cliente=id_usuario AND alojamiento.id_alojamiento=cliente_reserva.id_alojamiento "
        . "AND nombre_usuario='" . $_SESSION['nombre_usuario'] . "' AND fecha_inicio>='" . $fecha_actual . "'";

//Envio la consulta a MySQL.
$resultado = conexionBD($consulta);

if ($resultado) {
    echo '<table id="ver_reservas">';
    echo '<tr><th>Nombre del alojamiento</th>';
    echo '<th>Fecha inicio</th>';
    echo '<th>Fecha fin</th>';
    echo '</tr>';
    while ($fila = mysql_fetch_array($resultado)) {
        echo '<tr>';
        echo '<td>' . $fila['nombre_alojamiento'] . '</td>';
        echo '<td>' . $fila['fecha_inicio'] . '</td>';
        echo '<td>' . $fila['fecha_fin'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
?>

