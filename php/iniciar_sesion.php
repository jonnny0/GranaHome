<?php

include './conexion_bd.php';
session_start();

//comprobación de que el usuario exista
$consulta = 'SELECT * FROM usuario WHERE mail="' . $_POST['mail'] . '" AND password="' . $_POST['password'] . '"';

//Envio la consulta a MySQL.
$resultado = conexionBD($consulta);

if ($resultado) {
    if (mysql_num_rows($resultado) == 0) {
        header('Location:' . $_SERVER['HTTP_REFERER'] . '#iniciar_sesion_error');
    } else {
        $fila = mysql_fetch_array($resultado);
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['tipo_usuario'] = $fila['tipo_usuario'];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} 

?>