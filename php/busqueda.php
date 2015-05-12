<?php

include_once 'php/obtener_fotos_alojamiento.php';

if (!isset($_SESSION['ids_alojamientos_buscados'])){
    session_start();
}

echo '<table class="tablaBusqueda">';
foreach ($_SESSION['ids_alojamientos_buscados'] as $fila_alojamiento) {
    echo '<tr>';
        echo '<td>';
            echo '<img src="' . obtener_foto_alojamiento($fila_alojamiento['id_alojamiento']) . '" alt="Foto ' . $fila_alojamiento['nombre_alojamiento'] . '" />';
        echo '</td>';
        echo '<td class="descripcion">';
            echo '<h2> ' . $fila_alojamiento['nombre_alojamiento'] . ' <img src="imagenes/ico_estrella_4p.png" alt="4 Estrellas" /></h2>';
            echo '<i> ' . $fila_alojamiento['direccion'] . ' </i>';
            echo '<br><br>';
            echo $fila_alojamiento['descripcion_breve'];
        echo '</td>';
        echo '<td>';
            echo 'Valoración:';
            echo '8,6';
            echo '<br><br>';
            echo '<a href="index.php?sec=alojamiento" >';
                echo '<button id="masInfo" name="masInfo">Reservar</button>';
            echo '</a>';
        echo '</td>';
    echo '</tr>';
}
echo '</table>';
?>