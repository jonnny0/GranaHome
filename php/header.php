
<!--Logo-->
<div id="logo">
    <a href="index.php">
        <img src="imagenes/logo.png" title="GranaHome" alt="GranaHome"/>
    </a>
</div>
<!--Fin del Logo-->

<!--Botones para Volver Atras-->
<div id="extras">
    <?php
    switch ($seccion) {
        case 'alojamiento':
            ?>
            <a href="javascript:history.go(-1)" class="simulacionBotones">
                Volver a los resultados
            </a>
        <?php
        case 'busqueda'
            ?>
            <a href="index.php?sec=buscador" class="simulacionBotones">
                Volver al buscador
            </a>
        <?php
    }
    ?>
</div>
<!--Fin de Botones para Volver Atras-->

<!--Botones de Identificación y Opciones de Cuenta-->
<div id="identificacion">
    <?php
    if (isset($_SESSION['nombreUsuario'])) {
        echo '<a href="index.php?sec=opciones_usuario" class="simulacionBotones">'
        . 'Opciones de usuario</a>';
        echo '<a href="php/cerrar_sesion.php" class="simulacionBotones">'
        . 'Cerrar Sesión</a>';
    } else {
        echo '<a href="#IniciarSesion" class="simulacionBotones">Iniciar Sesión</a>';
        echo '<a href="#registrarse" class="simulacionBotones">Registrarse</a>';
    }
    ?>
    <?php
    include 'html/es/iniciar_sesion.html';
    include 'html/es/registrarse.html';
    ?>
</div>
<!--Fin de Botones de Identificación y Opciones de Cuenta-->



<br class="clearfloat"/>
<hr noshade="noshade"/>