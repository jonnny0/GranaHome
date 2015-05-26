<?php

include_once './php/epiphany/Epi.php';
include_once './php/conexion_bd.php';
include_once './php/alojamiento_cumple_condiciones_para_reservar.php';
include_once './php/obtener_fotos_alojamiento.php';
include_once './php/funciones_reservas.php';

Epi::init('api');

getRoute()->get('/', 'default_func');
getRoute()->post('/reserva/f_inicio/(\d+)/f_fin/(\d+)/hotel/(\d+)/hab/(\d+)/num/(\d+)', 'reservar_alojamiento');
getRoute()->get('/hoteles/(\w+)/f_inicio/(\d+)/f_fin/(\d+)/hab/(\d+)/huespedes/(\d+)', 'get_hoteles_disponibles');
getRoute()->get('/(\w+)', 'default_func_error');
getRoute()->run();

function default_func() {
    include_once './index_GranaHome.php';
}

function default_func_error($param) {
    http_response_code(404);
    default_func();
}

function convertir_fecha($fecha) {
    $year = substr($fecha, 0, 4);
    $month = substr($fecha, 4, 2);
    $day = substr($fecha, 6, 2);

    return ($year . "-" . $month . "-" . $day);
}

function get_hoteles_disponibles($localidad, $f_inicio, $f_fin, $n_hab, $n_huesp) {
    $fecha_inicio = convertir_fecha($f_inicio);
    $fecha_fin = convertir_fecha($f_fin);

    $consulta_hoteles = "SELECT * FROM alojamiento, alquiler_habitaciones "
            . "WHERE id_alojamiento=id_alojamiento_habitaciones AND tipo_alquiler_habitacion='hotel'";
    $resultado_hoteles = conexionBD($consulta_hoteles);
    $array_resultado = array();
    if ($resultado_hoteles) {
        while ($fila_hoteles = mysql_fetch_array($resultado_hoteles)) {
//            echo "<br>" . $fila_hoteles['nombre_alojamiento'];
            $id_alojamiento = $fila_hoteles['id_alojamiento'];
            $libre = alojamiento_habitaciones_cumple_condiciones_para_reservar($id_alojamiento, $n_hab, $n_huesp, $fecha_inicio, $fecha_fin, 0);
            if ($libre) {
//                echo " ------> SI";
                $consulta_habitacion = 'SELECT DISTINCT id_tipo_habitacion FROM habitacion WHERE id_alojamiento=' . $id_alojamiento;
                $resultado_habitacion = conexionBD($consulta_habitacion);

                if ($resultado_habitacion) {
                    $n_tipos_habitacion = 0;
                    $array_detalle_tipos = array();
                    while ($fila_tipos_habitacion = mysql_fetch_array($resultado_habitacion)) {
                        $id_tipo_habitacion = $fila_tipos_habitacion['id_tipo_habitacion'];

                        $n_habitaciones_disponibles = obtener_habitaciones_disponibles_por_tipo($id_alojamiento, $id_tipo_habitacion, $fecha_inicio, $fecha_fin);

                        if ($n_habitaciones_disponibles > 0) {

                            $consulta_tipo_habitacion = 'SELECT * FROM tipo_habitacion WHERE id_tipo_habitacion=' . $id_tipo_habitacion;
                            $resultado_tipo_habitacion = conexionBD($consulta_tipo_habitacion);

                            if ($resultado_tipo_habitacion) {
                                $fila_tipo_habitacion = mysql_fetch_array($resultado_tipo_habitacion);

//                                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;" . $fila_tipo_habitacion['nombre_tipo'] . " libres: " . $n_habitaciones_disponibles;
//                                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;capacidad: " . $fila_tipo_habitacion['capacidad'];
//                                echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;precio: " . $fila_tipo_habitacion['precio'] . "€<br>";
                                $datos_tipo = array('id_tipo' => $id_tipo_habitacion,
                                    'nombre_tipo' => $fila_tipo_habitacion['nombre_tipo'],
                                    'foto_tipo' => "http://localhost/GranaHome_php/" . obtener_foto_habitacion($id_tipo_habitacion),
                                    'n_libres' => $n_habitaciones_disponibles,
                                    'capacidad' => $fila_tipo_habitacion['capacidad'],
                                    'precio' => $fila_tipo_habitacion['precio']);
                                array_push($array_detalle_tipos, $datos_tipo);
                            }
                        }
                        $n_tipos_habitacion++;
                    }
                    $array_hotel = array('id_hotel' => $id_alojamiento,
                        'nombre_hotel' => $fila_hoteles['nombre_alojamiento'],
                        'foto_alojamiento' => "http://localhost/GranaHome_php/" . obtener_foto_alojamiento($id_alojamiento),
                        'n_habitaciones' => $n_tipos_habitacion, 'detalle_tipo' => $array_detalle_tipos);
                    array_push($array_resultado, $array_hotel);
                }
            } else {
//                echo " ------> NO";
            }
//            echo '<br>';
        }
    }
    $json = json_encode($array_resultado);
//    echo '<br>';
//    echo "Numero de hoteles: " . count($decode);
//    echo '<br>';
//    echo '<br>';
    echo $json;
//    echo '<br>';
}

function reservar_alojamiento($f_inicio, $f_fin, $id_hotel, $id_hab, $n_hab) {
    
    $exito = false;
    $usuario = $_REQUEST['usuario'];
    $id_usuario = get_id_user($usuario);
    if ($id_usuario != -1) {
        $id_reserva = reservar($id_usuario, $id_hotel, $f_inicio, $f_fin);
        if ($id_reserva != -1) {
            $exito = reservar_habitacion($id_reserva, $f_inicio, $f_fin, $id_hotel, $id_hab, $n_hab);
        }
    }
    $value = array('exito' => $exito);
    echo json_encode($value);
}

function get_id_user($usuario) {
    $consulta_usuario = "SELECT * FROM usuario WHERE nombre_usuario='" . $usuario . "'";
    $resultado_usuario = conexionBD($consulta_usuario);
    $id_usuario = -1;
    if ($resultado_usuario) {
        $id_usuario = true;
        if (mysql_num_rows($resultado_usuario) == 0) { //Usuario no existe
            $consulta_crear_usuario = "INSERT INTO usuario (nombre_usuario, password, mail, tipo_usuario) "
                    . "VALUES ('" . $usuario . "', 'GranaHome', '" . $usuario . "', 'cliente')";
            $resultado_crear_usuario = conexionBD($consulta_crear_usuario);
            if ($resultado_crear_usuario) {
                $resultado_usuario = conexionBD($consulta_usuario);
                if (!$resultado_usuario) {
                    $id_usuario = false;
                }
            } else {
                $id_usuario = false;
            }
        }
        if ($id_usuario) {
            $fila_usuario = mysql_fetch_array($resultado_usuario);
            $id_usuario = $fila_usuario['id_usuario'];
        }
    }
    return $id_usuario;
}
