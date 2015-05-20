<?php
include_once 'conexion_bd.php';

if (isset($_SESSION['nombre_usuario'])) {
    if($_SESSION['tipo_usuario']=="propietario"){
?>
<div id="menuOpcionesUsuario">
    <ul>
	<li>
            <a href="index.php?sec=nuevo_alojamiento">Añadir un alojamiento</a>
	</li>
	<li>
	    <a href="index.php?sec=nueva_habitacion">Añadir Habitacion</a>
	</li>
	<li>
	    <a href="index.php?sec=modificar_alojamiento">Modificar un alojamiento</a>
	</li>
	<li id="active">
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>
</div>
<?php
    } else if($_SESSION['tipo_usuario']=="cliente"){
?>
<div id="menuOpcionesUsuario">
    <ul>
	<li>
            <a href="index.php?sec=comentar">Añadir un comentario</a>
	</li>
	<li >
	    <a href="index.php?sec=ver_reservas">Ver reservas</a>
	</li>
	<li id="active">
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>
</div>
<?php
    } else if($_SESSION['tipo_usuario']=="administrador"){
        
?>
<div id="menuOpcionesUsuario">
    <ul>
	<li>
            <a href="index.php?sec=validar_alojamientos">Validar alojamientos</a>
	</li>
	<li>
	    <a href="index.php?sec=alta_administrador">Dar de alta administrador</a>
	</li>
	<li id="active">
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>

</div>
<?php
    }
echo '<br><br><br>';

    //comprobación de que el usuario exista
    $consulta = 'SELECT * FROM usuario WHERE nombre_usuario="' . $_SESSION['nombre_usuario'] . '"';

    //Envio la consulta a MySQL.
    $resultado = conexionBD($consulta);
    $fila = mysql_fetch_array($resultado);

    $usuario = $fila['nombre_usuario'];
    ?>

    <script src="js/formularios.js"></script>
    <div class="opciones_usuario modificar_datos_usuario movedown">
        <h2>Modificar datos de usuario</h2>
        <hr>
        <form  method="post" action="php/actualizar_datos_usuario.php" onsubmit="return comprueba_formulario(this)">
            <div class="izquierda">
                <label for="nombre_usuario_3">Nombre de usuario:</label>
                <br>
                <?php
                echo '<input type="text" id="nombre_usuario_3" name="nombre_usuario" maxlength="20" value="' . $fila['nombre_usuario'] . '" required />';
                ?><br><br>
                <label for="password_3">Contraseña:</label>
                <br>
                <input type="password" id="password_3" name="password" maxlength="20" />
                <br><br>
                <label for="confirmar_contrasena_3">Confirmar contraseña:</label>
                <br>
                <input type="password" id="confirmar_contrasena_3" name="confirmar_password" maxlength="20" />
                <br><br>
            </div>
            <div class="derecha">
                <label for="mail_3">E-mail:</label>
                <br>
                <?php
                echo '<input type="email" id="mail_3" name="mail"  maxlength="50" value="' . $fila['mail'] . '" required />';
                ?>
                <br><br>
                <button type="submit" title="modificar" name="modificar"> Modificar </button>
            </div>
        </form>
        <br><br><br><br><br><br><br><br><br>
    </div>
    <?php
}
?>