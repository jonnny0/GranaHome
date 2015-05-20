<?php
include_once './php/epiphany/Epi.php';

Epi::init('api');

getRoute()->get('/', 'default_func');
getRoute()->get('/hoteles', 'list_func');
getRoute()->get('/hotel', 'list_func');
getRoute()->post('/hoteles', 'metodo_post');
getRoute()->get('/reserva', 'reservar');
getRoute()->get('/hoteles/(\w+)/huespedes/(\d+)', 'list_func_parametros');
getRoute()->run();


function default_func(){
    include_once './index_GranaHome.php';
}

function list_func(){
//    return array('id' => 'Estos son los hoteles disponibles');
    echo "Estos son los hoteles disponibles";
    return "Estos son los hoteles disponibles";
}

function list_func_parametros($param, $param2){
    echo "Se pide mostrar los hoteles de " . $param . " para " . $param2 . " personas";
}

function metodo_post(){
    echo "Metodo post " . $_REQUEST['alojamiento']; 
}

function reservar(){
    $value = array('n_imgs' => 2, 'img' => array('http://localhost/GranaHome_api/imagenes/hotel_prueba2.jpg','http://localhost/GranaHome_api/imagenes/hotel_prueba.jpg'));
    echo json_encode($value);
}