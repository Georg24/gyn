<div class="col-sm-10">

    <form id="form_reposicion" class="form-horizontal"  role="form" action="<?= base_url() . 'index.php/Inventario/actualizacion' ?>" > 
        <fieldset>
            <div class="col-sm-12">
                <legend>Reposicion de Producto</legend>
            </div>
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="modelo">Modelo Codigo</label>  
                    <div class="col-md-5">
                        <input id="inputmodelo" name="modelo" type="text" class="form-control input-md" maxlength="49" required readonly value="<?php echo $producto->modelo; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="descripcion">Descripcion</label>  
                    <div class="col-md-5">
                        <textarea id="inputdescripcion" name="descripcion" class="form-control input-md" maxlength="250" required><?php echo $producto->descripcion; ?></textarea>
                    </div>
                </div>

                <div class="form-group <?php echo is_hidden();?>">
                    <label class="col-md-4 control-label" for="costo">Costo por unidad</label>  
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">Bs.-</span>
                            <input id="inputcosto" name="costo" type="text" class="moneda form-control input-md" value="<?php echo $producto->costo; ?>" maxlength="18" required>
                        </div>
                    </div>
                </div>        

                <div class="form-group">
                    <label class="col-md-4 control-label" for="precio_u">Precio de venta por Unidad</label>  
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">Bs.-</span>
                            <input id="inputpu" name="precio_u" type="text" class="moneda form-control input-md" value="<?php echo $producto->precio_u; ?>" maxlength="18" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="precio_m">Precio de venta por Mayor</label>  
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">Bs.-</span>
                            <input id="inputpm" name="precio_m" type="text" class="moneda form-control input-md" value="<?php echo $producto->precio_m; ?>" maxlength="18" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="minimo">Minimo en Inventario</label>  
                    <div class="col-md-5">
                        <div class="input-group">
                            <input id="inputminimo" name="minimo" type="text" class="num form-control input-md" value="<?php echo $producto->minimo; ?>" maxlength="9" required>
                            <span class="input-group-addon">pcs</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">
                        Existencia 
                    </label>
                    <div class="col-md-5">
                        <span class="text-primary h3"><?php echo $producto->existencia; ?></span>
                        <!--CAMPO OCULTO QUE TIENE LA EXISTENCIA ACTUAL-->
                        <input type="text" name="existactual" value="<?php echo $producto->existencia; ?>" hidden>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="existencia">
                        <span class="glyphicon glyphicon-arrow-right "></span>Reposición
                    </label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input id="inputpm" name="existencia" type="text" class="num form-control input-md" placeholder="ej: 200" maxlength="9" value="0" required autofocus>
                            <span class="input-group-addon">pcs</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="imagen">Cambiar imagen</label>  
                    <div class="col-md-5"> 
                        <input id="inputimagen" name="imagen" type="file" class="btn btn-sm">
                        <input id="inputimagenanterior" name="imagenanterior" type="text" value="<?php echo $producto->imagen?>" hidden>
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
                        <button id="btnregistrar" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-2 text-center">
                <p><label>Imagen Actual</label></p>
                <img src="<?php echo ($producto->imagen == "") ? base_url() . 'sources/ups/NULL' : base_url() . 'sources/ups/' . $producto->imagen; ?>"
                     style="margin-left: -200px;width: 20em;">
            </div>


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
    {
        //validacion de formato de numeros y moneda
        $('.moneda').number(true, 2);
        $('.num').number(true,0,'','');
        //====para registrar un nuevo producto====
        $('#inputmodelo').focus();
        $("#form_reposicion").submit(function (event) {
            event.preventDefault();
            var formData = new FormData($("#form_reposicion")[0]);
            $.ajax({
                url: $('#form_reposicion').attr('action'),
                type: "POST",
                data: formData, //$('#form_recepcion').serialize(),
                cache: false,
                contentType: false,
                processData: false,
                success: function (resp) {
                    jAlert("HECHO " + resp ,"Reposicion y Actualización",function (){
                        window.location="<?php echo base_url().'index.php/Inventario'?>";
                    });
                }
            });
        });
    }
</script>
</body>
</html>


