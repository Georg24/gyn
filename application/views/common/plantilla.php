<!Doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GYN</title>
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/style.css">
</head>
<body>
<div class="navbar navbar-fixed-top" id="row_menu_superior">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <h1 id="logo_menu_superior">GyN</h1>
            </div>
            <div class="col-xs-9 ">
                <ul id="menu_principal" class="nav nav-pills  pull-right hidden-xs">
                    <li class="active">
                        <a href="index.php">
                            Inicio
                            <span class="badge"></span>
                        </a>
                    </li>
                    <li><a href="#">Nombre</a></li>
                    <li><a href="#">Salir</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="cont_cuerpo">
    <div class="row">
        <div class="col-sm-2">
            <?php $this->load->view('common/menu.php',$menus,$submenus);?>
        </div>
        <div class="col-sm-10 prueba" id="cont_medio">
           
        </div>
    </div>
</div>
<div class="container-fluid" id="cont_pie">
    <div class="row">

    </div>
</div>

<script src="<?= base_url();?>assets/js/jquery2.js" type="text/javascript"></script>
<script src="<?= base_url();?>assets/js/bootstrap.js" type="text/javascript"></script>
<script src="<?= base_url();?>assets/js/scripts.js" type="text/javascript"></script>
</body>
</html>
