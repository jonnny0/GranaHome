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
    default:
        include 'html/eleccion.html';
        break;
}
?>