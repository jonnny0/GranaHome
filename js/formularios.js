function comprueba_formulario(f) {
    if (comprueba_mail(f)) {
        if (check_password(f)) {
            return true;
        }
        
    }
    return false;
}

function check_password(f) {

    var password1 = f.contrasena2.value;
    var password2 = f.confirmarContrasena.value;
    if (password1 != password2) {
        alert("Las contraseñas no coinciden.");
        return false;
    }
    if (password1.length < 8) {
        alert("La contraseña tiene que contener al menos 8 caracteres.");
        return false;
    }
    return true;
}

/*función que comprueba el formulario de envío de mensaje*/
function comprueba_mail(f) {
    var re = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    if (!re.test(f.mail.value)) {
        alert("ERROR: Email incorrecto. Intentelo de nuevo.");
        return false;
    }
    return true;
}