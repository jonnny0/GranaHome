<!DOCTYPE html>
<html lang="es">
    <head>
        <title>GranaHome</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
        <link rel="icon" type="image/png" href="imagenes/logo.png" />
    </head>

    <body>
        <?php
        session_start();
        if (isset($_GET['sec'])) {
            $seccion = $_GET['sec'];
        } else {
            $seccion = '0';
        }
        ?>

        <!--Comienzo de la cabecera-->
        <header>
            <?php
            include('php/header.php');
            ?>
        </header>
        <!--Fin de la cabecera-->

        <!--Comienza la parte de la página-->
        <div class="contenedorPrincipal">
            <?php
            include('php/main_content.php');
            ?>
        </div>

        <!--Fin de la parte de la página-->

        <!--Comienzo del pie-->
        <br><br>
        <footer>
            <?php
            include('php/footer.php');
            ?>
        </footer>
        <!--Fin del pie-->
    </body>

</html>