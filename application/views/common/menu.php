<div class="container-fluid" id="cont_cuerpo">
    <div class="row">
        <div class="col-sm-2">        
            <div class="sidebar-nav">                      
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="visible-xs navbar-brand">Menu</span>
                    </div>
                    <div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            $color = ['darkblue', 'orangered', 'green', 'steelblue', 'darkred']; //colores de la hoja de estilos style.css
                            $i = 0; //para la iteracion de colores
                            foreach ($menus as $menu) {
                                $submenus = get_submenu($menu->id_menu);
                                if(sizeof($submenus)>0)
                                {
                                ?>
                                <li class="navbar-separator-<?= $color[($i) % 5]; ?>">
                                    <?= $menu->menu; ?>
                                </li>
                                <?php
                                
                                foreach ($submenus as $sub):
                                    if ($activo == $sub->submenu) {
                                        ?>
                                        <li class="<?= ($activo == $sub->submenu) ? 'active' : ''; ?>" style="border-right: 5px solid <?= $color[$i % 5]; ?>">
                                            <a href="<?= base_url() . $sub->enlace; ?>"><?= $sub->submenu; ?> </a>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="<?= base_url() . $sub->enlace; ?>"><?= $sub->submenu; ?> </a></li>
                                        <?php
                                    }
                                endforeach;
                                }
                                $i++;
                            }
                            ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div> 
            </div>
        </div>
        <!--/ row y container fluid terminan en footer -->