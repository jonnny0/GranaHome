<?php

include_once 'conexion_bd.php';
$error=true;
if (isset($_POST['id_reserva'])) {
    $consulta = "UPDATE cliente_reserva SET puntuacion=" . $_POST['puntuacion'] . ", "
            . "comentario='" . $_POST['comentario'] . "' WHERE id_reserva=" . $_POST['id_reserva'];

    //Envio la consulta a MySQL.
    $resultado_comentario = conexionBD($consulta);

    if ($resultado_comentario) {
        $error=false;
        echo '<script>
            alert("Se ha insertado correctamente la valoración.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
    }
} 

if($error){
    echo '<script>
            alert("No se ha podido insertar la valoración.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
}
?>