<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <img src="<?php echo base_url('assets/img/logo.png'); ?>" width="130" height="30" class="d-inline-block align-top rounded" alt="">
            <h3>SgTrans</h3>
        </div>
        <ul class="list-unstyled components">
            <li class="<?php if ($this->uri->segment(1) == 'transporte' && $this->uri->segment(2) == 'index') {
                            echo 'active';
                        } else {
                            echo '';
                        } ?>">
                <a data-bs-hover-animate="rubberBand" href="<?php echo base_url('/index.php/transporte/index'); ?>"><i class="fas fa-home"></i> Inicio <span class="sr-only">(current)</span></a>
            </li>
            <?php
            if ($this->session->userdata('FUN_Nome') == "Administrador") {
                $this->load->view('partials/menu/menuAdm');
            } elseif ($this->session->userdata('FUN_Nome') == "Operador") {
                $this->load->view('partials/menu/menuOpe');
            } elseif ($this->session->userdata('FUN_Nome') == "Solicitante") {
                $this->load->view('partials/menu/menuSol');
            } else {
                $this->load->view('partials/menu/menuMot');
            }
            ?>
            <li class="nav-item">
                <a data-bs-hover-animate="rubberBand" class="hvr-sweep-to-right nav-link" href="<?php echo base_url('/index.php/transporte/sair'); ?>"><i class="fas fa-door-closed"></i> Sair</a>
            </li>
        </ul>
    </nav>
    <div class="content">
        <nav class="navbar navbar-expand-md navbar-light bg-light">

            <button id="sidebarCollapse" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <a class="navbar-brand" href="#"><img src="<?php echo base_url('assets/img/logo.png'); ?>" width="130" height="30" class="d-inline-block align-top" alt=""> SgTrans</a>
                <ul class="navbar-nav">
                    <li class="nav-item home <?php if ($this->uri->segment(1) == 'transporte') {
                                                    echo 'active';
                                                } else {
                                                    echo '';
                                                } ?>">
                        <a data-bs-hover-animate="rubberBand" class="hvr-sweep-to-right nav-link" href="<?php echo base_url('/index.php/transporte/index'); ?>"><i class="fas fa-home"></i> Inicio</a>
                    </li>
                    <?php
                    if ($this->session->userdata('FUN_Nome') == "Administrador") {
                        $this->load->view('partials/menu/menuAdm');
                    } elseif ($this->session->userdata('FUN_Nome') == "Operador") {
                        $this->load->view('partials/menu/menuOpe');
                    } elseif ($this->session->userdata('FUN_Nome') == "Solicitante") {
                        $this->load->view('partials/menu/menuSol');
                    } else {
                        $this->load->view('partials/menu/menuMot');
                    }
                    ?>
                    <li class="nav-item">
                        <a data-bs-hover-animate="rubberBand" class="hvr-sweep-to-right nav-link" href="<?php echo base_url('/index.php/transporte/sair'); ?>"><i class="fas fa-door-closed"></i> Sair</a>
                    </li>
                </ul>
            </div>
            <div>
                <ul id="nav">
                    <li id="notification_li">
                        <span id="notification_count"></span>
                        <a href="#" id="notificationLink"><i class="fas fa-bell"></i></a>
                        <div id="notificationContainer">
                            <div id="notificationTitle">Notificações</div>
                            <div id="notificationsBody" class="notifications">
                                <ul class="menu"></ul>
                            </div>
                            <div id="notificationFooter"><a href="<?php echo base_url('/index.php/notificacoes/listing'); ?>">Ver Todos</a></div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#notificationLink").click(function() {
                    $("#notificationContainer").fadeToggle(300);
                    $("#notification_count").fadeOut("slow");
                    return false;
                });

                $(document).click(function() {
                    $("#notificationContainer").hide();
                });

                function get_notifications() {
                    var base_url = "<?php echo base_url(); ?>"
                    $.post(base_url + 'index.php/notificacoes/index', function(data) {
                        data = JSON.parse(data);
                        $('#notification_count').html(data['notification_count']);
                        data.notifications.forEach(function(o, index) {
                            if(o.NOT_Read == 1){
                                var li = '<li class="noRead"><a href="#">' + o.NOT_Table + '</a></li>'; 
                            }else{
                                var li = '<li><a href="#">' + o.NOT_Table + '</a></li>'; 
                            }
                            $('.menu').append(li);
                        });
                    });
                }
                get_notifications();
            });
        </script>