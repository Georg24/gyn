<!Doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GYN</title>
    <link rel="shortcut icon" href="<?= base_url();?>sources/images/phplog.ico">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/alerts/jquery.alerts.css">
</head>
<body>
<div class="navbar navbar-fixed-top" id="row_menu_superior">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-4">
                <img src="<?php echo base_url().'sources/images/logo2azul.png'?>" class="img-responsive" style="max-height: 75px">
            </div>
            <div class="col-xs-6 col-sm-8 ">
                <ul id="menu_principal" class="nav nav-pills  pull-right">
                    <li class="hidden-xs">
                        <a href="<?php echo base_url()?>index.php/inicio">
                            Inicio
                        </a>
                    </li>
                    <li class="hidden-xs"><a href=""><?php echo $this->session->userdata('nombre'); ?></a></li>
                    <li><a href="<?php echo base_url()?>index.php/login">cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

