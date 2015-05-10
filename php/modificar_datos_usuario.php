<?php
include_once 'conexion_bd.php';

if (isset($_SESSION['nombre_usuario'])) {

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