<?php

include_once './conexion_bd.php';
session_start();

$consulta = 'SELECT * FROM usuario WHERE nombre_usuario="' . $_SESSION['nombre_usuario'] . '"';

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("No se ha podido actualizar el usuario.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    $fila = mysql_fetch_array($resultado);
    $id = $fila['id_usuario'];
    $consulta = 'UPDATE usuario SET nombre_usuario="' . $_POST['nombre_usuario'] . '", '
            . 'mail="' . $_POST['mail'] . '"';
    if ($_POST["password"] != "") {
        $consulta = $consulta . ', password="' . $_POST['password'] . '"';
    }
    $consulta = $consulta . ' WHERE id_usuario=' . $id;

    $resultado = conexionBD($consulta);

    if (!$resultado) {
        echo '<script>
            alert("No se ha podido actualizar el usuario.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    } else {
        $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];
        echo '<script>
            alert("Los cambios se realizaron con éxito.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    }
}
?>