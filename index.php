<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    
    <script src="https://kit.fontawesome.com/72313059bf.js" crossorigin="anonymous"></script>
    <title>Ingreso de ocntraseña</title>
</head>
<body>

    <?php
    date_default_timezone_set('America/Mexico_City');
    
    $string = file_get_contents("json/config.json");
    $config = json_decode($string, true);

    $jwt;
    $bool;

    if($_GET["usr"]){
        $jwt = $_GET["usr"];
    }else{
        echo '<script language="javascript">';
        echo 'alert("Enlace no válido")';
        echo '</script>';
    }

    if($_GET["end"]){
        $time = $_GET["end"];
        $bool = ( $time > time() ) ? true: false;
    }else{
        echo '<script language="javascript">';
        echo 'alert("Enlace no válido")';
        echo '</script>';
    }

    if($bool == false){
        echo '<script language="javascript">';
        echo 'alert("Este enlace ha expirado, comuníquese al correo ticnovation.soporte@gmail.com para que se le proporcione otro en caso no haberlo usado.")';
        echo '</script>';
    }

    ?>


    <div class="main">
    <div class="logo">
        <p>Ingrese su contraseña</p>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Una vez que ingrese la contraseña, será dirigido a la aplicación donde podrá iniciar sesión</p>
            <form id="passForm" action="" method="post">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirmar contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block" value="Enviar" disabled="true">
                    </div>
                </div>
            </form>
        </div>

    </div>

    </div>

    <script language="JavaScript" type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

    <script type="text/javascript">

        $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val() && $('#password').val().trim().length > 5) {
            $('#submit').prop('disabled', false);
        } else 
            $('#submit').prop('disabled', true);
        });

    </script>

    <script type="text/javascript">

    $(document).ready(function(){
            // click on button submit
        $("#passForm").submit(function(e){
            e.preventDefault();

            var bool = "<?php echo $bool ?>";
            var jwt = "<?php echo $jwt ?>"

            if(bool == true){
                var url = "<?php echo $config['url_comercio_service'] ?>";
                var redirect = "<?php echo $config['url_comerciantes'] ?>";
                var password = $("#password").val();
                let json = {
                    'password':password
                };
            // send ajax
                $.ajax({
                    url: url,
                    type : "POST",
                    dataType : 'json',
                    data : json,
                    success : function(result) {
                        window.location.href = redirect;
                    },
                    error: function(xhr, resp, text) {
                        alert(xhr.responseText);
                    },
                    beforeSend: function(xhr) {
                   xhr.setRequestHeader("Authorization", jwt);
                    },
                })

            }else{
                alert("Este enlace ha expirado, comuníquese al correo ticnovation.soporte@gmail.com para que se le proporcione otro en caso no haberlo usado.");
            }
        });
            
        });
    </script>

</body>
</html>