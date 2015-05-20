<?php

include_once 'conexion_bd.php';
include_once 'alojamiento_cumple_condiciones_para_reservar.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$tipo_alojamientos = $_POST['tipo_alojamientos'];
$tipo_alojamientos_str = "";
if (!empty($tipo_alojamientos)) {
    $n_tipos = count($tipo_alojamientos);
    $tipo_alojamientos_str = $tipo_alojamientos_str . "`tipo_alquiler`='" . $tipo_alojamientos[0] . "'";
    for ($i = 1; $i < $n_tipos; $i++) {
        $tipo_alojamientos_str = $tipo_alojamientos_str . " OR `tipo_alquiler`='" . $tipo_alojamientos[$i] . "'";
    }
}

$consulta_alojamientos_completos = "
    SELECT `alojamiento`.`id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`,`tipo_alquiler_completo` AS 'tipo_alquiler', AVG(`puntuacion`) AS 'puntuacion'
    FROM `alojamiento`
    INNER JOIN `alquiler_completo` ON `alquiler_completo`.`id_alojamiento_completo`=`alojamiento`.`id_alojamiento`
    LEFT JOIN `cliente_reserva` ON `cliente_reserva`.`id_alojamiento`=`alojamiento`.`id_alojamiento` "
//    . " WHERE `id_administrador` IS NOT NULL "
    . " GROUP BY `id_alojamiento` ";

$consulta_alojamientos_habitaciones = "
    SELECT `alojamiento`.`id_alojamiento`, `nombre_alojamiento`, `descripcion_breve`, `direccion`, `localidad`,`tipo_alquiler_habitacion` AS 'tipo_alquiler', AVG(`puntuacion`) AS 'puntuacion'
    FROM `alojamiento`
    INNER JOIN `alquiler_habitaciones` ON `alquiler_habitaciones`.`id_alojamiento_habitaciones`=`alojamiento`.`id_alojamiento`
    LEFT JOIN `cliente_reserva` ON `cliente_reserva`.`id_alojamiento`=`alojamiento`.`id_alojamiento` "
//    . " WHERE `id_administrador` IS NOT NULL "
    . " GROUP BY `id_alojamiento` ";


$consulta_alojamientos = "SELECT * FROM ( "
        . $consulta_alojamientos_completos
        . " UNION "
        . $consulta_alojamientos_habitaciones
        . ") AS `tabla_alojamientos`"
        . "WHERE `localidad`='" . $_POST['localidad'] . "' "
        . " AND  (" . $tipo_alojamientos_str . ") ";

if ($_POST['puntuacion'] != 0) {
    $consulta_alojamientos = $consulta_alojamientos . " AND `puntuacion`>=" . $_POST['puntuacion'];
}

$consulta_alojamientos = $consulta_alojamientos . " ORDER BY `puntuacion` DESC";

$resultado_alojamientos = conexionBD($consulta_alojamientos);

$lista_ids = [];
while ($fila_alojamiento = mysql_fetch_array($resultado_alojamientos)) {
    if (alojamiento_cumple_condiciones_para_reservar($fila_alojamiento['id_alojamiento'], $fila_alojamiento['tipo_alquiler'],
            $_POST['numero_habitaciones'], $_POST['numero_huespedes'], $_POST['fecha_entrada'], $_POST['fecha_salida'], $_POST['numero_estrellas'])) {
        array_push($lista_ids, $fila_alojamiento);
    }
};

$_SESSION['ids_alojamientos_buscados'] = $lista_ids;
$_SESSION['fecha_inicio'] = $_POST['fecha_entrada'];
$_SESSION['fecha_fin'] = $_POST['fecha_salida'];
$_SESSION['orden_busqueda'] = "puntuacion";

header('Location: ../index.php?sec=busqueda');
?>