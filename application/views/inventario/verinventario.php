<div class="col-sm-10"><!--este es el contenedor principal-->
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h2 class="col-sm-12">
                <legend class="col-sm-4">Productos en inventario</legend>
                <a href="<?php echo base_url().'index.php/inventario'?>" class="btn btn-success btn-sm col-sm-2 pull-right">Mostrar todo</a>
                <form id="form_modesc" class="form-inline pull-right col-sm-4" action="<?php echo base_url();?>index.php/inventario/buscar/">
                    <datalist id="lista_productos">
                        <?php
                        //del helper productos
                        $desc = getModelosDescripcion();
                        foreach ($desc as $val) {
                            echo '<option value="' . $val->modelo . '"></option>';
                            echo '<option value="' . $val->descripcion . '"></option>';
                        }
                        ?>
                    </datalist>
                    <input id="input_buscar" type="text" list="lista_productos" class="input-sm form-control" autofocus required>
                    <input type="submit" class="btn btn-sm btn-info " value="Buscar" style="margin: 4px;">
                </form>
                
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 ">
            <table class="table table-hover table-responsive table-bordered table-condensed">
                <thead class="text-center">
                <th>Modelo</th><th>Descripcion</th>
                <!--COSTO solo si es admin desde main helper-->
                <?php if (is_admin())
                {
                    echo "<th>Costo</th>";
                }?>
                <th>P/m</th><th>P/u</th><th>Min.</th><th>Existencia</th><th>Repo.</th><th>Datos</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($productos as $prod) {
                        ?>

                        <tr><td class="td-imagen">
                                <img class="accional" src="<?php echo ($prod['imagen'] == "") ? base_url() . 'sources/ups/NULL' : base_url() . 'sources/ups/' . $prod['imagen']; ?>" >
                                <?= $prod['modelo']; ?>
                            </td>
                            <td><?= $prod['descripcion']; ?></td>
                            <?php if(is_admin()){?><td class="text-center"><?= $prod['costo']; }?></td>
                            <td class="text-center"><?= $prod['precio_m']; ?></td>
                            <td class="text-center"><?= $prod['precio_u']; ?></td>
                            <td class="text-center"><?= $prod['minimo']; ?></td>
                            <td class="text-center <?php echo($prod['existencia'] == 0) ? 'bg-danger' : ''; ?>"> <?= $prod['existencia']; ?></td>
                            <td class="text-center"><a href="<?php echo base_url() . 'index.php/Inventario/reposicion/' . urlencode($prod['modelo']); ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-refresh"></span></a></td>
                            <td class="text-center"><a href="<?php echo base_url() . 'index.php/Inventario/modificar/' . urlencode($prod['modelo']); ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <nav>
                <?php echo $paginacion; ?>
            </nav>
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
        $('.td-imagen').mouseover(function () {
            $(this).find('img.accional').show();
        });
        $('.td-imagen').mouseout(function () {
            $(this).find('img.accional').hide();
        });
        $('#form_modesc').submit(function (ev){
            ev.preventDefault();
            window.location=$(this).attr('action')+$('#input_buscar').val();
        });
    });
    
</script>