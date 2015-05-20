<?php

include_once 'php/obtener_fotos_alojamiento.php';

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
if (!isset($_SESSION['ids_alojamientos_buscados'])) {
    echo '<script>
            location.href= "index.php";
        </script>';
}

echo '<div id="menuOrdenarPor">';
echo '<ul>';
echo '<li id="titulo">Ordenar Por:</li>';
if ($_SESSION['orden_busqueda'] == "puntuacion") {
    echo '<li id="active" onclick="">Valoración</li>';
} else {
    echo '<li onclick="">Valoración</li>';
}
if ($_SESSION['orden_busqueda'] == "estrellas") {
    echo '<li id="active" onclick="">Estrellas</li>';
} else {
    echo '<li onclick="">Estrellas</li>';
}
if ($_SESSION['orden_busqueda'] == "precio") {
    echo '<li id="active" onclick="">Precio</li>';
} else {
    echo '<li onclick="">Precio</li>';
}
echo '</ul>';
echo '</div>';
echo '<br class="clearfloat"/>';

echo '<table class="tablaBusqueda">';
foreach ($_SESSION['ids_alojamientos_buscados'] as $fila_alojamiento) {
    echo '<tr>';
    echo '<td class="centrado_horizontal">';
    echo '<img src="' . obtener_foto_alojamiento($fila_alojamiento['id_alojamiento']) . '" alt="Foto ' . $fila_alojamiento['nombre_alojamiento'] . '" />';
    echo '</td>';
    echo '<td class="descripcion">';
    if ($fila_alojamiento['tipo_alquiler'] == 'piso' || $fila_alojamiento['tipo_alquiler'] == 'casa_rural') {
        echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' </h2>';
    } else {
        echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' <img src=' . obtener_imagen_estrellas($fila_alojamiento['id_alojamiento']) . ' /></h2>';
    }
    echo '<i> ' . $fila_alojamiento['direccion'] . ', ' . $fila_alojamiento['localidad'] . ' </i>';
    echo '<br><br>';
    echo $fila_alojamiento['descripcion_breve'];
    echo '</td>';
    echo '<td class="texto_centrado">';
    switch ($fila_alojamiento['tipo_alquiler']) {
        case "apartamento":
            echo '<i>(Apartamento)</i>';
            break;
        case "casa_rural":
            echo '<i>(Casa Rural)</i>';
            break;
        case "hotel":
            echo '<i>(Hotel)</i>';
            break;
        case "pension/hostal":
            echo '<i>(Pensión - Hostal)</i>';
            break;
        case "piso":
            echo '<i>(Piso)</i>';
            break;
        default:
            break;
    }
    echo '<br><br>';
    echo 'Valoración<br/>';
    echo number_format($fila_alojamiento['puntuacion'], 2);
    echo '<br><br>';
    echo '<a href="index.php?sec=alojamiento&aloj=' . $fila_alojamiento['id_alojamiento'] . '" >';
    echo '<button type="submit" id="masInfo" name="masInfo">Reservar</button>';
    echo '</a>';
    echo '</td>';
    echo '</tr>';
}
echo '</table>';
?>