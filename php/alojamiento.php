<?php
include_once 'conexion_bd.php';

$consulta = 'SELECT * FROM alojamiento WHERE id_alojamiento=' . $id_alojamiento;

$resultado = conexionBD($consulta);

if (!$resultado) {
    echo '<script>
            alert("ERROR: No se ha podido mostrar el alojamiento seleccionado.");
            location.href= " ' . $_SERVER['HTTP_REFERER'] . '";
        </script>';
} else {
    $fila = mysql_fetch_array($resultado);
    echo '<h1> ' . $fila['nombre_alojamiento'] . ' imagen estrellas</h1>';
    echo '<div class="imagenAlojamiento">'
    . '</div>';
    echo '<h2> Descripción detallada</h2>';
    echo '<p class="resumen">';
    echo $fila['descripcion_detallada'];
    echo '</p>';
    echo '<h2>Habitaciones disponibles</h2>';
    echo '<table class="tablaHabitaciones">';
    echo '</table>';


    
}
?>
<hr><hr><hr>

<h1>
    Hotel Alhambra Palace
    <img src="imagenes/ico_estrella_4p.png" title="4 Estrellas" alt="4 Estrellas"/>
</h1>
<p id="direccion">
    Plaza Arquitecto García de Paredes, 1, Centro de Granada, 18009 Granada, España
</p>
<div class="imagenAlojamiento">
    <img src="imagenes/hotelAlhambraPalace.jpg" title="Hotel" alt="Hotel"/>
</div>
<h2> Descripción detallada </h2>
<p class="resumen">
    El Alhambra Palace está situado a las afueras de las antiguas murallas de la Alhambra, y ofrece unas
    vistas espectaculares a la ciudad de Granada. Dispone de habitaciones elegantes con una decoración de
    inspiración árabe, conexión Wi-Fi gratuita y TV vía satélite.
    <br/><br/>
    El hotel cuenta con un restaurante a la carta que sirve comida andaluza. También hay un bar con una
    terraza con unas vistas impresionantes a Granada y a Sierra Nevada.
    <br/><br/>
    La recepción del Hotel Alhambra Palace está abierta las 24 horas. Hay un cajero automático en el hotel,
    así como servicio de cambio de divisa. Justo enfrente del hotel encontrará una parada de autobús que le
    llevará al centro de la ciudad o a la Alhambra.
    <br/><br/>
    La Alhambra está a menos de 10 minutos a pie, a través de una pequeña zona boscosa. Este hotel se
    encuentra de 10 minutos a pie del barrio árabe medieval del Albayzín, declarado Patrimonio de la
    Humanidad por la UNESCO.
    <br/><br/>
    Centro de Granada es una opción genial para los viajeros interesados en compras, comida y historia.
</p>
<h2>Habitaciones disponibles</h2>
<table class="tablaHabitaciones">
    <tr>
        <td class="negrita">
            Nombre:
        </td>
        <td>
            Prometeus
        </td>
    </tr>
    <tr>
        <td class="negrita separacion">
            Capacidad:
        </td>
        <td class="separacion">
            1 Persona
        </td>
        <td class="negrita separacion">
            Precio:
        </td>
        <td class="separacion">
            30€
        </td>
        <td class="negrita separacion">
            Número Habitaciones:
        </td>
        <td class="separacion">
            <select name="numeroHabitaciones" id="NumeroHabitaciones">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </td>
    </tr>


    <tr>
        <td class="negrita">
            Nombre:
        </td>
        <td>
            Zeus
        </td>
    </tr>
    <tr>
        <td class="negrita separacion">
            Capacidad:
        </td>
        <td class="separacion">
            2 Personas
        </td>
        <td class="negrita separacion">
            Precio:
        </td>
        <td class="separacion">
            50€
        </td>
        <td class="negrita separacion">
            Número Habitaciones:
        </td>
        <td class="separacion">
            <select name="numeroHabitaciones2" id="NumeroHabitaciones2">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </td>
    </tr>

    <tr>
        <td class="negrita">
            Nombre:
        </td>
        <td>
            Atenea
        </td>
    </tr>
    <tr>
        <td class="negrita separacion">
            Capacidad:
        </td>
        <td class="separacion">
            3 Persona
        </td>
        <td class="negrita separacion">
            Precio:
        </td>
        <td class="separacion">
            80€
        </td>
        <td class="negrita separacion">
            Número Habitaciones:
        </td>
        <td class="separacion">
            <select name="numeroHabitaciones3" id="NumeroHabitaciones3">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

        </td>
    </tr>

    <tr>
        <td class="negrita">
            Nombre:
        </td>
        <td>
            Ariel
        </td>
    </tr>
    <tr>
        <td class="negrita separacion">
            Capacidad:
        </td>
        <td class="separacion">
            4 Persona
        </td>
        <td class="negrita separacion">
            Precio:
        </td>
        <td class="separacion">
            100€
        </td>
        <td class="negrita separacion">
            Número Habitaciones:
        </td>
        <td class="separacion">
            <select name="numeroHabitaciones4" id="NumeroHabitaciones4">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><button id="reservar" name="reservar">Reservar</button></td>
    </tr>
</table>

<h2>Características</h2>
<table class="tablaCaracteristicas">
    <tr>
        <td class="negrita">
            Wifi Gratis:
        </td>
        <td>
            Si
        </td>
        <td class="negrita">
            Piscina:
        </td>
        <td>
            Si
        </td>
        <td class="negrita">
            Recepción 24H:
        </td>
        <td>
            Si
        </td>
        <td class="negrita">
            Aire Acondicionado:
        </td>
        <td>
            Si
        </td>
    </tr>
    <tr>
        <td class="negrita">
            Terraza:
        </td>
        <td>
            Si
        </td>
        <td class="negrita">
            Barbacoa:
        </td>
        <td>
            No
        </td>
        <td class="negrita">
            Cocina:
        </td>
        <td>
            No
        </td>
        <td class="negrita">
            Caja fuerte:
        </td>
        <td>
            Si
        </td>
    </tr>
</table>
<h2>Comentarios</h2>
<table>
    <tr>
        <td class="negrita">
            Manuel &nbsp;&nbsp;&nbsp;&nbsp; Valoración: 7.2
        </td>
    </tr>
    <tr>
        <td>
            El hotel es una maravilla, la gente es muy amable. 
            Las habitaciones están muy limpias.
            La ubicación es espectacular. Bonitas Vistas del atardecer en la terraza, alejados del ruido de la ciudad y con fácil acceso en coche tanto para llegar como para salir.
        </td>
    </tr>

    <tr>
        <td class="negrita">
            <br>Laura &nbsp;&nbsp;&nbsp;&nbsp; Valoración: 6.2
        </td>
    </tr>
    <tr>
        <td>
            No hay parking. Sin embargo el personal me encontro un hueco en la plaza. Fueron muy amables.
        </td>
    </tr>


</table>