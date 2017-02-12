<div class="col-sm-10"><!--este es el contenedor principal-->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <legend>
                Ventas del periodo
            </legend>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <form id="form_mes" class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/Expo/porPeriodo' ?>" target="_blank">
                <div class="form-group">
                    <label for="mes_inicio" class="control-label col-sm-1">Desde</label>
                    <div class="col-sm-2">
                        <select id="lista_inicio" class="form-control" name="mes_desde">
                            <?php
                            $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                            for ($i = 1; $i < 13; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == date('m')) ? 'selected' : ''; ?>><?php echo $meses[$i - 1]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control" type="number" name="anio_desde" value="<?php echo date('Y'); ?>" required max="<?php echo date('Y'); ?>" min="2016" style="width: 100px;">
                    </div>
                    <label for="mes_hasta" class="control-label col-sm-1">hasta</label>
                    <div class="col-sm-2">
                        <select id="lista_fin" class="form-control" name="mes_hasta">
                            <?php
                            for ($i = 1; $i < 13; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == date('m')) ? 'selected' : ''; ?>><?php echo $meses[$i - 1]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control" type="number" name="anio_hasta" value="<?php echo date('Y'); ?>" required max="<?php echo date('Y'); ?>" min="2016" style="width: 100px;">
                    </div>
                    <div class="col-sm-2">
                        <input id="submit_mes" type="submit" class="btn btn-primary" value="Generar Reporte">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <legend>
                Ingresos por producto
            </legend>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <form id="form_ingresos" class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/Expo/ganaciaPorProducto' ?>" target="_blank">
                <div class="form-group">
                    <label for="limite" class="control-label col-sm-1">Desde</label>
                    <div class="col-sm-2">
                        <select class="form-control input-md" name="limite" value="" required>
                            <option value="0">Todos</option>
                            <option value='20'>20</option>
                            <option value='30'>30</option>
                            <option value='50'>50</option>
                            <option value='70'>70</option>
                            <option value='100'>100</option>
                            <option value='150'>150</option>
                        </select>
                    </div>
                    <label for="limite" class="control-label col-sm-2 ">Orden</label>
                    <div class="col-sm-4">
                        <div class="col-sm-4 text-center">
                        Unidades Vendidas<br><input name="radio_orden" type="radio" class="" value="sumcantidad" checked></div>
                        <div class="col-sm-4 text-center">
                        Ingreso Neto<br><input name="radio_orden" type="radio" class="" value="neta"></div>
                        <div class="col-sm-4 text-center">
                        Ingreso Relativo<br><input name="radio_orden" type="radio" class="" value="porcentaje"></div>
                    </div>
                    <div class="col-sm-2 pull-right">
                        <input id="submit_mes" type="submit" class="btn btn-primary" value="Generar Reporte">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <legend>
                Reporte de ...
            </legend>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

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
<script>
    $(document).ready(function () {

    });
</script>