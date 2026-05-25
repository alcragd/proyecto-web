const regexBoleta = /^(?:\d{10}|P[PE]\d{8})$/;
const regexNombre = /^(?:[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:\s+[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*)$/;
const regexTelefono = /^\d{10}$/;
const regexCorreo = /^(?!\.)(?!.*\.\.)[A-Za-z0-9!#$%&'*+/=?^_`{|}~]+(?:\.[A-Za-z0-9!#$%&'*+/=?^_`{|}~]+)*@alumno\.ipn\.mx$/;
const regexCurp = /^[A-ZÁÉÍÓÚÑ]{4}\d{6}[HM][A-ZÁÉÍÓÚÑ]{5}[A-Z0-9]{2}$/;
const regexContra = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/;
const regexFechaNacimiento = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
const regexPromedio = /^(?:[6-9](?:\.\d{1,2})?|10(?:\.0{1,2})?)$/;
const regexNombreEscuela = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9][A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9\s.,'&()\-\/]{2,}$/;


function validarBoleta(){
    return regexBoleta.test($('#boleta').val().trim());
}

function validarNombre(){
    return regexNombre.test($('#nombre').val().trim());
}

function validarFechaNacimiento(){
    return regexFechaNacimiento.test($('#fechaNacimiento').val().trim());
}

function validarCurp(){
    return regexCurp.test($('#curp').val().trim());
}


function validarTelefono(){
    return regexTelefono.test($('#telefono').val().trim());
}


function validarPromedio(){
    return regexPromedio.test($('#promedio').val().trim());
}

function validarNombreEscuela(){
    const escuelaProcedencia = $('#escuelaProcedencia').val().trim();
    const nombreEscuela = $('#nombreEscuela').val().trim();

    if(escuelaProcedencia !== 'Otro'){
        return true;
    }

    return regexNombreEscuela.test(nombreEscuela);
}

function validarCorreo(){
    return regexCorreo.test($('#correo').val().trim());
}

function validarContra(){
    return regexContra.test($('#contrasena').val().trim());
}


function validarFormularioRegistro(){
    if(!validarBoleta()){
        alert('Boleta inválida');
        return false;
    }

    if(!validarNombre()){
        alert('Nombre inválido');
        return false;
    }

    if(!validarFechaNacimiento()){
        alert('Fecha de nacimiento inválida');
        return false;
    }


    if(!validarCurp()){
        alert('CURP inválida');
        return false;
    }

    if(!validarTelefono()){
        alert('Teléfono inválido');
        return false;
    }


    if(!validarPromedio()){
        alert('Promedio inválido');
        return false;
    }

    if(!validarNombreEscuela()){
        alert('Nombre de la escuela inválido');
        return false;
    }

    if(!validarCorreo()){
        alert('Correo inválido');
        return false;
    }

    if(!validarContra()){
        alert('La contraseña debe contener al menos una mayúscula, una minúscula, un dígito y un cáracter especial.');
        return false;
    }

    return true;
}