<div class="col-sm-10">

    <form id="form_recepcion" class="form-horizontal"  role="form" action="<?= base_url() . 'index.php/Inventario/registrar' ?>"> 
        <fieldset>
            <!-- Form Name -->
            <legend>Registro de Producto</legend>

            <div class="form-group">
                <label class="col-md-4 control-label" for="modelo">Modelo Codigo</label>  
                <div class="col-md-5">
                    <input id="inputmodelo" name="modelo" type="text" placeholder="ej: 3960BK" class="form-control input-md" maxlength="49" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="descripcion">Descripcion</label>  
                <div class="col-md-5">
                    <textarea id="inputdescripcion" name="descripcion" placeholder="ej:audifonos negros marca sony"class="form-control input-md" maxlength="250" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="costo">Costo por unidad</label>  
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Bs.-</span>
                        <input id="inputcosto" name="costo" type="text" class="moneda form-control input-md" placeholder="ej: 110.5" maxlength="18" required>
                    </div>
                </div>
            </div>        

            <div class="form-group">
                <label class="col-md-4 control-label" for="precio_u">Precio de venta por Unidad</label>  
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Bs.-</span>
                        <input id="inputpu" name="precio_u" type="text" class="moneda form-control input-md" placeholder="ej: 200.0" maxlength="18" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="precio_m">Precio de venta por Mayor</label>  
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">Bs.-</span>
                        <input id="inputpm" name="precio_m" type="text" class="moneda form-control input-md" placeholder="ej: 20" maxlength="18" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="minimo">Minimo en Inventario</label>  
                <div class="col-md-5">
                    <div class="input-group">
                        <input id="inputminimo" name="minimo" type="text" class="num form-control input-md" placeholder="ej: 155" maxlength="9" required>
                        <span class="input-group-addon">pcs</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="existencia">Cantidad de Registro Piezas</label>  
                <div class="col-md-5"> 
                    <div class="input-group">
                        <input id="inputpm" name="existencia" type="text" class="num form-control input-md" placeholder="ej: 200" maxlength="9" required >
                        <span class="input-group-addon">pcs</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="imagen">Imagen</label>  
                <div class="col-md-5"> 
                    <input id="inputimagen" name="imagen" type="file" class="btn btn-sm">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="proveedor">Proveedor</label>  
                <div class="col-md-5"> 
                    <select id="inputproveedor" name="proveedor" class="form-control input-md" >
                        <?php foreach ($proveedores as $prov) {
                            ?>
                            <option value="<?= $prov->id_proveedor ?>"><?= $prov->razon ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="registrar"></label>
                <div class="col-md-5">
                    <button id="btnregistrar" name="registrar" class="btn btn-primary">Registrar</button>
                </div>
            </div>

            <!-- Select Basic -->
            <!--<div class="form-group">
              <label class="col-md-4 control-label" for="Decision Timeframe">Decision Timeframe</label>
              <div class="col-md-5">
                <select id="Decision Timeframe" name="Decision Timeframe" class="form-control">
                  <option value="1">Select One</option>
                  <option value="2">As soon as possible</option>
                  <option value="3">1 to 3 months</option>
                  <option value="4">3 to 6 months</option>
                  <option value="">6+ months</option>
                </select>
              </div>
            </div>-->

            <!-- Select Multiple 
            <div class="form-group">
              <label class="col-md-4 control-label" for="Area of Interest">Area of Interest</label>
              <div class="col-md-5">
                <select id="Area of Interest" name="Area of Interest" class="form-control" multiple="multiple">
                  <option value="1">Please Select Area of Interest</option>
                  <option value="2">Purchase New</option>
                  <option value="3">Lease</option>
                  <option value="4">Rent</option>
                  <option value="5">Parts & Service</option>
                  <option value="">Other</option>
                </select>
              </div>
            </div>-->

        </fieldset>
    </form>

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
    {   $('#inputmodelo').val('');
        //validacion de moneda para los parametros
        $('.moneda').number(true, 2);
        $('.num').number(true,0,'','');
        //====para registrar un nuevo producto====
        $("#form_recepcion").submit(function (event) {
            event.preventDefault();
            var formData = new FormData($("#form_recepcion")[0]);
            $.ajax({
                url: $('#form_recepcion').attr('action'),
                type: "POST",
                data: formData, //$('#form_recepcion').serialize(),
                cache: false,
                contentType: false,
                processData: false,
                success: function (resp) {
                    jAlert("Exito! " + resp," Registro del producto",function (){
                        $("#form_recepcion")[0].reset();
                    });
                }
            });
        });
        //verificacion de existencia del modelo en bd mediante el helper inventario
        $('#inputmodelo').change(function () {
            var mod = $(this).val();
            $.post('<?php echo base_url() . "index.php/Inventario/existeModelo" ?>', {modelo: mod}, function (eco) {
                if (eco != 0)
                {
                    jConfirm("Usted ya tiene registrado el modelo " + mod + "\nDesea realizar la recepcion del stock", "Producto existente", function (r) {
                        if (r) {
                            window.location = "<?php echo base_url() . 'index.php/Inventario/reposicion/' ?>" + mod;
                        } else {
                            $('#inputmodelo').val('');
                            $('#inputmodelo').focus();
                        }
                    });
                }
            });
        });
    }
</script>
</body>
</html>


