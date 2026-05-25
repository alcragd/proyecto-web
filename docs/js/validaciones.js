function esNumero(n){
    if(
        n >= '0' && 
        n <= '9'
    ) return true;
    else return false;
}

function esMayuscula(l){
    let acentos = [
        'Á','É','Í','Ó','Ú','Ñ'
    ];

    if(
        l >= 'A' 
        && l <= 'Z'
    ) return true;

    for(let i = 0; i < acentos.length; i++)
        if(l == acentos[i])
            return true;

    else return false;
}

function esMinuscula(l){
    let acentos = [
        'á','é','í','ó','ú','ñ'
    ];

    if(
        l >= 'a' && 
        l <= 'z'
    ) return true;

    for(let i = 0; i < acentos.length; i++)
        if(l == acentos[i])
            return true;

    else return false;
}

function esLetra(l){
    if(
        esMayuscula(l) || 
        esMinuscula(l)
    ) return true;
    else return false;
}

// !#$%&'*+-/=?^_`{|}~
function esImprimible(c){
    let simbolos = ['!', '#', '$', '%', '&', 
                    '\'', '*', '+', '-', '/',
                    '=', '?', '^', '_', '`',
                    '{', '|', '}', '~'
                ]
    
    let sVal = false;
    
    for(let i = 0; i < simbolos.length; i++)
        if(c == simbolos[i])
            sVal = true;
    
    return sVal;
}

function validarBoleta(){
    let boleta = $("#boleta").val();
    let bVal = true;

    if(boleta.length != 10)
        bVal = false;
    else 
    if(!esNumero(boleta[0])){
        if(
            boleta[0] != 'P' ||
            (
                boleta[1] != 'P' && 
                boleta[1] != 'E'
            )
        )
            bVal = false;

        for(let i = 2; i < boleta.length; i++)
            if(!esNumero(boleta[i])){
                bVal = false;
                break;
            }
    }
        
    else 
        for(let i = 0; i < boleta.length; i++)
            if(!esNumero(boleta[i])){
                bVal = false;
                break;
            }

    return bVal;
}

function validarNombre(){
    let nombre = $("#nombre").val();
    let nVal = true;

    if(nombre.trim().length == 0){
        nVal = false;
    }

    for(let i = 0; i < nombre.length; i++){
        if(
            !esLetra(nombre[i]) && 
            nombre[i] != ' '
        ){
            nVal = false;
            break;
        }
    }

    return nVal
}

function validarTelefono(){
    let telefono = $("#telefono").val();
    let tVal = true;

    if(telefono.length != 10)
        tVal = false;

    else
        for(let i = 0; i < telefono.length; i++)
            if(!esNumero(telefono[i]))
                tVal = false;

    return tVal;
}

function validarCorreo(){
    let correo = $("#correo").val();
    let cVal = true;

    if(correo.length < 15)
        cVal = false;
    else{
        if(correo[0] == '.') 
            cVal = false;
        else{
            let pos = 0;
            while(pos < correo.length){
                if(correo[pos] == '@')
                    break;
                if(
                    (
                        !esLetra(correo[pos]) && 
                        !esNumero(correo[pos]) &&
                        !esImprimible(correo[pos]) &&
                        correo[pos] != '.'
                    ) || 
                    (
                        correo[pos] == '.' &&
                        correo[pos - 1] == '.'
                    )
                )
                    cVal = false;

                pos++;
            }

            //example@alumno.ipn.mx
            //012345678901234567890

            if(pos != (correo.length - 14))
                cVal = false;

            if(correo[pos - 1] == '.')
                cVal = false;

            let dominio = "@alumno.ipn.mx";
            for(let i = 0; i < dominio.length; i++)
                if(correo[pos + i] != dominio[i])
                    cVal = false;
        }
    }
    
    return cVal;
}

$(document).ready(function(){
    $("#formRegistro").submit(function(e){

        if(!validarBoleta()){
            alert("Boleta inválida");
            e.preventDefault();
            return;
        }
       
        if(!validarNombre()){
            alert("Nombre inválido");
            e.preventDefault();
            return;
        }

        if(!validarTelefono()){
            alert("Teléfono inválido");
            e.preventDefault();
            return;
        }

        if(!validarCorreo()){
            alert("Correo inválido");
            e.preventDefault();
            return;
        }
    });
})