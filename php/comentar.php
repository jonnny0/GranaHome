<div id="menuOpcionesUsuario">
    <ul>
	<li id="active">
            <a href="index.php?sec=comentar">Añadir un comentario</a>
	</li>
	<li >
	    <a href="index.php?sec=ver_reservas">Ver reservas</a>
	</li>
	<li>
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>
</div>

<br><br><br>

<?php
include_once 'conexion_bd.php';
echo '<script src="../js/formularios.js"></script>';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

echo '<h2>Comentar sobre alojamiento</h2>';

$fecha_actual = date("Y-m-d");

$consulta = "SELECT * FROM usuario, cliente_reserva, alojamiento WHERE id_cliente=id_usuario AND alojamiento.id_alojamiento=cliente_reserva.id_alojamiento AND nombre_usuario='" . $_SESSION['nombre_usuario'] . "' AND comentario IS NULL AND fecha_fin<='" . $fecha_actual . "'";

//Envio la consulta a MySQL.
$resultado = conexionBD($consulta);

if ($resultado) {
    echo '<table>';
    echo '<tr><th>Nombre del alojamiento</th>';
    echo '<th>Fecha inicio</th>';
    echo '<th>Fecha fin</th>';
    echo '<th></th>';
    echo '</tr>';

    while ($fila = mysql_fetch_array($resultado)) {
        echo '<tr>';
        echo '<td>' . $fila['nombre_alojamiento'] . '</td>';
        echo '<td>' . $fila['fecha_inicio'] . '</td>';
        echo '<td>' . $fila['fecha_fin'] . '</td>';
        echo '<td>' . '<button onclick="comentar_reserva(' . $fila['id_reserva'] .');" > comentar </button></td>';
        echo '</tr><tr>';
        echo '<td id="reserva_' . $fila['id_reserva'] . '"> </td> ';
//        echo $fila['nombre_alojamiento'] . " ( " . $fila['fecha_inicio'] . " / " . $fila['fecha_fin'] . ")";
//        echo '<button type="button" onclick="comentar_reserva("' . $fila['id_reserva'] .'")" />';
//        echo '<br /><div id="reserva_' . $fila['id_reserva'] . '"></div>';
        echo '</tr>';
    }
    echo '</table>';
}
?>
