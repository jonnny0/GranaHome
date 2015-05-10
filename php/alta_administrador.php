<?php

?>
    <script src="js/formularios.js"></script>
    <div class="opciones_usuario modificar_datos_usuario movedown">
        <h2>Dar de alta administrador</h2>
        <hr>
        <form  method="post" action="php/actualizar_datos_usuario.php" onsubmit="return comprueba_formulario(this)">
            <div class="izquierda">
                <label for="nombreUsuario2">Nombre de usuario:</label>
                <br>
                <input type="text" id="nombreUsuario2" name="nombre_usuario" maxlength="20" required />
                <br><br>
                <label for="contrasena2">Contraseña:</label>
                <br>
                <input type="password" id="contrasena2" name="password" maxlength="20" required />
                <br><br>
                <label for="confirmar_contrasena">Confirmar contraseña:</label>
                <br>
                <input type="password" id="confirmar_contrasena" name="confirmar_password" maxlength="20" required />
                <br><br>
            </div>
            <div class="derecha">
                <label for="mail">E-mail:</label>
                <br>
                <input type="email" id="mail" name="mail"  maxlength="50" required />
                <br><br>
                <label for="tipo_usuario">Tipo usuario:</label>
                <br>
                <input type="hidden" name="tipo_usuario" value="administrador" />               
                <br><br>
                <button type="submit" title="Registrarse" name="registrarse"> Registrar </button>
            </div>
        </form>
        <br><br><br><br><br><br><br><br><br>
    </div>