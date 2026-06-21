$(document).ready(function () {
    $("#frmLogin").submit(function(e){
        e.preventDefault();

        if(!validarFormularioLogin()) return; 

        let captcha = grecaptcha.getResponse();

        // if(captcha.length === 0){
        //     alert("Completa el captcha");
        //     return;
        // }

        $.ajax({
            url:"docs/php/login.php",
            type:"POST",
            data: $("#frmLogin").serialize(),

            success:function(respuesta){
                let res = respuesta.trim();
                if(res == "0"){
                    window.location.href = "./alumno/index.php";

                }else if(res == "1"){
                    window.location.href = "./admin/index.php";

                }else{
                    alert(res);
                }

                grecaptcha.reset();
            }
        });
    });
});