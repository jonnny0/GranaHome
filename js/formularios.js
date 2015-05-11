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
        document.getElementById("precio").innerHTML = '<label for="precio_noche">Precio por noche: </label>' +
                '<input type="number" step="any" id="precio_noche" name="precio" required/>';
    } else {
        document.getElementById("precio").innerHTML = "";
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

function verificar_fecha_entrada(fecha){
    return verificar_fecha_entrada(fecha, false);
}

function verificar_fecha_entrada(fecha, cambiar) {
    var fecha_actual = new Date();
    var fecha_introducida = new Date(fecha.value);
    if (fecha_introducida < fecha_actual) {
        alert("La fecha tiene que ser posterior a hoy");
        return false;
    } else if(cambiar){
        var next_day = new Date(fecha.value);
        next_day.setDate(fecha_introducida.getDate() + 1);

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
        document.getElementById("fecha_salida").value=next_day_str;
    }
    return true;
}

function verificar_fecha_salida(fecha) {
    var fecha_entrada = document.getElementById("fecha_entrada");
    var fecha_entrada_date = new Date(fecha_entrada.value);
    var fecha_introducida = new Date(fecha.value);
    if (fecha_introducida < fecha_entrada_date) {
        alert("La fecha tiene que ser posterior a la de entrada");
        return false;
    }
    return true;
}