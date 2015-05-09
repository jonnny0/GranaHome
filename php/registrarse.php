<?php

include './conexion_bd.php';
session_start();

$consulta = 'INSERT INTO usuario (nombre_usuario, password, mail, tipo_usuario) VALUES ("'
        . $_POST['nombre'] . '", "'
        . $_POST['contrasena2'] . '", "'
        . $_POST['mail'] . '", "'
        . $_POST['tipoUsuario'] . '") ';

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("El usuario ya existe.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    $_SESSION['nombre_usario'] = $_POST['nombre_usuario'];
    $_SESSION['tipo_usuario'] = $_POST['tipo_usuario'];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>