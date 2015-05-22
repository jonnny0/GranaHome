function comprueba_formulario(f) {
    if (comprueba_mail(f)) {
        if (check_password(f)) {
            return true;
        }

    }
    return false;
}

function check_password(f) {

    var password1 = f.password.value;
    var password2 = f.confirmar_password.value;
    if (password1 != password2) {
        alert("Las contraseñas no coinciden.");
        return false;
    }
    if (password1.length == 0) {
        return true;
    }
    if (password1.length < 8) {
        alert("La contraseña tiene que contener al menos 8 caracteres.");
        return false;
    }
    return true;
}

/*función que comprueba si el email está bien formado o no*/
function comprueba_mail(f) {
    var re = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    if (!re.test(f.mail.value)) {
        alert("ERROR: Email incorrecto. Intentelo de nuevo.");
        return false;
    }
    return true;
}

function validar_tipo_alojamiento(select) {
    if (select.value == "piso" || select.value == "casa_rural") {
        document.getElementById("num_estrellas").innerHTML = '';
        document.getElementById("capacidad_y_precio").innerHTML = ''
                + '<label for="precio_noche">Precio por noche: </label>'
                + '<input type="number" step="any" min="1" max="9999" id="precio_noche" name="precio" required/>'
                + '&nbsp;&nbsp;'
                + '<label for="capacidad">Capacidad: </label>'
                + '<input type="number" min="1" max="50" id="capacidad" name="capacidad" required/>'
                + '<br>';
    } else {
        document.getElementById("capacidad_y_precio").innerHTML = '';
        document.getElementById("num_estrellas").innerHTML = ''
                + '<label for="numero_estrellas">Numero de Estrellas </label>'
                + '<input type="number" min="1" max="5" id="numero_estrellas" name="numero_estrellas" required/>'
    }
    actualizar_precio();
}

function comprueba_formulario_tipo_habitacion(formulario) {
    var correcto;
    if (formulario.alojamiento_seleccionado.value != -1) {
        correcto = true;
    } else {
        alert("Tienes que seleccionar un alojamiento.");
        correcto = false;
    }
    return correcto;
}

function cambiar_un_dia_mas(fecha_a_cambiar, fecha_actual) {
    var next_day = fecha_actual;
    next_day.setDate(fecha_actual.getDate() + 1);

    var next_day_str = next_day.getFullYear() + "-";
    if (next_day.getMonth() + 1 < 10) {
        next_day_str += "0";
    }
    next_day_str += (next_day.getMonth() + 1) + "-";
    if (next_day.getDate() < 10) {
        next_day_str += "0";
    }
    next_day_str += next_day.getDate();
//        document.getElementById("fecha_salida").setAttribute('value', next_day_str);
    document.getElementById(fecha_a_cambiar).value = next_day_str;
}

function verificar_fecha_entrada(fecha) {
    return verificar_fecha_entrada(fecha, false);
}

function verificar_fecha_entrada(fecha, cambiar) {
    var fecha_actual = new Date();
    var fecha_entrada = new Date(fecha.value);
    if (fecha_entrada < fecha_actual) {
        alert("La fecha tiene que ser posterior a hoy");
        cambiar_un_dia_mas("fecha_entrada", fecha_actual);
        cambiar_un_dia_mas("fecha_salida", new Date(fecha.value));
        return false;
    } else if (cambiar) {
        var fecha_salida_value = document.getElementById("fecha_salida").value;
        if (fecha_salida_value !== "") {
            var fecha_salida = new Date(fecha_salida_value);
            if (fecha_entrada >= fecha_salida) {
                cambiar_un_dia_mas("fecha_salida", fecha_entrada);
            }
        } else {
            cambiar_un_dia_mas("fecha_salida", fecha_entrada);
        }
    }
    return true;
}

function verificar_fecha_salida(fecha) {
    return verificar_fecha_salida(fecha, false);
}

function verificar_fecha_salida(fecha, cambiar) {
    var fecha_entrada = document.getElementById("fecha_entrada");
    var fecha_entrada_date = new Date(fecha_entrada.value);
    var fecha_introducida = new Date(fecha.value);
    if (fecha_introducida < fecha_entrada_date) {
        alert("La fecha tiene que ser posterior a la de entrada");
        if (cambiar) {
            cambiar_un_dia_mas("fecha_salida", fecha_entrada_date);
        }
        return false;
    } else if (fecha.value == "") {
        cambiar_un_dia_mas("fecha_salida", fecha_introducida);
    }
    return true;
}

function verificar_buscador(formulario) {
    var correcto = verificar_fecha_entrada(formulario.fecha_entrada);
    if (correcto) {
        correcto = verificar_fecha_salida(formulario.fecha_salida);
    }
    return correcto;
}

function verificar_tipo_alojamiento(checkbox) {
    var tipo_alojamientos = document.getElementsByName(checkbox.name);
    var n_checked = 0;
    for (var i = 0; i < tipo_alojamientos.length; i++) {
        if (tipo_alojamientos[i].checked) {
            n_checked++;
        }
    }
    if (n_checked == 0) {
        alert("Al menos tiene que haber un tipo de alojamiento marcado.");
        checkbox.checked = true;
    }
}

function add_campos_imagenes(select) {
    var campos = '';
    for (var i = 1; i < select.value; i++) {
        campos += '<br>'
                + '<label for="foto' + i + '"> Introduce el nombre de la imagen ' + (i + 1) + ': </label>'
                + '<input type="file" id="foto' + i + '" name="foto' + i + '" maxlength = "50" size = "50" required />'
                + '<br>';
    }
    document.getElementById("mas_imagenes").innerHTML = campos;
}

function actualizar_precio_reserva(n_habitaciones) {
    var precio = 0.0;
    for (var i = 0; i < n_habitaciones; i++) {
        precio += parseFloat(document.getElementById("numero_habitaciones_" + i).value);
    }
    document.getElementById("precio_total").innerHTML = precio + " €";
}

function cambiar_foto_principal(nueva) {
    var foto = document.getElementById("foto_principal");
    foto.src = nueva.src;
}

function comentar_reserva(id_reserva) {
//    var formulario1 = '<form action="php/registrar_comentario.php" method="post">';
    formulario1 = '<label for="puntuacion">Puntuación: </label>'
    formulario1 += '<input type="number" min=0 max=10 id="puntuacion" name="puntuacion" maxlength="20" required />';
    var formulario2 = '<label for="comentario">Comentario:</label>'
    formulario2 += '<br /><textarea id="comentar" name="comentario" required ></textarea> ';
    formulario2 += '<input type="hidden" name="id_reserva" value="' + id_reserva + '" />';
    var formulario3 = '<button type="submit" title="Añadir valoración" name="anadir_valoracion"> Añadir valoración </button>';
//    formulario3 += '</form>';
    document.getElementById("reserva_"+id_reserva+"_izq").innerHTML = formulario1;
    document.getElementById("reserva_"+id_reserva+"_der").innerHTML = formulario2;
    document.getElementById("reserva_"+id_reserva+"_bot").innerHTML = formulario3;
}

function cambiar_foto_habitacion_principal(nueva) {
    var foto = document.getElementById("foto_habitacion_principal");
    foto.src = nueva.src;
}