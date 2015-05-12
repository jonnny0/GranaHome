<?php

include_once 'conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

echo $_POST['localidad'];
echo '<br>';
echo $_POST['fecha_entrada'];
echo '<br>';
echo $_POST['fecha_salida'];
echo '<br>';
echo $_POST['numero_habitaciones'];
echo '<br>';
echo $_POST['numero_huespedes'];
echo '<br>';
$tipo_alojamientos = $_POST['tipo_alojamientos'];
if (!empty($tipo_alojamientos)) {
    $n_tipos = count($tipo_alojamientos);
    for ($i = 0; $i < $n_tipos; $i++) {
        echo $tipo_alojamientos[$i] . "<br>";
    }
}
echo $_POST['puntuacion'];
echo '<br>';
echo $_POST['estrellas'];
echo '<br>';
if ($_POST['precio_maximo'] == "") {
    echo "cualquier precio";
} else {
    echo $_POST['precio_maximo'];
}
echo '<br>';

$consulta_alojamientos = "SELECT * FROM (
    SELECT `id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`,`tipo_alquiler_completo`  AS 'tipo_alquiler'
    FROM `alojamiento`, `alquiler_completo` WHERE `alojamiento`.`id_alojamiento`=`alquiler_completo`.`id_alojamiento_completo`
    AND (`tipo_alquiler_completo` = 'casa_rural' OR `tipo_alquiler_completo`='piso')

    UNION

    SELECT `id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`, `tipo_alquiler_habitacion` AS 'tipo_alquiler'
    FROM `alojamiento`, `alquiler_habitaciones` WHERE `alojamiento`.`id_alojamiento`=`alquiler_habitaciones`.`id_alojamiento_habitaciones`
    AND (`tipo_alquiler_habitacion` = 'hotel' OR `tipo_alquiler_habitacion`='apartamento' OR `tipo_alquiler_habitacion`='pension/hostal')
) AS `tabla_alojamientos`
WHERE `localidad`='granada'";

$resultado_alojamientos = conexionBD($consulta_alojamientos);

$lista_ids = [];
while ($fila_alojamiento = mysql_fetch_array($resultado_alojamientos)) {
    array_push($lista_ids, $fila_alojamiento);
};

$_SESSION['ids_alojamientos_buscados'] = $lista_ids;

header('Location: ../index.php?sec=busqueda');

//if (!$resultado_alojamientos) {
//    echo '<script>
//            alert("Error en la busqueda.");
//        </script>';
//} else {
//    echo '<table class="tablaBusqueda">';
//    while ($fila_alojamiento = mysql_fetch_array($resultado_alojamientos)) {
//        echo '<tr>';
//	echo '<td>';
//	    echo '<img src="imagenes/alhambra_palace.jpg" alt="Alhambra Palace" />';
//	echo '</td>';
//	echo '<td class="descripcion">';
//	    echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' <img src="imagenes/ico_estrella_4p.png" alt="4 Estrellas" /></h2>';
//	    echo '<i>Plaza Arquitecto García de Paredes, 1, 18009 Granada, España</i>';
//	    echo '<br><br>';
//	    echo $fila_alojamiento['descripcion_breve'];
//	echo '</td>';
//	echo '<td>';
//	    echo 'Valoración:';
//	    echo '8,6';
//	    echo '<br><br>';
//	    echo '<a href="index.php?sec=alojamiento" >';
//		echo '<button id="masInfo" name="masInfo">Reservar</button>';
//	    echo '</a>';
//	echo '</td>';
//    echo '</tr>';
//    }
//    echo '</table>';
//}
?>