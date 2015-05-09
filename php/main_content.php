<?php

switch ($seccion) {
    case 'buscador':
        include 'html/es/buscador.html';
        break;
    case 'busqueda':
        include 'html/es/busqueda.html';
        break;
    case 'alojamiento':
        include 'html/es/alojamiento.html';
        break;
    case 'opciones_usuario':
        include 'php/opciones_usuario.php';
        break;
    case 'nuevo_alojamiento':
        include 'html/es/nuevo_alojamiento.html';
        break;
    case 'modificar_alojamiento':
        include 'html/es/modificar_alojamiento.html';
        break;
    case 'modificar_datos_usuario':
        include 'html/es/modificar_datos_usuario.html';
        break;
    default:
        include 'html/eleccion.html';
        break;
}
?>