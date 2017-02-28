<div class="container-fluid" id="cont_cuerpo">
    <div class="row">
        <div class="col-sm-2">        
            <div class="side-menu">                      
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <!-- Hamburger -->
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="visible-xs navbar-brand">Menu</span>
                    </div>
                    <!--<div class="navbar-collapse collapse sidebar-navbar-collapse">
                        <ul class="nav navbar-nav">
                    <?php
                    foreach ($menus as $menu) {
                        ?>
                                    <li class="<?= ($activo == $menu->menu) ? 'active' : ''; ?>" >
                                        <a href="<?= base_url() . $menu->enlace; ?>"><?= $menu->menu; ?> </a>
                                    </li>
                        <?php
                        //helper de menu_helper .. 
                        submenu_para($menu->id_menu, $activo);
                        ?>
                                    <li class="divider" role="separator"></li>
                        <?php
                    }
                    ?>
                        </ul>
                    </div>/.nav-collapse -->
                    <!-- Main Menu -->
                    <div class="side-menu-container">
                        <ul class="nav navbar-nav">

                            <li><a href="#"><span class="glyphicon glyphicon-send"></span> Link</a></li>
                            <li class="active"><a href="#"><span class="glyphicon glyphicon-plane"></span> Active Link</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li>

                            <!-- Dropdown-->
                            <li class="panel panel-default" id="dropdown">
                                <a data-toggle="collapse" href="#dropdown-lvl1">
                                    <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
                                </a>

                                <!-- Dropdown level 1 
                                <div id="dropdown-lvl1" class="panel-collapse collapse">
                                    <div class="panel-body"> 
                                        <ul class="nav navbar-nav">
                                            <li><a href="#">Link</a></li>
                                            <li><a href="#">Link</a></li>
                                            <li><a href="#">Link</a></li>

                                            <!-- Dropdown level 2 
                                            <li class="panel panel-default" id="dropdown">
                                                <a data-toggle="collapse" href="#dropdown-lvl2">
                                                    <span class="glyphicon glyphicon-off"></span> Sub Level <span class="caret"></span>
                                                </a>
                                                <div id="dropdown-lvl2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <ul class="nav navbar-nav">
                                                            <li><a href="#">Link</a></li>
                                                            <li><a href="#">Link</a></li>
                                                            <li><a href="#">Link</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
                            </li>

                            <li><a href="#"><span class="glyphicon glyphicon-signal"></span> Link</a></li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav> 
            </div>
        </div>
        <!--/ row y container fluid terminan en footer -->