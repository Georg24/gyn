<div class="col-sm-10"><!--este es el contenedor principal-->
    <div class="row">
         <div class="col-sm-10 col-sm-offset-1">
            <legend>
                Reporte de ventas
            </legend>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover table-responsive table-bordered table-condensed">
                <thead>
                <th>Cod Venta</th><th>Usuario</th><th>Cliente</th><th>Fecha</th><th>Total</th>
                </thead>
                <tbody>
                <?php
                foreach ($tabla as $dato){
                    ?>
                    <tr>
                        
                        <td><?= $dato->cod_venta ?></td>
                        <td><?= $dato->ci ?></td>
                        <td><?= $dato->id_cliente ?></td>
                        <td><?= $dato->fecha ?></td>
                        <td><?= $dato->total ?></td>
                        <td><button class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></button></td>
                        <td><button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-sm-offset-8 ">
            <h2><label class="label label-primary">Sumatoria de ventas</label>
            <input class=" text-center col-md-4 form-control input-lg pull-right" value="<?php echo $suma[0]->todo?>"></h2>
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
    $(document).ready(function (){
        
    });
</script>