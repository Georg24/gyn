<div class="col-sm-10"><!--este es el contenedor principal ajuste venta-->
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 col-xs-4">
            <legend>
                Venta diaria de <?= quienUsuario($quien); ?>
            </legend>
        </div>
        <div class="col-sm-6 col-xs-8">
            <form id="form_buscadia" class="form-inline col-xs-12 col-sm-12" action="<?php echo base_url(); ?>index.php/Venta/registroDiario/" method="post">
                <select id="select_usuario" class="input-sm form-control" name="ci" required style="margin: 5px;">
                    <option value="todos">Todos</option>
                    <?php
                    //llenamos los usuarios de la base desde venta helper
                    $usuarios = getNombresUsuarios();
                    foreach ($usuarios as $val) {
                        if ($quien == $val->ci)
                            echo "<option value='" . $val->ci . "' selected>" . $val->nombre . "</option>";
                        else
                            echo "<option value='" . $val->ci . "'>" . $val->nombre . "</option>";
                    }
                    ?>
                </select>
                <input name="dia" id="input_dia" type="date" class="input-sm form-control" required max="<?php echo date('Y-m-d'); ?>" min="2016-07-01" value="<?php echo ($dia) ? $dia : date('Y-m-d'); ?>" style="margin: 5px;">
                <input type="submit" class="btn btn-sm btn-info" value="Buscar" style="margin:5px 5px 5px;">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <table class="table table-hover table-responsive  table-condensed text-center">
                <thead>
                <th class="text-center">Cod Venta</th><th class="text-center">Usuario</th><th class="text-center">Cliente</th><th class="text-center">Fecha</th><th class="text-center">Total</th></tr>
                </thead>
                <tbody>
                    <?php
                    if (sizeof($tabla) > 0) {
                        foreach ($tabla as $dato) {
                            ?>
                            <tr>
                                <td><?= $dato->cod_venta; ?></td>
                                <td><?= $dato->usuario; ?></td>
                                <td><?= $dato->cliente; ?></td>
                                <td><?= $dato->fecha; ?></td>
                                <td class="td_subtotal"><?= $dato->total; ?></td>
                                <td><button class="btn btn-danger btn-sm" onclick="verDetalleVenta('<?php echo $dato->cod_venta; ?>')">Detalle&nbsp;&nbsp;<span class="glyphicon glyphicon-list-alt"></span></button></td>
                            </tr>
                            <?php
                        }
                        
                    } else {
                        ?><td colspan="6">No se ha encontrado ningún registro </td><?php
                    }
                    ?>
                </tbody>
            </table>
            
            <div class="row">
                <div class="col-sm-4 col-sm-offset-8 col-xs-6 col-xs-offset-6">
                    <h3>Total Bs.- &nbsp;<span id="span_total_general" class="text-success"></span></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Modal_Detalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-success" id="myModalLabel">Detalle Venta<span class="text-success" id="span_codigo"></span></h3>
                    <button type="button" class="btn btn-primary btn-sm pull-right" id="btn_verpdf">Ver PDF</button>
                </div>
                <div class="modal-body" id="body_detalle">
                    <!--Aqui se muestra el load de la funcion VerDetalleVenta-->
                </div>
                <div class="modal-footer">
                    <div class="form-group pull-left col-sm-6" style="margin-bottom: 0px;">
                        <label class="col-sm-3 pull-left h4">Bs.-</label>
                        <input id="tot_detalle" type="text" class="form-control" value="0" disabled style="width: 30%;font-size: 20px;text-align: center;width: 150px;">
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <button type="button" class="btn btn-danger " data-dismiss="modal" id="btn_cancelar">Cancelar</button>
                    </div>
                </div>
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
<script src="<?= base_url(); ?>assets/js/jquery.number.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/alerts/jquery.alerts.js" type="text/javascript"></script>
<script>
                            $(document).ready(function () {
                                calcular_total_general();
                                $('#form_buscadia').submit(function (ev) {
                                    ev.preventDefault();
                                    window.location = $(this).attr('action') + $('#input_dia').val() + $('#select_usuario').val();
                                });
                                //ver pdf para impresion
                                $('#btn_verpdf').click(function () {
                                    var cod = $('#span_codigo').html();
                                    var base = Base64.encode(cod);
                                    //utiliza get para solo guardar el pdf
                                    //$.get('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>',{cdg:base});
                                    //utiliza get para mostrar y guardar el pdf
                                    window.open('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>?cdg=' + base);
                                });
                                
                            });//==fin de ready
                            //muestra la ventana MODAL detalle
                            function verDetalleVenta(cod)
                            {
                                $('#span_codigo').html(cod);
                                $('#body_detalle').load("<?php echo base_url() . 'index.php/Venta/detalleVentaDiaria' ?>", {codigo: cod}, function () {
                                    calc_total_det();
                                    set_funciones_cantidades();
                                    habilita_Ajuste();
                                });
                                $('#Modal_Detalle').modal();
                            }
                            //calcula el total del detalle de venta
                            function calc_total_det()
                            {
                                var tot = 0;
                                $('td.subtot').each(function (ind) {

                                    tot = tot + parseFloat($(this).html());
                                });
                                $('#tot_detalle').val(tot);
                            }
                            //calcula total de ventas en el dia d la tabla
                            function calcular_total_general() {
                                var total=0;
                                $('.td_subtotal').each(function (ind) {
                                    total=total+parseFloat($(this).html());
                                });
                                $('#span_total_general').html(total.toString());
                                $('#span_total_general').number(true,2);
                            }
</script>