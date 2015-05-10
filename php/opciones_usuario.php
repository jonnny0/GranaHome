<?php

if (isset($_SESSION['nombre_usuario'])) {
    if ($_SESSION['tipo_usuario'] == "propietario") {
        include 'html/es/opciones_propietario.html';
    } else if ($_SESSION['tipo_usuario'] == "cliente") {
        include 'html/es/opciones_cliente.html';
    } else if ($_SESSION['tipo_usuario'] == "administrador") {
        include 'html/es/opciones_administrador.html';
    }
}
?>