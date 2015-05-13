<?php

include_once 'php/obtener_fotos_alojamiento.php';

if (!isset($_SESSION['ids_alojamientos_buscados'])){
    session_start();
}

echo '<div id="menuOrdenarPor">';
    echo '<ul>';
	echo '<li id="titulo">Ordenar Por:</li>';
        echo '<li id="active" onclick="">Valoración</li>';
        echo '<li onclick="">Estrellas</li>';
        echo '<li onclick="">Precio</li>';
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
        if($fila_alojamiento['tipo_alquiler'] == 'piso' || $fila_alojamiento['tipo_alquiler'] == 'casa_rural'){
            echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' </h2>';
        }else{
            echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' <img src="imagenes/ico_estrella_4.png" alt="4 Estrellas" /></h2>';
        }
            echo '<i> ' . $fila_alojamiento['direccion'] . ', '  . $fila_alojamiento['localidad'] . ', España </i>';
            echo '<br><br>';
            echo $fila_alojamiento['descripcion_breve'];
        echo '</td>';
        echo '<td class="texto_centrado">';
            echo 'Valoración<br/>';
            echo number_format($fila_alojamiento['puntuacion'],2);
            echo '<br><br>';
            echo '<a href="index.php?sec=alojamiento&aloj=' . $fila_alojamiento['id_alojamiento'] . '" >';
                echo '<button type="submit" id="masInfo" name="masInfo">Reservar</button>';
            echo '</a>';
        echo '</td>';
    echo '</tr>';
}
echo '</table>';
?>