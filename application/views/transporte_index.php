<div class="row">
    <div class="col-sm-12">
        <div class="card text-center">
            <h5 class="card-header">
                Seja Bem-Vindo ao SG Transportes!
            </h5>
            <div class="card-body">
                <p class="card-text">Este &#233; o Sistema de Gerenciamento de Transportes, desenvolvido para a realiza&#231;&#227;o das solicitações de transportes e gerenciamento da da frota de veículos
                    da sua empresa.</p>
                <p class="card-text">Em caso de d&#250;vidas referente ao uso do sistema por favor entre em contato com os desenvolvedores</p>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/veiculo/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Frota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $veiculos->num_rows() . ' Veiculos' ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-left-success shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/usuario/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Motoristas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $motoristas->num_rows() . ' Motoristas'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-left-info shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/posto/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Posto</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $postos->num_rows() . ' Postos'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gas-pump fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-sm-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/notificacoes/ipva'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">IPVA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ipva->num_rows() . ' Vencendo / Vencido'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card border-left-Maroon shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/notificacoes/habilitacao'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-maroon text-uppercase mb-1">Habilitação</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $habilitacao->num_rows() . ' Vencendo / Vencida'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div> 
<br>
<div class="row">
<div class="col-sm-4">
        <div class="card border-left-navy shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/ocorrencia/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-navy text-uppercase mb-1">Ocorrencias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ocorrencias->num_rows() . ' Registradas'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-left-purple shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/ocorrencia/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-purple text-uppercase mb-1">Manutenções Pendentes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ocorrencias->num_rows() . ' Veiculos.'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="card border-left-black shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/ocorrencia/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">Alto Consumo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ocorrencias->num_rows() . ' Veiculos.'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div> 
<br>
<div class="row">
    <div class="col-sm-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <a href="<?php echo base_url('/index.php/ocorrencia/listing'); ?>" class="btn text-left">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Solicitações Pendentes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ocorrencias->num_rows(); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div> 