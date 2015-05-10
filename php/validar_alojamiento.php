<?php

include_once 'conexion_bd.php';
if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$consulta = 'UPDATE alojamiento SET id_administrador=' . $_POST['id_administrador'] . ' WHERE id_alojamiento=' . $_POST['id_alojamiento'];

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("No se ha podido validar el alojamiento.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    echo '<script>
            alert("El alojamiento ha sido validado correctamente.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
}