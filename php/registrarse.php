<?php

include_once './conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$consulta = 'INSERT INTO usuario (nombre_usuario, password, mail, tipo_usuario) VALUES ("'
        . $_POST['nombre_usuario'] . '", "'
        . $_POST['password'] . '", "'
        . $_POST['mail'] . '", "'
        . $_POST['tipo_usuario'] . '") ';

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("El usuario ya existe.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    if ($_POST['tipo_usuario'] != "administrador") {

        $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];
        $_SESSION['tipo_usuario'] = $_POST['tipo_usuario'];
    }
    echo '<script>
            alert("El usuario se ha creado correctamente.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
}
?>