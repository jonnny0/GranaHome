
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
    <a href="busqueda.html" class="simulacionBotones">
        Volver a los resultados
    </a>
    &nbsp
    <?php
        case 'busqueda'
    ?>
    <a href="buscador.html" class="simulacionBotones">
        Volver al buscador
    </a>
    <?php
    }
    ?>
</div>
<!--Fin de Botones para Volver Atras-->

<!--Botones de Identificación y Opciones de Cuenta-->
<div id="identificacion">
    <a href="#IniciarSesion" class="simulacionBotones">
        Iniciar Sesión
    </a>
    &nbsp
    <a href="#registrarse" class="simulacionBotones">
        Registrarse
    </a>
    <?php
    include 'html/es/iniciar_sesion.html';
    include 'html/es/registrarse.html';
    ?>
</div>
<!--Fin de Botones de Identificación y Opciones de Cuenta-->

<br class="clearfloat"/>
<hr noshade="noshade"/>