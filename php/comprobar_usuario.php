<?php
session_start();
$_SESSION['nombreUsuario'] = $_POST['nombreUsuario'];
$_SESSION['passwordUsuario'] = $_POST['passwordUsuario'];

//de momento para la prueba será propietario
$_SESSION['tipoUsuario'] = 'propietario';

//
//
//
//if ($_POST['nombreUsuario'] == 'pepe') {
//    echo $_POST['nombreUsuario'] . 'nombre bien<br />';
//}
//echo 'Nombre Usuario: ' . $_POST['nombreUsuario'] . '<br />';
//echo 'Password: ' . $_POST['passwordUsuario'] . '<br />';

header('Location: ../index.php?sec=buscador');
?>