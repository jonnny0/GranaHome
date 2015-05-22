<form method="post" action="php/buscar.php" id="formularioBusqueda" onsubmit="return verificar_buscador(this)">
    Destino:
    <input type="text" name="localidad" maxlength="50" placeholder="Ej. Granada" size="75" required autofocus/>
    <br><br>
    Fecha de entrada:
    <input type="date" id="fecha_entrada" name="fecha_entrada" value="" onchange="verificar_fecha_entrada(this,true)" required/>
    &nbsp; &nbsp;
    Fecha de salida:
    <input type="date" id="fecha_salida" name="fecha_salida" value="" onchange="verificar_fecha_salida(this,true)" required/>
    <br><br>
    Número de habitaciones:
    <input type="number" name="numero_habitaciones" min="1" max="10" value="1" required/>
    <!--<br><br>-->
    &nbsp; &nbsp;
    Número de huespedes:
    <input type="number" name="numero_huespedes" min="1" max="50" value="2" required/>

    <hr />

    Tipo de alojamiento:
    <input type="checkbox" id="aloj1" name="tipo_alojamientos[]" value="hotel" onclick="verificar_tipo_alojamiento(this)" checked>
    <label for="aloj1"> Hotel </label>
    <input type="checkbox" id="aloj2" name="tipo_alojamientos[]" value="apartamento" onchange="verificar_tipo_alojamiento(this)" checked>
    <label for="aloj2"> Apartamento </label>
    <input type="checkbox" id="aloj3" name="tipo_alojamientos[]" value="pension/hostal" onchange="verificar_tipo_alojamiento(this)" checked>
    <label for="aloj3"> Pensión/Hostal </label>
    <input type="checkbox" id="aloj4" name="tipo_alojamientos[]" value="piso" onchange="verificar_tipo_alojamiento(this)" checked>
    <label for="aloj4"> Piso </label>
    <input type="checkbox" id="aloj5" name="tipo_alojamientos[]" value="casa_rural" onchange="verificar_tipo_alojamiento(this)" checked>
    <label for="aloj5"> Casa rural </label>
    <br><br>
    Puntuación mínima:
    <select name="puntuacion">
	<option value="0">Indiferente</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
    </select>
    <!--<br><br>-->
    &nbsp; &nbsp;
    Estrellas: 
    <select name="numero_estrellas">
	<option value="0">Indiferente</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
    </select>
    o más
    <br>
    <hr>
    <h3>Características de la habitación</h3>
    <table>
<?php
    $consulta_caract_hab = 'SELECT * FROM caracteristica_tipo_habitacion';
    
    $resultado_caract_hab = conexionBD($consulta_caract_hab);
    
    if ($resultado_caract_hab) {
        $i_caracteristica = 0;
        while ($fila = mysql_fetch_array($resultado_caract_hab)) {
            if ($i_caracteristica%4==0) {
                echo '<tr>';
            }
            $id = $fila['id_caracteristica_tipo_habitacion'];
            $nombre = $fila['nombre_caracteristica'];
            echo '<td>';
            echo '<input type="checkbox" id="carac' . $id . '" name="caracteristicas[]" value="' . $id . '" >';
            echo '<label for="carac' . $id . '" > ' . $nombre . ' </label>';
            echo '</td>';
            $i_caracteristica++;
            if ($i_caracteristica%4==0) {
                echo '</tr>';
            }
        }
    }
    
?>
    </table>
    <br>
    
    <button type="submit" title="Buscar" name="buscar"> Buscar </button>
</form>


<?php

?>

