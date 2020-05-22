<?php if ($this->session->userdata('FUN_Id') == "2") { ?>
    <li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'usuario') {
                                        echo 'active';
                                    } else {
                                        echo '';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#">
            <i class="fas fa-user"></i> Usuários
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/usuario/add'); ?>"><i class="fas fa-users"></i> Cadastrar Usuários</a>
            </li>
            <div class="dropdown-divider"></div>
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/usuario/listing'); ?>"><i class="fas fa-user-edit"></i> Listar usuários Ativos</a>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'veiculo') {
                                        echo 'active';
                                    } else {
                                        echo '';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#">
            <i class="fas fa-car"></i> Veiculos
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/veiculo/add'); ?>"><i class="fas fa-car"></i></i> Cadastrar Veiculo</a>
            </li>
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/veiculo/listing'); ?>"><i class="fas fa-car-side"></i></i> Visualizar Veiculos</a>
            </li>
            <div class="dropdown-divider"></div>
            <li class="nav-item dropdown">
                <a class="nav-item dropdown-toggle" href="#">
                    <i class="fas fa-car"></i> Marca
                </a>
                <ul class="dropdown-menu submenu">
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/marca/add'); ?>"><i class="fas fa-car"></i></i> Cadastrar Marca</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/marca/listing'); ?>"><i class="fas fa-car-side"></i></i> Visualizar Marcas</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-item dropdown-toggle" href="#">
                    <i class="fas fa-car"></i> Modelo
                </a>
                <ul class="dropdown-menu submenu">
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/modelo/add'); ?>"><i class="fas fa-car"></i></i> Cadastrar Modelo</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/modelo/listing'); ?>"><i class="fas fa-car-side"></i></i> Visualizar Modelos</a>
                    </li>
                </ul>
            </li>
            <div class="dropdown-divider"></div>
            <li class="nav-item dropdown">
                <a class=" nav-item dropdown-toggle" href="#">
                    <i class="fas fa-clipboard-list"></i> Ocorrências
                </a>
                <ul class="dropdown-menu submenu">
                    <li>
                        <a class="nav-item dropdown-item" href="<?php echo base_url('/index.php/ocorrencia/listing'); ?>"><i class="fas fa-clipboard-list"></i></i> Listar Ocorrências</a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/tipoocorrencia/add'); ?>"><i class="fas fa-clipboard"></i></i> Cadastrar Tipo de Ocorrência</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/tipoocorrencia/listing'); ?>"><i class="fas fa-clipboard"></i></i> Listar Tipos de Ocorrências</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-item dropdown-toggle" href="#">
                    <i class="fas fa-gas-pump"></i> Abastecimentos
                </a>
                <ul class="dropdown-menu submenu">
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/abastece/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Abastecimento</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/abastece/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Abastecimentos</a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/posto/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Posto</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/posto/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Postos</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-item dropdown-toggle" href="#">
                    <i class="fas fa-gas-pump"></i> Manutenções
                </a>
                <ul class="dropdown-menu submenu">
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/manutencao/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Manutenção</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/manutencao/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Manutenção</a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/oficina/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Oficina</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/oficina/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Oficinas</a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/peca/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Peça</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/peca/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Peças</a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/servico/add'); ?>"><i class="fas fa-gas-pump"></i></i> Cadastrar Serviço</a>
                    </li>
                    <li>
                        <a class="nav-item" href="<?php echo base_url('/index.php/servico/listing'); ?>"><i class="fas fa-gas-pump"></i></i> Visualizar Serviços</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'solicitacao') {
                                        echo 'active';
                                    } else {
                                        echo '';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#">
            <i class="fab fa-uber"></i> Solicitação
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/solicitacao/add'); ?>"><i class="fab fa-uber"></i> Cadastrar Solicitação</a>
            </li>
            <div class="dropdown-divider"></div>
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/solicitacao/listing'); ?>"><i class="fab fa-uber"></i> Visualizar Solicitações</a>
            </li>
        </ul>
    </li>
<?php
} ?>