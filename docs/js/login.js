$(document).ready(function () {
    $("#frmLogin").submit(function(e){
        e.preventDefault();

        let captcha = grecaptcha.getResponse();

        if(captcha.length === 0){
            alert("Completa el captcha");
            return;
        }

        $.ajax({
            url:"docs/php/login.php",
            type:"POST",
            data: $(this).serialize(),

            success:function(respuesta){
                alert(respuesta);

                grecaptcha.reset();
            }
        });
    });
});