<div id="menuOpcionesUsuario">
    <ul>
	<li id="active">
            <a href="index.php?sec=nuevo_alojamiento">Añadir un alojamiento</a>
	</li>
	<li>
	    <a href="index.php?sec=nueva_habitacion">Añadir Habitacion</a>
	</li>
	<li>
	    <a href="index.php?sec=modificar_alojamiento">Modificar un alojamiento</a>
	</li>
	<li>
	    <a href="index.php?sec=modificar_datos_usuario">Modificar datos usuario</a>
	</li>
    </ul>
</div>
<br><br><br>
<?php
include_once 'php/conexion_bd.php';
if (!isset($_SESSION['nombre_usuario'])) {
    session_start();
}
?>
<div class="opciones_usuario insertar_alojamiento movedown">
    <h2>Datos para insertar un nuevo alojamiento</h2>
    <hr/>
    <form method="post" enctype="multipart/form-data" action="php/insertar_alojamiento.php">
        <label for="tipo_alojamiento">Tipo Alojamiento: </label>
        <select name="tipo_alojamiento" id="tipo_alojamiento" onchange="validar_tipo_alojamiento(this)">
            <option value="hotel">Hotel</option>
            <option value="apartamento">Apartamento</option>
            <option value="pension/hostal">Pension/Hostal</option>
            <option value="piso">Piso</option>
            <option value="casa_rural">Casa Rural</option>
        </select>
        
        <p id="num_estrellas">
            <label for="numero_estrellas">Numero de Estrellas </label>
            <input type="number" min="1" max="5" id="numero_estrellas" name="numero_estrellas" required/>
        </p>
        <p id="capacidad_y_precio"></p>

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
        <input type="number" min="100000000" max="999999999" id="telefono" name="telefono" required/>
        <br><br>
        <label for="num_fotos">Número de imágenes: </label>
        <select name="num_fotos" id="num_fotos" onchange="add_campos_imagenes(this)">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br>
        <label for="foto0">Introduce el nombre de la imagen 1: </label>
        <input type="file" id="foto0" name="foto0" required/>
        <br /><br />
        <label for="descripcion0">Introduce la descripción para la imagen 1:</label>
        <br />
        <textarea id="descripcion_foto" cols="85" rows="2" maxlength="150" name="descripcion_foto" required></textarea>
        <div id='mas_imagenes'></div>
        <br>
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