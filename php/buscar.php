<?php

include_once 'conexion_bd.php';
include_once 'alojamiento_cumple_condiciones_para_reservar.php';

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
$tipo_alojamientos_str = "";
if (!empty($tipo_alojamientos)) {
    $n_tipos = count($tipo_alojamientos);
    $tipo_alojamientos_str = $tipo_alojamientos_str . "`tipo_alquiler`='" . $tipo_alojamientos[0] . "'";
    for ($i = 1; $i < $n_tipos; $i++) {
        $tipo_alojamientos_str = $tipo_alojamientos_str . " OR `tipo_alquiler`='" . $tipo_alojamientos[$i] . "'";
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
    SELECT `alojamiento`.`id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`,`tipo_alquiler_completo` AS 'tipo_alquiler', AVG(`puntuacion`) AS 'puntuacion'
    FROM `alojamiento`
    INNER JOIN `alquiler_completo` ON `alquiler_completo`.`id_alojamiento_completo`=`alojamiento`.`id_alojamiento`
    LEFT JOIN `cliente_reserva` ON `cliente_reserva`.`id_alojamiento`=`alojamiento`.`id_alojamiento`"
//    WHERE `id_administrador` IS NOT NULL
        . "GROUP BY `id_alojamiento`

    UNION

    SELECT `alojamiento`.`id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`,`tipo_alquiler_habitacion` AS 'tipo_alquiler', AVG(`puntuacion`) AS 'puntuacion'
    FROM `alojamiento`
    INNER JOIN `alquiler_habitaciones` ON `alquiler_habitaciones`.`id_alojamiento_habitaciones`=`alojamiento`.`id_alojamiento`
    LEFT JOIN `cliente_reserva` ON `cliente_reserva`.`id_alojamiento`=`alojamiento`.`id_alojamiento`"
//    WHERE `id_administrador` IS NOT NULL
        . "GROUP BY `id_alojamiento`
) AS `tabla_alojamientos`
WHERE `localidad`='" . $_POST['localidad'] . "'
AND  (" . $tipo_alojamientos_str . ") ";
if ($_POST['puntuacion'] != 0) {
    $consulta_alojamientos = $consulta_alojamientos . " AND `puntuacion`>=" . $_POST['puntuacion'];
}
$consulta_alojamientos = $consulta_alojamientos . " ORDER BY `puntuacion` DESC";

$resultado_alojamientos = conexionBD($consulta_alojamientos);

$lista_ids = [];
while ($fila_alojamiento = mysql_fetch_array($resultado_alojamientos)) {
    if (alojamiento_cumple_condiciones_para_reservar($fila_alojamiento['id_alojamiento'], $fila_alojamiento['tipo_alquiler'], $_POST['numero_huespedes'], $_POST['fecha_entrada'], $_POST['fecha_salida'])) {
        array_push($lista_ids, $fila_alojamiento);
    }
};

$_SESSION['ids_alojamientos_buscados'] = $lista_ids;

header('Location: ../index.php?sec=busqueda');
?>