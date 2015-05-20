



<div id="detalle_habitacion" class="modalmask">
    <div class="modalbox movedown">
        <a href="" title="Cerrar" class="close">X</a>
        <h2>Detalle de habitación</h2>
        <?php
        if (isset($_GET['id_hab'])) {
            $id_habitacion = $_GET['id_hab'];
            echo $id_habitacion;
        }
        ?>
    </div>
</div>
