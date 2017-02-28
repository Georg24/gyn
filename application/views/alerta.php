<div class="col-sm-10"><!--este es el contenedor principal-->
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <legend>
                    Alerta de minima en inventario
                </legend>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (sizeof($alertas) > 0) {
                    ?>    
                    <table class="table table-hover table-responsive table-bordered table-condensed text-center">
                        <thead>
                        <th>Modelo</th><th>Descripcion</th><th>Exist</th><th>Min</th><th>Ver</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($alertas as $prod) {
                                ?>
                                <tr>
                                    <td class="td-imagen"><img class="accional" src="<?php echo ($prod->imagen == "") ? base_url() . 'sources/ups/NULL' : base_url() . 'sources/ups/' . $prod->imagen; ?>" >
                                        <?= $prod->modelo ?>
                                    </td>
                                    <td><?= substr($prod->descripcion,0,28)."..." ?></td>
                                    <td class=" <?= ($prod->existencia <= $prod->minimo ) ? 'alert alert-danger' : 'alert alert-warning'; ?>">
                                        <?= $prod->existencia ?>
                                    </td>
                                    <td><?= $prod->minimo ?></td>
                                    <td><button class="btn btn-info btn-xs" onclick="modalDetalleProducto('<?php echo $prod->modelo; ?>')"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    ?>
                    <div class="alert alert-danger">
                        <p class="h4">Existencia</p>
                        <p class="h5">No hay productos prontos a alcanzar la cantidad minima</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <legend>
                    Reservas
                </legend>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"> 
                <?php
                $reservas = getReservas(); // desde helper venta
                if (sizeof($reservas) > 0) {
                    ?>    
                    <table class="table table-hover table-responsive table-bordered table-condensed text-center">
                        <thead>
                        <th>Cliente</th><th>Fecha</th><th>Imp. total</th><th>Dias</th><th>Detalle</th><th class="text-center">X</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($reservas as $res) {
                                ?>
                                <tr>
                                    <td><?= $res->cliente ?></td>
                                    <td><?= $res->fecha ?></td>
                                    <td><?= $res->total ?></td>
                                    <td><?php
                                        //calculo de los dias que pasaron desde la reserva
                                        $fecha = new DateTime($res->fecha);
                                        $actual = new DateTime(date('Y-m-d'));
                                        echo $actual->diff($fecha)->format('%a'); //mostrar los dias 
                                        ?>
                                    </td>
                                    <td><button class="btn btn-info btn-xs" onclick="verDetalleReserva('<?php echo $res->cod_venta; ?>', '<?php echo $res->cliente; ?>')"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                    <td><button class="btn btn-danger btn-xs" onclick="eliminarReserva('<?php echo $res->cod_venta; ?>', '<?php echo $res->cliente; ?>')"><span class="glyphicon glyphicon-trash"></span></button></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    ?>
                    <div class="alert alert-info">
                        <p class="h4">Preventa</p>
                        <p class="h5">No hay Reservas/Preventas en almacenamiento</p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <legend>
                    Clientes Habituales
                </legend>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"> 
                <?php
                $clientes = getFaltaClientesHabituales(); // desde helper venta
                if (sizeof($clientes) > 0) {
                    ?>    
                    <table class="table table-hover table-responsive table-bordered table-condensed text-center">
                        <thead>
                        <th>Cliente</th><th>Ultima fecha</th><th>Dias</th><th>Detalle</th>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($clientes as $res) {
                                ?>
                                <tr>
                                    <td><?= $res->nombre ?></td>
                                    <td><?= $res->fecha ?></td>
                                    <td><?php
                                        //calculo de los dias que pasaron desde la reserva
                                        $fecha = new DateTime($res->fecha);
                                        $actual = new DateTime(date('Y-m-d'));
                                        echo $actual->diff($fecha)->format('%a'); //mostrar los dias 
                                        ?>
                                    </td>
                                    <td><button class="btn btn-info btn-xs" onclick="mostrarDetalleCliente(<?php echo $res->id_cliente . ",'" . $res->nombre . " " . $res->paterno . "'"; ?>)"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else {
                    ?>
                    <div class="alert alert-warning">
                        <p class="h4">Clientes</p>
                        <p class="h5">No se ha detectado la ausencia de clientes habituales</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal del producto -->
<div id="detalle_producto" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-success" id="myModalLabel">Modelo&nbsp;<span class="text-success" id="span_titulo_prod"></span></h3>
            </div>
            <div class="modal-body" id="body_detalle_producto">
                <!--Aqui se muestra el load de la funcion modalDetalleProducto-->
            </div>
            <div class="modal-footer">
                <?php if (is_admin()) { ?>
                <button class="btn btn-warning btn-sm" onclick="desactivarProducto()">Desactivar&nbsp;<span class="glyphicon glyphicon-minus-sign"></span></button>
                <?php } ?>
                <button type="button" class="btn btn-danger btn-sm " data-dismiss="modal" id="btn_cancelar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal del reserva -->
<div id="detalle_reserva" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel"><span class="text-success" id="span_cod_reserva">Venta</span></h3>
                <span class="text-primary h3" id="span_cliente_reserva">Cliente</span><button type="button" class="btn btn-primary btn-sm pull-right" id="btn_verReservaPdf">Ver PDF</button>
            </div>
            <div class="modal-body" id="body_detalle_reserva">
                <!--Aqui se muestra el load de la funcion VerDetalleVenta-->
            </div>
            <div class="modal-footer">
                <div class="form-group pull-left col-sm-6" style="margin-bottom: 0px;">
                    <label class="col-sm-3 pull-left h4">Bs.-</label>
                    <input id="tot_reserva" type="text" class="form-control" value="0" disabled style="width: 30%;font-size: 20px;text-align: center;width: 150px;">
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <button type="button" class="btn btn-danger " data-dismiss="modal" id="btn_cancelar">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn_hacerEfectiva">&nbsp;&nbsp;Efectiva&nbsp;&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal del Cliente habitual -->
<div id="detalle_cliente" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel"><span class="text-success" id="span_titulo_cliente"></span></h3>
            </div>
            <div class="modal-body" id="body_detalle_cliente">
                <!--Aqui se muestra el load de la funcion mostrarDetalleCliente-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger " data-dismiss="modal" id="btn_cancelar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</div>
</div><!--cierre de row y container fluid--> 
<div class="container-fluid" id="cont_pie">
    <div class="row">

    </div>
</div>

<script src="<?= base_url(); ?>assets/js/jquery2.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/bootstrap.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/jquery.base64.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/alerts/jquery.alerts.js" type="text/javascript"></script>
<script>
                    $(document).on("ready", function () {
                        set_imagenAccional();
                        //ver pdf para impresion
                        $('#btn_verReservaPdf').click(function () {
                            var cod = $('#span_cod_reserva').html();
                            var base = Base64.encode(cod);
                            //utiliza get para solo guardar el pdf
                            //$.get('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>',{cdg:base});
                            //utiliza window open para mostrar y guardar el pdf
                            window.open('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>?cdg=' + base);
                        });
                        $('#btn_hacerEfectiva').click(function () {
                            var cod = $('#span_cod_reserva').html();
                            $.post('<?php echo base_url() . "index.php/Reserva/hacerEfectiva" ?>', {codigo: cod}, function (resp) {
                                jAlert(resp, "Venta " + cod, function () {
                                    location.reload();
                                });
                            });
                        });
                    });//FIN DEL READY
                    function set_imagenAccional() {//colocamos la animacion de la imagen
                        $('.td-imagen').mouseover(function () {
                            $(this).find('img.accional').show();
                        });
                        $('.td-imagen').mouseout(function () {
                            $(this).find('img.accional').hide();
                        });
                    }
                    function modalDetalleProducto(mod)
                    {
                        $('#span_titulo_prod').html(mod);
                        $('#body_detalle_producto').load('<?php echo base_url() . "index.php/Producto/verDetalleProducto" ?>', {modelo: mod});
                        $('#detalle_producto').modal();
                    }
                    function desactivarProducto()
                    {
                        mod=$('#span_titulo_prod').html();
                        jConfirm("Esta seguro de desatcivar el producto "+mod,"Desactivar Producto",function(r){
                            if(r){
                                $.post("<?php echo base_url().'index.php/Producto/desactivarProducto'?>",{modelo:mod},function(resp){
                                    if (resp==1)
                                    {
                                        jAlert("Se ha desactivado el producto","Producto Desactivado",function (){
                                            location.reload();
                                        });
                                    }
                                });
                            }
                        });
                    }
                    function mostrarDetalleCliente(idCliente, nom) {
                        $('#span_titulo_cliente').html("Sr(a) " + nom);
                        $('#body_detalle_cliente').load('<?php echo base_url() . "index.php/Cliente/verDetalleUltimaCompra" ?>', {id: idCliente}, function () {
                            set_imagenAccional();
                        });
                        $('#detalle_cliente').modal();
                    }
                    function verDetalleReserva(cod, cli) {
                        $('#span_cod_reserva').html(cod);
                        $('#span_cliente_reserva').html(cli);
                        $('#body_detalle_reserva').load('<?php echo base_url() . "index.php/Reserva/verDetalleReserva" ?>', {codigo: cod}, function () {
                            set_imagenAccional();
                            $('#tot_reserva').val($('#inTotalReserva').val());
                        });
                        $('#detalle_reserva').modal();
                    }
                    function eliminarReserva(cod, nom) {
                        jConfirm("Esta seguro de eliminar la Reserva de " + nom + " ? ", "Reservado", function (r) {
                            if (r) {
                                $.post('<?php echo base_url() . "index.php/Reserva/eliminarReserva" ?>', {codigo: cod}, function (resp) {
                                    jAlert(resp + " " + nom, "Reserva Eliminada", function () {
                                        location.reload();
                                    });
                                });
                            }
                        });
                    }
</script>