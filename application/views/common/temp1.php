<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Georg
 * Date: 14/06/2016
 * Time: 06:34 PM
 */
?>
<div class="container-fluid" id="cont_cuerpo">
    <div class="row">
        <div class="col-sm-2">
            <?php include 'menu.php';?>    
        </div>
        <div class="col-sm-5" id="cont_medio">
            <div class="prueba">
            <form action="">
                <input type="search"><span class="glyphicon glyphicon-search"></span>
            </form>
            </div>
        </div>
        <div class="col-sm-5" id="cont_derecha">
            <div class="prueba">
                <?php echo $submenus[0]->id_menu;
                
                ?>
                
            </div>
        </div>
    </div>
</div>
