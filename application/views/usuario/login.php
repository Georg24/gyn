<!Doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GYN</title>
		<link rel="shortcut icon" href="<?= base_url();?>sources/images/phplog.ico" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap-theme.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery-ui.min.css">
    </head>

    <body >
        <div class="navbar navbar-fixed-top" id="row_menu_superior">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <img src="<?php echo base_url() . 'sources/images/logo2azul.png' ?>" class="img-responsive" style="max-height: 75px">
                    </div>

                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="container-fluid" id="cont_cuerpo">


                <div class="panel panel-primary col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                    <div class="panel-heading">
                        <div class="panel-title">Inicio de Sesión</div>
                    </div>

                    <div class="panel-body">
                        <form id="login" action="<?= base_url() ?>index.php/login/ingresar" class="form-horizontal" role="form" autocomplete="off"> 
                            <div class="col-sm-12 col-md-8 col-md-offset-2 col-xs-12" style="padding-top: 15px;">
                                <label for="usuario" ><span class="glyphicon glyphicon-user"></span>Usuario</label>
                                <div class="col-md-12">
                                    <input id="inputusuario" type="text" class="form-control text-center" name="usuario" value="" placeholder="CI de usuario" required autofocus >
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 col-md-offset-2 col-xs-12" style="padding: 15px;">
                                <label for="usuario" ><span class="glyphicon glyphicon-lock"></span>Contraseña</label>
                                <div class="col-md-12">
                                    <input id="inputpassword" type="password" class="form-control text-center" name="password" value="" placeholder="contraseña del usuario" required>
                                </div>
                            </div>

                            <div class="col-md-10 col-md-offset-1">
                                <div class="col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1 ">
                                    <input type="submit" id="submitingresar"  class="btn btn-primary btn-block" value="Ingresar">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
        <div class="container-fluid" id="cont_pie">
            <?php
            //si no se ha iniciado la sesion despliega el mensaje
            if ($this->session->flashdata('mensaje')) {
                ?>
                <div class="row">
                    <div id="no_sesion" class="col-sm-6 col-sm-offset-3 text-center alert alert-warning" role="alert"><?php echo $this->session->flashdata('mensaje'); ?></div>
                </div>
<?php } ?>
            <div class="row">
                <div id="alerta" class="col-sm-6 col-sm-offset-3 text-center alert alert-danger" role="alert" style="display: none">Verifique los datos de usuario y la contraseña</div>
            </div>
        </div>

        <script src="<?= base_url(); ?>assets/js/jquery2.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>
        <script src="<?= base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).on('ready', main);
            function main()
            {   //READY    
                $('#no_sesion').delay(1400).fadeOut('slow');
                $('#inputusuario').focus();
                $('#login').submit(function (ev) {
                    ev.preventDefault();
                    $.ajax({
                        url: $('#login').attr('action'),
                        type: 'post',
                        data: $('#login').serialize(),
                        success: function (resp) {
                            if (resp === 'error')
                            {
                                $("#alerta").fadeIn('slow');
                                $("#alerta").delay(1200).fadeOut('slow');
                            } else
                            {
                                window.location.href = "<?php echo base_url() ?>index.php/inicio";
                            }
                        }
                    });

                });
            }
        </script>
    </body>
</html>