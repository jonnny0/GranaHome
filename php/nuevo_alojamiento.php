<?php
include_once 'php/conexion_bd.php';
if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}
?>
<div class="opciones_usuario insertar_alojamiento movedown">
    <h2>Datos para insertar un nuevo alojamiento</h2>
    <hr/>
    <form method="post" action="php/insertar_alojamiento.php">
        <label for="nombre_alojamiento">Nombre del alojamiento: </label>
        <input type="text" size="60" id="nombre_alojamiento" name="nombre_alojamiento" maxlength="50" required />
        <br><br>
        <label for="direccion">Dirección: </label>
        <input type="text" size="75" id="direccion" maxlength="100" name="direccion" required/>
        <br><br>
        <label for="localidad">Localidad: </label>
        <input type="text" id="localidad" maxlength="50" name="localidad" required/>
        &nbsp;&nbsp;
        <label for="telefono">Telefono de contacto: </label>
        <input type="number" max="999999999" id="telefono" name="telefono" required/>
        <br><br>
        <label for="tipo_alojamiento">Tipo Alojamiento: </label>
        <select name="tipo_alojamiento" id="tipo_alojamiento" onchange="validar_tipo_alojamiento(this)">
            <option value="hotel">Hotel</option>
            <option value="apartamento">Apartamento</option>
            <option value="pension/hostal">Pension/Hostal</option>
            <option value="piso">Piso</option>
            <option value="casa_rural">Casa Rural</option>
        </select>

        &nbsp;&nbsp;
        <p id="precio"></p>
        <!--	Estas dos lineas aparecen cuando se marca Piso o Casa Rural  -->
        <!--	<label for="precio_noche">Precio por noche: </label>
                <input type="number" step="any" id="precio_noche" name="precio" required/>-->

        <br><br>
        <label for="descripcion_breve">Descripción breve (Máximo 200 caracteres): </label>
        <br>
        <textarea id="descripcion_breve" cols="85" rows="2" maxlength="200" name="descripcion_breve" required></textarea>
        <br><br>
        <label for="descripcion_detallada">Descripción detallada (Máximo 1000 caracteres): </label>
        <br>
        <textarea id="descripcion_detallada" cols="85" rows="8" maxlength="1000" name="descripcion_detallada" required></textarea>
        <br><br>
        <hr/>
        <h3> Características </h3>
        <?php
        $consulta = 'SELECT * FROM caracteristica_alojamiento';

        $resultado = conexionBD($consulta);

        if ($resultado) {
            while ($fila = mysql_fetch_array($resultado)) {
                $id_caract = $fila['id_caracteristica_alojamiento'];
                $nombre_caract = $fila['nombre_caracteristica'];
                echo '<input type="checkbox" id="caract' . $id_caract . '" name="caracteristica_alojamiento[]" value="' . $id_caract . '">';
                echo '<label for="caract' . $id_caract . '">' . $nombre_caract . '</label>';
                echo '<br/>';
            }
        }
        ?>
        <br/>
        <button type="submit" title="Añadir Alojamiento" name="add_alojamiento"> Añadir Alojamiento </button>
    </form>
</div>