<div class="col-sm-10">
    <div class="row">
        <div class="col-sm-12">
            <form id="form_modelo" class="form-horizontal"  role="form" action="<?= base_url() . 'index.php/Inventario/paraAjustar' ?>"> 
                <fieldset>
                    <!-- Form Name -->
                    <legend>Ajuste de Inventario</legend>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="modelo">Modelo Codigo</label>  
                        <div class="col-md-4">
                            <datalist id="lista_productos">
                                <?php
                                //del helper productos
                                $desc = getModelosDescripcion();
                                foreach ($desc as $val) {
                                    echo '<option value="' . $val->modelo . '"></option>';
                                }
                                ?>
                            </datalist>
                            <input id="inputmodelo" list="lista_productos" name="modelo" type="text" placeholder="ej: 3960BK" class="form-control input-md" maxlength="49" required autofocus>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="Buscar" class="btn btn-info">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="resultados_ajuste" hidden="">
            <div class="col-sm-7">
                <table class="table table-hover table-condensed table-responsive text-center">
                    <thead class="text-center">
                    <th>Usuario</th><th>Proveedor</th><th>Recepcion</th><th>Registrado</th><th>Ajuste</th><th>Modificar</th>
                    </thead>
                    <tbody id="cuerpo_ajuste">
                        <!--aqui se llena los datos al buscar un producto-->
                    </tbody>
                </table>
            </div>
            <div class="col-sm-4">
                <h3 id="modelo_img"></h3>
                <span id="exist_img" class="label label-primary" style="font-size: 16px;"></span>
                <span id="ajust_img" class="label h3" style="font-size: 16px; padding-left: 5px;"></span>
                <span id="total_img" class="label label-primary h3" style="font-size: 16px; padding-left: 5px;"></span>
                <img id="prod_img" class="i img-responsive img-rounded" style="width: 280px; height: 300px;padding-top: 5px;">
                <p id="desc_img" style="padding-top: 5px;"></p>
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
<script src="<?= base_url(); ?>assets/js/jquery.number.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/alerts/jquery.alerts.js" type="text/javascript"></script>
<script>

    $(document).on("ready", inicio);
    function inicio()
    {
        $('#inputmodelo').val('');
        //validacion de moneda para los parametros
        $('.moneda').number(true, 2);
        $('.num').number(true, 0, '', '');
        //====para ajustar de una lista de productos====
        $("#form_modelo").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: $('#form_modelo').attr('action'),
                type: "POST",
                data: $('#form_modelo').serialize(),
                success: function (resp) {
                    var reg = eval(resp);
                    var html = "";
                    var limite = reg.length;
                    if (limite > 5)
                        limite = 5;
                    for (var i = 0; i < limite; i++)//solo las ultimos 5 recepciones
                    {
                        html = html + "<tr>";
                        html = html + "<td>" + reg[i]['nombre'] + "</td>";
                        html = html + "<td>" + reg[i]['razon'] + "</td>";
                        html = html + "<td>" + reg[i]['fecha'] + "</td>";
                        html = html + "<td id='cantReg_" + reg[i]['id_recepcion'] + "' class='cantReg'>" + reg[i]['cantidad'] + "</td>";
                        html = html + "<td><input id='cant_" + reg[i]['id_recepcion'] + "' type='text' class='num cantRecp input-td' value='" + reg[i]['cantidad'] + "' min='0' maxlength='6'></td>";
                        html = html + "<td><button class='BtnModCantidad btn btn-success btn-sm' onclick='modCantidad(" + reg[i]['id_recepcion'] + "," + reg[i]['existencia'] + ")' disabled>Ajustar</button></td>";
                        html = html + "</tr>";
                    }
                    $('#modelo_img').html(reg[0]['modelo']);
                    $('#desc_img').html(reg[0]['descripcion']);
                    $('#exist_img').html(reg[0]['existencia']);
                    $('#prod_img').attr('src', '<?php echo base_url(); ?>sources/ups/' + reg[0]['imagen']);
                    $('#cuerpo_ajuste').html(html);
                    setValidacionNumero();
                    $('#resultados_ajuste').fadeIn('fast');
                    $('.cantRecp').keyup(function () {
                        if ($(this).val() == "" || $(this).val() == $(this).parent().parent().find('td.cantReg').html())
                        {
                            $(this).parent().parent().find('button.BtnModCantidad').attr('disabled', 'disabled');
                            $('#ajust_img').html('');
                            $('#total_img').html('');
                        } else {
                            var reg = $(this).parent().parent().find('td.cantReg').html();
                            var nuevo = $(this).val();
                            $(this).parent().parent().find('button.BtnModCantidad').removeAttr('disabled');
                            if (nuevo - reg > 0) {
                                $('#ajust_img').removeClass('label-danger');
                                $('#ajust_img').addClass('label-success');
                                $('#ajust_img').html("+" + nuevo - reg);
                                $('#total_img').html("total: " + (parseInt($('#exist_img').html()) + parseInt(nuevo - reg)));
                            } else {
                                $('#ajust_img').removeClass('label-success');
                                $('#ajust_img').addClass('label-danger');
                                $('#ajust_img').html(nuevo - reg);
                                $('#total_img').html("total: " + (parseInt($('#exist_img').html()) + parseInt(nuevo - reg)));
                            }
                        }
                    });
                    $('.cantRecp').focusin(function () {
                        $('.cantRecp').each(function (index) {
                            $(this).val($(this).parent().parent().find('td.cantReg').html());
                            $(this).parent().parent().find('button.BtnModCantidad').attr('disabled', 'disabled');
                            $('#ajust_img').html('');
                            $('#total_img').html('');
                        });
                    });
                }
            });
            //$("#form_recepcion")[0].reset();
        });
    }//===FIN DEL READY
    function setValidacionNumero()
    {
        $('.num').number(true, 0, '', '');
    }

    function modCantidad(id, ext)
    {
        var mod = $('#modelo_img').html();
        var cant = $('#cant_' + id).val();
        var ant = $('#cantReg_' + id).html();
        if (ext >= ant - cant)
        {
            var nueva = ext + (cant - ant);
            if (ant < cant)
            {
                jConfirm("¿Esta seguro de realizar el Ajuste?\nExistencia Actual=" + ext + "\nExistencia Nueva=" + nueva, "Ajuste Positivo", function (r) {
                    if (r) {
                        $.post("<?php echo base_url() . 'index.php/Inventario/ajustePositivo' ?>", {id_recepcion: id, modelo: mod, existencia: ext, add: (cant - ant)}, function (resp) {
                            jAlert(resp, "Ajuste Positivo", function () {
                                location.reload();
                            });
                        });
                    }
                });
            } else {
                jConfirm("¿Esta seguro de realizar el Ajuste?\nExistencia Actual=" + ext + "\nExistencia Nueva=" + nueva, "Ajuste Negativo", function (r) {
                    if (r) {
                        $.post("<?php echo base_url() . 'index.php/Inventario/ajusteNegativo' ?>", {id_recepcion: id, modelo: mod, existencia: ext, rem: (ant - cant)}, function (resp) {
                            jAlert(resp, "Ajuste Negativo", function () {
                                location.reload();
                            });
                        });
                    }
                });
            }
        } else {
            jAlert("No se puede raelizar el ajuste Negativo.\nVerifique que la existencia del producto no sea negativa", "Existencia Negativa");
        }


    }

</script>
</body>
</html>

