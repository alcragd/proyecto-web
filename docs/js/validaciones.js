function esNumero(n){
    if(
        a >= '0' && 
        a <= '9'
    ) return true;
    else return false;
}

function esMayuscula(l){
    if(
        l >= 'A' 
        && l <= 'Z'
    ) return true;
    else return false;
}

function esMinuscula(l){
    if(
        l >= 'a' && 
        l <= 'z'
    ) return true;
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
    let boleta = $(#boleta).val();
    let bVal = true;

    if(boleta.length() != 10)
        bVal = false;
    else if(!esNumero(boleta[0]))
        if(boleta[0] != 'P')
            bVal = false;
    else if(!esNumero(boleta[1]))
        if(
            boleta[1] != 'P' && 
            boleta[1] != 'E'
        )
            bVal = false;
    else
        for(let i = 0; i < boleta.length; i++)
            if(!esNumero(boleta[i])){
                bVal = false;
                break;
            }

    return bVal;
}

function validarNombre(){
    let nombre = $(#nombre).val();
    let nVal = true;

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
    let telefono = $(#telefono).val();
    let tVal = true;

    if(telefono.length != 10)
        tVal = false;

    else
        for(let i = 0; i < tVal.length; i++)
            if(!esNumero(telefono[i]))
                tVal = false;

    return tVal;
}

function validarCorreo(){
    let correo = $(#correo).value();
    let cVal = true;

    if(correo.lenght < 13)
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
            }

            //example@alumno.ipn.mx
            //012345678901234567890

            if(pos != (correo.length - 1 - 13))
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

function validarGenero(){
    let genero = $(#genero).val();
    let gVal = true;

    if(
        genero != "hombre" &&
        genero != "mujer"
    ) gVal = false;

    return gVal;
}

function validarPromedio(){
    let promedio = $(#promedio).val();
    let pVal = true;

    if(
        promedio.length != 4 &&
        promedio.length != 5
    )
        pVal = false;
    
    else{
        if(
            promedio[0] > '6' && 
            promedio[0] <= '9'
        ) pVal = false;
    }
}

$(document).ready(function(){
    
})