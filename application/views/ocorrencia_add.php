<div class="card">
    <?php echo form_open_multipart('ocorrencia/create'); ?>
    <h5 class="card-header">
        <i class="fas fa-users"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Veiculo');
                    echo form_input('', $modelo[0]->MOD_Nome, 'disabled=disabled title="Login do usuário no sistema" class="form-control" placeholder="Login" required');
                    echo form_hidden('VEI_Id', $veiculo[0]->VEI_Id);
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Placa do Veiculo');
                    echo form_input('', $veiculo[0]->VEI_Placa, 'disabled=disabled title="Nome completo do usuário no sistema" class="form-control" placeholder="Nome Completo" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php

                    echo form_label('Motorista');
                    echo ('<select name="MOT_Id" title="Motorista" class="form-control" required>');
                    echo ('<option value="">Motorista</option>');
                    foreach ($motorista->result() as $motorista) :
                        $motorista_nome = $this->MUsuario->getUsuario($motorista->USU_Id)->result();
                        if ($motorista_nome[0]->USU_Ativo == "Ativo") {
                            echo ('<option value="' . $motorista_nome[0]->USU_Id . '">' . $motorista_nome[0]->USU_Nome . '</option>');
                        }
                    endforeach;
                    echo ('</select>');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php

                    echo form_label('Tipo de Ocorrência');
                    echo ('<select name="TOC_Id" title="TipoOcorrencia" class="form-control" required>');
                    echo ('<option value="">Tipo de Ocorrência</option>');
                    foreach ($tipoocorrencia->result() as $tipocorrencia) :
                        echo ('<option value="' . $tipocorrencia->TOC_Id . '">' . $tipocorrencia->TOC_Nome . '</option>');
                    endforeach;
                    echo ('</select>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data da Ocorrência');
                    echo form_date('OCO_Data', date("Y-m-d"), ' class="form-control" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Ocorrência');
                    echo form_textarea('OCO_Observacao', '', 'title="Ocorrência" class="form-control" placeholder="Ocorrência" required');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 1 da Ocorrência', 'OCO_Anexo1'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo1" id="OCO_Anexo1">
                </div>

                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 2 da Ocorrência', 'OCO_Anexo2'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo2" id="OCO_Anexo2">
                </div>

                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 3 da Ocorrência', 'OCO_Anexo3'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo3" id="OCO_Anexo3">
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

</div>

<?php
 /* End of file ocorrencia_add.php */
/* Location: ./system/application/views/ocorrencia_add.php */
?> 