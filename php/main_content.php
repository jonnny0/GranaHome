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
        include 'php/nuevo_alojamiento.php';
        break;
    case 'nueva_habitacion':
        include 'php/nueva_habitacion.php';
        break;
    case 'modificar_alojamiento':
        include 'php/modificar_alojamiento.php';
        break;
    case 'modificar_datos_usuario':
        include 'php/modificar_datos_usuario.php';
        break;
    default:
        include 'html/eleccion.html';
        break;
}
?>