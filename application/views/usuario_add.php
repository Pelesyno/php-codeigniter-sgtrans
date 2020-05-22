<div class="card">
    <?php echo form_open('usuario/create'); ?>
    <h5 class="card-header">
        <i class="fas fa-users"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Nome Completo');
                    echo form_input('USU_Nome', '', 'title="Nome completo do usuário no sistema" class="form-control" placeholder="Nome Completo" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Usuário');
                    echo form_input('USU_Login', '', 'title="Login do usuário no sistema" class="form-control" placeholder="Login" required');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Senha');
                    echo form_password('USU_Password', '', 'title="Senha para o usuário" class="form-control" placeholder="Senha" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Email');
                    echo form_email('USU_Email', '', 'title="Email do Usuário" class="form-control" placeholder="Email"');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Celular');
                    echo form_input('USU_Celular', '', 'title="Celular do Usuário" class="form-control" placeholder="Celular"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Status');
                    echo ('<select name="USU_Ativo" title="Status do usuário no sistema" class="form-control" required>');
                    echo ('<option value="">Status</option>');
                    echo ('<option selected="selected value="Ativo">Ativo</option>');
                    echo ('<option value="Inativo">Inativo</option>');
                    echo ('</select>');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Função');
                    echo ('<select name="FUN_Id" onchange="javascript: chamaFuncao(this.value)" title="Perfil do usuário no sistema" class="form-control" required>');
                    echo ('<option value="">Função</option>');
                    $funcao_logada = $this->session->userdata('FUN_Id');
                    foreach ($funcoes->result() as $funcao) :

                        if ($funcao_logada == "1") {
                            if (($funcao->FUN_Id == "1") || ($funcao->FUN_Id == "2")) {
                                echo ('<option value="' . $funcao->FUN_Id . '">' . $funcao->FUN_Nome . '</option>');
                            }
                        } elseif ($funcao_logada == "2") {
                            if (($funcao->FUN_Id == "3") || ($funcao->FUN_Id == "4")) {
                                echo ('<option value="' . $funcao->FUN_Id . '">' . $funcao->FUN_Nome . '</option>');
                            }
                        }

                    endforeach;
                    echo ('</select>');
                    ?>
                </div>
            </div>
            <div id="nav-tabContent" class="tab-content">
                <div class="tab-pane fade" id="nav-solicitante" role="tabpanel" aria-labelledby="nav-solicitante-tab">
                    <?php $this->load->view('solicitante_add'); ?>
                </div>
                <div class="tab-pane fade" id="nav-motorista" role="tabpanel" aria-labelledby="nav-motorista-tab">
                    <?php $this->load->view('motorista_add'); ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo form_submit('', 'Cadastrar', 'class="btn btn-primary"');
        echo ' ';
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
    <?php echo form_close(); ?>

    <script>
        function chamaFuncao(NOME) {
            if (NOME == '4') { //SE FOR IGUAL A CPF NOME E FONE
                $('#nav-motorista').removeClass('show');
                $('#nav-motorista').removeClass('active');
                $('#nav-solicitante').addClass('active');
                $('#nav-solicitante').addClass('show');
                //$(this).parent().addClass('active'); 
                console.log('Div-Solicitante'); // ADICIONA OS ELEMENTOS NA DIV
                $('#nav-solicitante').show();
            } else if (NOME == '3') { //SE FOR IGUAL A CNPJ IE E RAZAO
                $('#nav-solicitante').removeClass('active');
                $('#nav-solicitante').removeClass('show');
                $('#nav-motorista').addClass('show');
                $('#nav-motorista').addClass('active');
                console.log('Div-Motorista'); // ADICIONA OS ELEMENTOS NA DIV
                $('#nav-motorista').show();
            }
        }
    </script>
</div>