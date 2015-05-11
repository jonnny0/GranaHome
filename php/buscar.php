<?php

include_once 'conexion_bd.php';

if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}

$consulta = 'SELECT alojamiento....';

echo $_POST['localidad'];
echo '<br>';
echo $_POST['fecha_entrada'];
echo '<br>';
echo $_POST['fecha_salida'];
echo '<br>';
echo $_POST['numero_habitaciones'];
echo '<br>';
echo $_POST['numero_huespedes'];
echo '<br>';
$tipo_alojamientos = $_POST['tipo_alojamientos'];
if (!empty($tipo_alojamientos)) {
    $n_tipos = count($tipo_alojamientos);
    for ($i = 0; $i < $n_tipos; $i++) {
        echo $tipo_alojamientos[$i] . "<br>";
    }
}
echo $_POST['puntuacion'];
echo '<br>';
echo $_POST['estrellas'];
echo '<br>';
if ($_POST['precio_maximo'] == "")
    echo "cualquier precio";
else
    echo $_POST['precio_maximo'];
echo '<br>';



//$consulta = 'SELECT INTO usuario (nombre_usuario, password, mail, tipo_usuario) VALUES ("'
//        . $_POST['nombre_usuario'] . '", "'
//        . $_POST['contrasena2'] . '", "'
//        . $_POST['mail'] . '", "'
//        . $_POST['tipo_usuario'] . '") ';
//
//$resultado = conexionBD($consulta);
//
//if (!$resultado) {
//    echo '<script>
//            alert("El usuario ya existe.");
//            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
//        </script>';
//} else {
//    $_SESSION['nombre_usuario'] = $_POST['nombre_usuario'];
//    $_SESSION['tipo_usuario'] = $_POST['tipo_usuario'];
//    echo '<script>
//            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
//        </script>';
//}
?>