<div class="col-sm-10">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
        <div class="row">
            <form id="form_buscar" class="form-horizontal" role="form" action="<?= base_url() . 'index.php/venta/buscar' ?>"> 
                <fieldset>
                    <!-- Form Name -->
                    <legend><H3>Busqueda</H3></legend>
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-xs-4 col-xs-offset-1" for="modelo">Modelo/Cod</label>  
                        <div class="col-sm-6 input-group col-xs-4">
                            <input id="inputbuscar" name="modelo" type="text" placeholder="ej: 3960BK" class="form-control input-md" maxlength="49" autofocus>
                            <span class="input-group-btn"><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>   
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="row">
            <div  id="tabla_encontrados">
                <div class="col-sm-12" id="cuerpo_tabla">
                    <!--SERA COMPLETADO POR MEDIO DEL METODO AJAX -->
                </div>
            </div>

        </div>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
        <div class="row">
            <legend class="col-sm-6">
                <h3 style="margin: 5px;">Detalle de Venta</h3>
            </legend>
            <div class="col-sm-6">
                <input class="text-uppercase pull-right form-control input-md" type="text" id="txtcliente" value="CLIENTE" style="margin-bottom: 5px;width: 80%;">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table  table-bordered table-custom" id="tabla_recibo">
                    <thead>
                    <th>Cant</th><th>Codigo/Desc</th><th>P/u Bs.-</th><th>SubTotal</th><th>&nbsp;&nbsp;X&nbsp;&nbsp;</th>
                    </thead>
                    <tbody id="cuerpo_recibo" style="font-size: 16px;">
                        <!--aqui va el cuerpo del recibo-->
                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">

            <div class="col-md-5 col-md-offset-1 col-sm-6 col-sm-offset-5 col-xs-6 col-xs-offset-3">
                <span class="label label-success h2" style="font-size: 20px;">Total Bs</span>
                <input id="imp_total" class="form-control input-lg text-right" value="0" style=" margin-top: -20px;font-size: 28px;" disabled/>

                <p class="h3  input-group">
                    <span class="input-group-addon">Efectivo</span>
                    <input id="imp_pago" class="form-control input-md text-right col-md-4 moneda" value="0" /> 
                </p>
                <p class="h3  input-group">
                    <span class="input-group-addon ">Cambio</span>
                    <input id="imp_cambio" class="form-control input-md text-right col-md-4 moneda" value="0" disabled style="background-color: #fff;"/> 
                </p>
            </div>
            <br class="visible-lg visible-md"><br class="visible-lg visible-md">
            <div class="col-md-5 col-md-offset-1 col-sm-6 col-sm-offset-5 col-xs-6 col-xs-offset-3">
                <button id="submit_vender" class="pull-right btn btn-success btn-block" disabled>Vender 
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                </button>

                <button id="submit_cancela" class="pull-right btn btn-danger btn-block" <!--onclick="cancela_todo()-->">Cancelar
                        <span class="glyphicon glyphicon-remove-sign"></span>
                </button>

                <button id="submit_reservar" class="pull-right btn btn-warning btn-block" disabled>Reservar
                    <span class="glyphicon glyphicon-pushpin"></span>
                </button>
            </div>

        </div>

    </div>
</div>
</div>
</div>
<!--cierre de row y container fluid--> 


<div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Venta Registrada</h4>
            </div>
            <div class="modal-body">
                <h3 class="bg-success text-success text-center" id="label_cod_venta"></h3>
                <p>Desea imprimir el detalle de la venta</p>
                <input type="checkbox" name="copia" id="checkcopia" value="on" ch>&nbsp; Copia
            </div>
            <div class="modal-footer">
                <button id="btn_guardar" type="button" class="btn btn-default" data-dismiss="modal">Solo Guardar</button>
                <button id="btn_impresion" type="button" class="btn btn-primary" data-dismiss="modal">Impresión</button>
            </div>
        </div>
    </div>
</div>
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

    $(document).on("ready",inicio);
    function inicio()
    {
        $('#btn_impresion').click(function () {
            var cod = $('#label_cod_venta').html();
            //alert($('#checkcopia:checked').val());
            var cop= $('#checkcopia:checked').val();
            var base = Base64.encode(cod);
            //utiliza get para mostrar y guardar el pdf ver btn_guardar
            location.reload();
            window.open('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>?cdg=' + base +"&copia="+cop);
        });
        $('#btn_guardar').click(function () {
            var cod = $('#label_cod_venta').html();
            var base = Base64.encode(cod);
            //utiliza get para solo guardar el pdf ver arriba
            $.get('<?php echo base_url() . "index.php/Expo/guardarPdfVenta" ?>', {cdg: base});
            location.reload();
        });
        $('#submit_cancela').click(function () {
            cancelar_recibo();
        });
        /*vender la lista en el recibo*/
        $("#submit_vender").click(function (event) {
            event.preventDefault();
            var json = tabla2json();
            $.ajax({
                url: "<?php echo base_url() . 'index.php/venta/vender'; ?>",
                type: 'POST',
                data: JSON.parse(json),
                success: function (resp) {
                    if (resp != '')
                    {
                        $('#label_cod_venta').html(resp);
                        $('.bs-modal-sm').modal();
                        cancelar_recibo();
                    }
                }
            });
        });
        /*Reservar la lista en el recibo*/
        $("#submit_reservar").click(function (event) {
            event.preventDefault();
            var json = tabla2json();
            $.ajax({
                url: "<?php echo base_url() . 'index.php/venta/reservar'; ?>",
                type: 'POST',
                data: JSON.parse(json),
                success: function (resp) {
                    if (resp != '')
                    {
                        $('#label_cod_venta').html(resp);
                        $('.bs-modal-sm').modal();
                        cancelar_recibo();
                    }
                }
            });
        });
        //==========calcula cambio====================
        $('#imp_pago').keyup(function () {
            calcula_cambio();
        });
        //====para buscar un productos y llenar la tabla====

        //====para buscar un productos y llenar la tabla====
        $("#form_buscar").submit(function (event) {
            event.preventDefault();
            if ($('#inputbuscar').val() != "")
            {
                $.ajax({
                    url: $('#form_buscar').attr('action'),
                    type: "POST",
                    data: {buscar: $("#inputbuscar").val()},
                    success: function (resp) {
                        var reg = eval(resp);
                        var html = "";
                        for (var i = 0; i < reg.length; i++)
                        {

                            html = html + "<div class='media'><div class='media-left'><img class='accional2' src='<?php echo base_url() . 'sources/ups/'; ?>" + reg[i]['imagen'] + "' style='width: 220px; height: 240px;' hidden>"
                                    + "<img class='media-object img-rounded'"
                                    + "src='<?php echo base_url() . 'sources/ups/'; ?>" + reg[i]['imagen'] + "' style='width: 100px; height: 100px;'>"
                                    + "</div><div class='media-body'>"
                                    + "<form class='form_agregar' name='fm" + reg[i]['modelo'] + "' method='post' action='<?php echo base_url() . 'index.php/Carrito/agregar' ?>'>"
                                    + "<div class='col-lg-8 col-md-12 col-sm-12 text-center'>"
                                    + "<h3 class='media-heading col-xs-6 col-md-12 col-sm-6' id='mod_" + i + "'> Modelo: " + reg[i]['modelo']
                                    + "</h3><input type='text' name='modelo' value='" + reg[i]['modelo'] + "' hidden>"
                                    + "<div class='col-md-12 text-center'>"
                                    + "<input type='radio' name='precio' value='" + reg[i]['precio_m'] + "' onclick='cambiar(this.value," + i + ")' checked/>  "
                                    + "<input type='radio' name='precio' value='" + reg[i]['precio_u'] + "' onclick='cambiar(this.value," + i + ")'/>"
                                    + "<label class='dato' id='precio_" + i + "'> Bs.- " + reg[i]['precio_m'] + "</label>"
                                    + "</div>"
                                    + "<div class='input-group dato'><span class='input-group-addon'>Pedido: </span>"
                                    + "<input class='input-md form-control text-center' id='cant_" + i + "'type='number' name='cantidad' value='1' min='1' max='" + reg[i]['existencia'] + "' autocomplete='off' required>"
                                    + "</div>"
                                    + "</div>"
                                    + "<div class='col-lg-4 col-md-12 col-sm-12 col-xs-12 '>"
                                    + "<input type='text' name='existencia' value='" + reg[i]['existencia'] + "' hidden>";
                            if (reg[i]['existencia'] > 0)
                            {
                                html = html + "<h3 class='col-lg-12 col-md-6 col-sm-6 col-xs-6 cant'><span class='label label-primary badge-md'>" + reg[i]['existencia'] + "</span></h3>"
                                        + "<input type='submit' class='btn btn-success btn-md' id='btnadd' value='Agregar'>";
                            } else {
                                html = html + "<h3 class='col-lg-12 col-md-6 col-sm-6 col-xs-6 cant'><span class='label label-danger badge-md'>" + reg[i]['existencia'] + "</span></h3>";
                            }
                            html = html + "</div>"
                                    + "</div>"
                                    + "</form></div></div> ";
                        }
                        $('#cuerpo_tabla').html(html);
                        $('#tabla_encontrados').removeAttr('hidden');
                        set_funcionAgregar();
                        //funciones para visualizar la imagen
                        $('img.media-object').mouseover(function () {
                            $(this).parent().find('img.accional2').show();
                        });
                        $('img.media-object').mouseout(function () {
                            $(this).parent().find('img.accional2').hide();
                        });

                    }
                });
            }
        });
        //======================================================
        //AUTOCOMPLETAR para los modelos de la venta
        $(function () {
            var autocompletar = new Array();
<?php
//helper de venta_helper .. 
$modelos = getModelos();
for ($i = 0; $i < sizeof($modelos); $i++) {
    ?>
                autocompletar.push("<?php echo $modelos[$i]->modelo ?>");
<?php } ?>
            $("#inputbuscar").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
                source: autocompletar //Le decimos que nuestra fuente es el arreglo
            });
        });
        //===========================================================
        //AUTOCOMPLETAR para los modelos de la venta
        $(function () {
            var autocompletar = new Array();
<?php
//helper de venta_helper .. 
$clientes = getClientes();
for ($i = 0; $i < sizeof($clientes); $i++) {
    ?>
                autocompletar.push("<?php echo $clientes[$i]->nombre ?>");
<?php } ?>
            $("#txtcliente").autocomplete({//Usamos el ID de la caja de texto donde lo queremos
                source: autocompletar //Le decimos que nuestra fuente es el arreglo
            });
        });
        //===========================================================

        //===========================================================
        //iniciar el carrito con un metodo de helper venta
        if (<?php echo tieneItems(); ?>)
        {
            jConfirm('Usted tiene una compra en curso.\n Desea Continuar adicionando Productos', 'Venta en Curso', function (r) {
                if (r)
                {
                    mostrar_recibo();
                    $('#inputbuscar').focus();
                    $('#submit_vender').removeAttr('disabled');
                    $('#submit_reservar').removeAttr('disabled');
                } else
                {
                    cancelar_recibo();
                }
            });
        }
    }

    //===FIN DE READY========================================================
    //==========================================================
    //===MOSTRAR LOS DATOS DE LA TABLA DE BUSQUEDA DE PRODUCTOS===========
    function mostrarDatos(valor) {
        $.ajax({
            url: $('#form_buscar').attr('action'),
            type: "POST",
            data: {buscar: valor},
            success: function (resp) {
                alert(resp);
            }
        });
    }
    /*calcular el cambio despues de cargar todo*/
    function calcula_cambio()
    {
        if (parseInt($('#imp_total').val()) !== 0 && $('#imp_total').val() !== "" && parseInt($('#imp_pago').val()) !== 0 && $('#imp_pago').val() !== "")
        {
            var cambio = parseFloat($('#imp_pago').val()) - parseFloat($('#imp_total').val());
            $('#imp_cambio').val(cambio);
        } else
        {
            $('#imp_cambio').val('0');
        }
    }
    /*=================================
     /*===AGREGAR al carrito ===
     * mandar los datos serializados al controlador carrito y agregarlos con insert ====*/
    function set_funcionAgregar()
    {
        $('.form_agregar').submit(function (ev)
        {
            ev.preventDefault();
            var form = $(this).serialize();
            $.ajax({
                url: '<?php echo base_url() . 'index.php/carrito/agregar' ?>',
                type: "POST",
                data: form,
                success: function (resp) {
                    //alert(resp);
                    mostrar_recibo();
                    $('#submit_vender').removeAttr('disabled');
                    $('#submit_reservar').removeAttr('disabled');
                }
            });

        });
    }
    /*===mostrar el carrito ===
     *llama la respuesta de la funcion mostrar recibo del control CARRITO ====*/
    function mostrar_recibo()
    {
        $('#cuerpo_recibo').html("<tr><td colspan='5' class='text-center'><img src='<?= base_url() ?>sources/images/icon-loading.gif'></td></tr>");
        $.ajax({
            url: '<?php echo base_url() . "index.php/Carrito/mostrar" ?>',
            type: 'POST',
            data: '',
            success: function (resp) {
                $('#cuerpo_recibo').html(resp);
                set_funcionCambioCantidad();
                set_funcionCambioPrecio();
            },
            error: function () {
                alert("Ha ocurrido un problema solicitando la respuesta recibo desde el servidor");
            },
            complete: function () {
                calcula_importe();
                //set validacion de numeros y moneda
                $('.moneda').number(true, 2);
                if (parseInt($('#imp_total').val()) != 0)
                {
                    $('#submit_vender').removeAttr('disabled');
                    $('#submit_reservar').removeAttr('disabled');
                } else {
                    $('#submit_vender').attr('disabled', 'disabled');
                    $('#submit_reservar').attr('disabled', 'disabled');
                }
            }
        });
    }
    function cancelar_recibo()
    {
        $.ajax({
            url: '<?php echo base_url() . "index.php/Carrito/eliminarTodo" ?>',
            type: 'POST',
            data: '',
            success: function (resp) {
                if (resp)
                {
                    try {
                        mostrar_recibo();
                    } catch (ex) {
                        alert('Error function Cancel Bill ' + ex);
                    }
                }
            }
        });

    }
    /*elimina un item del recibo carrito*/
    function borrar_item(item)
    {
        var json = tabla2jsonSinCliente();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/Carrito/actualizaCarrito'; ?>",
            type: 'POST',
            data: JSON.parse(json),
            success: function (resp) {
                if (resp == 1)
                {
                    $.ajax({
                        url: '<?php echo base_url() . "index.php/Carrito/eliminarItem" ?>',
                        type: 'POST',
                        data: {'modelo': item.toString()},
                        success: function (resp) {
                            mostrar_recibo();
                        },
                        error: function () {
                            alert("Ha ocurrido un problema solicitando la respuesta borrar Item desde el servidor");
                        }
                    });
                }
            }
        });

    }
    /*=====calcular el importe total general============*/
    function calcula_importe()
    {
        var total = 0;
        $('td.subtotal').each(function (index) {
            var sub = $(this).html();
            total = parseFloat(total) + parseFloat(sub);
        });
        $('#imp_total').val(total.toString());
    }
    /*=====sacar json de la tabla============*/
    function tabla2json() {
        var json = '{';
        var otArr = [];
        var tbl2 = $('#tabla_recibo tr').each(function (i) {
            if (i > 0) {
                x = $(this).children();
                var itArr = [];
                var j = 0;
                x.each(function () {
                    if (j < 4) {
                        if (j === 0)
                        {
                            itArr.push('"cantidad":"' + $(this).children().val() + '"');
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
                            itArr.push('"cliente":"' + $('#txtcliente').val() + '"');
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
    function tabla2jsonSinCliente() {
        var json = '{';
        var otArr = [];
        var tbl2 = $('#tabla_recibo tr').each(function (i) {
            if (i > 0) {
                x = $(this).children();
                var itArr = [];
                var j = 0;
                x.each(function () {
                    if (j < 4) {
                        if (j === 0)
                        {
                            itArr.push('"cantidad":"' + $(this).children().val() + '"');
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
    /*cambio de cantidad.. a los inputs clase cant_rec*/
    function set_funcionCambioCantidad() {
        $('input.cant_rec').keyup(function () {
            $(this).val(parseInt($(this).val()));
            if (parseInt($(this).val()) > parseInt($(this).attr('max')))
                $(this).val($(this).attr('max'));
        });
        $('input.cant_rec').focusin(function () {
            $('#submit_vender').attr('disabled', 'disabled');
            $('#submit_reservar').attr('disabled', 'disabled');
        });
        $('input.cant_rec').focusout(function () {
            if ($(this).val() == "")
            {
                $(this).val('1');
                var cod = $(this).attr('id');
                var sub = parseFloat($(this).val()) * parseFloat($('input#prec_' + cod).val());
                $('td#sub_' + cod).html(sub);
                calcula_importe();
            }
            $('#submit_vender').removeAttr('disabled');
            $('#submit_reservar').removeAttr('disabled');
        });
        $('input.cant_rec').keyup(function () {
            var cod = $(this).attr('id');
            var sub = parseFloat($(this).val()) * parseFloat($('input#prec_' + cod).val());
            $('td#sub_' + cod).html(sub);
            calcula_importe();
        });
        $('input.cant_rec').change(function () {
            var cod = $(this).attr('id');
            var sub = parseFloat($(this).val()) * parseFloat($('input#prec_' + cod).val());
            $('td#sub_' + cod).html(sub);
            calcula_importe();
        });
    }
    /*cambio de precio.. a los inputs clase cant_rec*/
    function set_funcionCambioPrecio()
    {
        $('input.prec_rec').focusin(function () {
            $('#submit_vender').attr('disabled', 'disabled');
            $('#submit_reservar').attr('disabled', 'disabled');
        });
        $('input.prec_rec').focusout(function () {
            if ($(this).val() == "")
            {
                $(this).val('1');
                var cod = $(this).attr('cod');
                var sub = parseFloat($(this).val()) * parseFloat($('input#' + cod).val());
                $('td#sub_' + cod).html(sub);
                calcula_importe();
            }
            $('#submit_vender').removeAttr('disabled');
            $('#submit_reservar').removeAttr('disabled');
        });
        $('input.prec_rec').keyup(function(){
            var cod = $(this).attr('cod');
            var sub = parseFloat($(this).val()) * parseFloat($('input#' + cod).val());
            $('td#sub_' + cod).html(sub);
            calcula_importe();
        });
        $('input.prec_rec').change(function () {
            var cod = $(this).attr('cod');
            var sub = parseFloat($(this).val()) * parseFloat($('input#' + cod).val());
            $('td#sub_' + cod).html(sub);
            calcula_importe();
        });
    }
    function cambiar(valor, ind)
    {
        $('label#precio_' + ind).html('Bs.- ' + valor);
    }

</script>
</body>
</html>