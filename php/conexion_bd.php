<?php

// Recibimos como parámetro el comando SQL
function conexionBD($consulta_sql) {

    //Creamos una conexion remota
    $conexion = mysql_connect('localhost', 'root');


    //Comprobamos la conexion
    if ($conexion == FALSE) {
        echo 'Error de conexion remota con la base de datos.';
        exit();
    }

    // Abrimos Base de Datos		
    mysql_select_db('alojamientos', $conexion);

    mysql_set_charset('utf8');
    
    // Ejecutamos el código SQL
    $resultado = mysql_query($consulta_sql, $conexion);// or die(mysql_error());


    if ($resultado == FALSE) {
        echo '<br>Se siente, no se pudo realizar la operación: ' . $consulta_sql . '<br>' . mysql_error();        
    }
    
    mysql_close($conexion);

    // Devolvemos el resultado
    return $resultado;
}
?>


