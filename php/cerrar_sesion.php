<?php
//unset($_SESSION['nombreUsuario']);
//unset($_SESSION['passwordUsuario']);
//unset($_SESSION['tipoUsuario']);
session_destroy();
header('Location: ../index.php?sec=buscador');
?>