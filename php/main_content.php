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
    case 'modificar_alojamiento':
        include 'php/modificar_alojamiento.php';
        break;
    case 'modificar_datos_usuario':
        include 'php/modificar_datos_usuario.php';
        break;
    case 'ver_reservas':
        include 'php/ver_reservas.php';
        break;
    case 'comentar':
        include 'php/comentar.php';
        break;
    case 'validar_alojamiento':
        include 'php/validar_alojamiento.php';
        break;
    case 'alta_administrador':
        include 'php/alta_administrador.php';
        break;
    default:
        include 'html/eleccion.html';
        break;
}

include 'html/es/recordar_password.html';
include 'html/es/usuario_encontrado.html';
include 'html/es/usuario_no_encontrado.html';
?>