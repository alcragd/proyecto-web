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

            success:function(res){

                if(res == "0"){
                    window.location.href = "./alumno/";

                }else if(res == "1"){
                    window.location.href = "./admin/";

                }else{
                    alert(res);
                }

                grecaptcha.reset();
            }
        });
    });
});