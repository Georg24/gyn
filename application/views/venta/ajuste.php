<div class="col-sm-10"><!--este es el contenedor principal ajuste venta-->
    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 col-xs-4">
            <legend>
                Ventas diarias
            </legend>
        </div>
        <div class="col-sm-5 col-sm-offset-1 col-xs-8">
            <form id="form_buscadia" class="form-inline col-xs-11 col-sm-9" action="<?php echo base_url(); ?>index.php/Venta/ajuste/">
                <input id="input_dia" type="date" class="input-sm form-control" required max="<?php echo date('Y-m-d'); ?>" min="2016-07-01" value="<?php echo ($dia) ? $dia : date('Y-m-d'); ?>">
                <input type="submit" class="btn btn-sm btn-info" value="Buscar" style="margin: 5px;">
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
                                <td><?= $dato->total; ?></td>
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
                        <button type="button" class="btn btn-success" id="btn_ajustarDetalle" disabled>&nbsp;&nbsp;Ajustar&nbsp;&nbsp;</button>
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
                                        $('#form_buscadia').submit(function (ev) {
                                            ev.preventDefault();
                                            window.location = $(this).attr('action') + $('#input_dia').val();
                                        });
                                        //realizar el ajuste
                                        $('#btn_ajustarDetalle').click(function () {
                                            var json = tablaDetalle2json();
                                            $.ajax({
                                                url: "<?php echo base_url() . 'index.php/Venta/ajustarDetalle'; ?>",
                                                type: 'POST',
                                                data: JSON.parse(json),
                                                success: function (resp) {
                                                    if (resp != '')
                                                    {
                                                        jAlert(resp,"Ajuste de Venta",function (){
                                                            location.reload();
                                                        });
                                                    }
                                                }
                                            });
                                        });
                                        //ver pdf para impresion
                                        $('#btn_verpdf').click(function (){
                                            var cod=$('#span_codigo').html();
                                            var base=Base64.encode(cod);
                                            //utiliza get para solo guardar el pdf
                                            //$.get('<?php echo base_url()."index.php/Expo/guardarPdfVenta"?>',{cdg:base});
                                            //utiliza get para mostrar y guardar el pdf
                                            window.open('<?php echo base_url()."index.php/Expo/guardarPdfVenta"?>?cdg='+base);
                                        });
                                    });//==fin de ready
                                    //muestra la ventana MODAL detalle
                                    function verDetalleVenta(cod)
                                    {
                                        $('#span_codigo').html(cod);
                                        $('#body_detalle').load("<?php echo base_url() . 'index.php/Venta/detalleVenta' ?>", {codigo: cod}, function () {
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
                                            $(this).html((parseFloat($(this).parent().find('.det_cant').val())*parseFloat($(this).parent().find('.det_prec').val())).toString());
                                            tot = tot + parseFloat($(this).html());
                                        });
                                        $('#tot_detalle').val(tot);
                                    }
                                    //al ver DEtalle Venta coloca las funciones de cambio a los campos
                                    function set_funciones_cantidades()
                                    {
                                        $('.det_cant').keyup(function () {
                                            if ($(this).val() == $(this).parent().find('.defecto_cant').val() && parseFloat($(this).parent().parent().find('input.det_prec').val()) == parseFloat($(this).parent().parent().find('input.defecto_prec').val()))
                                            {
                                                $(this).parent().parent().css('background-color', '#fff');
                                            } else {
                                                $(this).parent().parent().find('td.subtot').html(parseFloat($(this).val()) * parseFloat($(this).parent().parent().find('input.det_prec').val()));
                                                $(this).parent().parent().css('background-color', '#f2dede');
                                            }
                                            calc_total_det();
                                            habilita_Ajuste();
                                        });
                                        $('.det_prec').keyup(function () {
                                            if (parseFloat($(this).val()) == parseFloat($(this).parent().find('.defecto_prec').val()) && $(this).parent().parent().find('input.det_cant').val() == $(this).parent().parent().find('input.defecto_cant').val())
                                            {
                                                $(this).parent().parent().css('background-color', '#fff');
                                            } else {
                                                $(this).parent().parent().find('td.subtot').html(parseFloat($(this).val()) * parseFloat($(this).parent().parent().find('input.det_cant').val()));
                                                $(this).parent().parent().css('background-color', '#f2dede');
                                            }
                                            calc_total_det();
                                            habilita_Ajuste();
                                        });
                                        $('.moneda').number(true, 2);
                                        $('.num').number(true, 0, '', '');
                                    }
                                    //Verfica si los campos estan correctos y habilita el boton para el ajuste
                                    function habilita_Ajuste() {
                                        var sw = true;//para saber si los campos estan vacios
                                        var defecto = false; //para saber si se han mantenido x defecto
                                        $('.det_cant').each(function (ind) {
                                            if ($(this).val() == "")
                                            {
                                                sw = false;
                                            }
                                            if ($(this).val() != $(this).parent().find('.defecto_cant').val() || parseFloat($(this).parent().parent().find('input.det_prec').val()) != parseFloat($(this).parent().parent().find('input.defecto_prec').val()))
                                            {
                                                defecto = true;
                                            }
                                        });
                                        $('.det_prec').each(function (ind) {
                                            if ($(this).val() == "")
                                            {
                                                sw = false;
                                            }
                                        });
                                        if (sw && defecto) {
                                            $('#btn_ajustarDetalle').removeAttr('disabled');
                                        } else {
                                            $('#btn_ajustarDetalle').attr('disabled', 'disabled');
                                        }
                                    }
                                    function tablaDetalle2json() {
                                        var json = '{';
                                        var otArr = [];
                                        var tbl2 = $('#tabla_detalle tr').each(function (i) {
                                            if (i > 0) {
                                                x = $(this).children();
                                                var itArr = [];
                                                var j = 0;
                                                x.each(function () {
                                                    if (j < 4) {
                                                        if (j === 0)
                                                        {
                                                            itArr.push('"cantidad":"' + $(this).children().val() + '"');
                                                            itArr.push('"antcant":"' + $(this).find('.defecto_cant').val() + '"');
                                                        }
                                                        if (j === 1) {
                                                            itArr.push('"modelo":"' + $(this).html() + '"');
                                                        }
                                                        if (j === 2)
                                                        {
                                                            itArr.push('"precio":"' + $(this).children().val() + '"');
                                                        }
                                                        if (j === 3) {
                                                            itArr.push('"subtotal":"' + $(this).html() + '"');
                                                            itArr.push('"codigo":"' + $('#span_codigo').html() + '"');
                                                        }
                                                    }
                                                    j++;
                                                });
                                                otArr.push('"' + i + '": {' + itArr.join(',') + '}');
                                            }
                                        });

                                        json += otArr.join(",") + '}';
                                        return json;
                                    }
</script>