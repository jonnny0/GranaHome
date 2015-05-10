<?php

include_once './conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

?>