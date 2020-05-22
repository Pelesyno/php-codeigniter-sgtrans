<div class="card">
    <?php echo form_open_multipart('ocorrencia/update'); ?>
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
                    echo form_hidden('OCO_Id', $ocorrencia[0]->OCO_Id);
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
                    foreach ($motorista->result() as $motorista) :
                        $motorista_nome = $this->MUsuario->getUsuario($motorista->USU_Id)->result();

                        if ($motorista_nome[0]->USU_Ativo == "Ativo") {
                            echo ('<option value="' . $motorista->USU_Id . '"');
                            if ($ocorrencia[0]->MOT_Id == $motorista->USU_Id) {
                                echo ('selected="selected"');
                            }
                            echo ('>' . $motorista_nome[0]->USU_Nome . '</option>');
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
                        echo ('<option value="' . $tipocorrencia->TOC_Id . '"');
                        if ($ocorrencia[0]->TOC_Id == $tipocorrencia->TOC_Id) {
                            echo ('selected="selected"');
                        }

                        echo ('>' . $tipocorrencia->TOC_Nome . '</option>');
                    endforeach;
                    echo ('</select>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data da Ocorrência');
                    echo form_date('OCO_Data', $ocorrencia[0]->OCO_Data, ' class="form-control" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Ocorrência');
                    echo form_textarea('OCO_Observacao', $ocorrencia[0]->OCO_Observacao, 'title="Ocorrência" class="form-control" placeholder="Ocorrência" required');
                    ?>
                </div>
            </div>
            <div class="row">
                <?php if (isset($ocorrencia[0]->OCO_Anexo1) && $ocorrencia[0]->OCO_Anexo1 != "") {
                    ?>
                <div class="col-sm-4" id="anexo1">
                    <div class="card" style="width: 18rem;">
                        <?php
                        $rest = substr($ocorrencia[0]->OCO_Anexo1, -3);
                        if ($rest != 'pdf') {
                            ?>
                        <img class="card-img-top" src="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo1) ?>" alt="Anexo Ocorrência 1">
                        <?php

                    } else {
                        ?>
                        <a class="btn btn-primary btn-block" target="_blank" href="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo1) ?>">Anexo 1</a>
                        <?php

                    }
                    ?>
                        <div class="card-footer">
                            <button type="button" id='anex1' class="btn btn-danger btn-block">Remover</button>
                        </div>
                    </div>
                </div>
                <?php

            } else {
                ?>
                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 1 da Ocorrência', 'OCO_Anexo1'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo1" id="OCO_Anexo1">
                </div>
                <?php

            } ?>
                <?php if (isset($ocorrencia[0]->OCO_Anexo2) && $ocorrencia[0]->OCO_Anexo2 != "") {
                    ?>
                <div class="col-sm-4" id="anexo2">
                    <div class="card" style="width: 18rem;">
                        <?php
                        $rest = substr($ocorrencia[0]->OCO_Anexo2, -3);
                        if ($rest != 'pdf') {
                            ?>
                        <img class="card-img-top" src="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo2) ?>" alt="Anexo Ocorrência 2">
                        <?php

                    } else {
                        ?>
                        <a class="btn btn-primary btn-block" target="_blank" href="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo2) ?>">Anexo 2</a>
                        <?php

                    }
                    ?>
                        <div class="card-footer">
                            <button type="button" id='anex2' class="btn btn-danger btn-block">Remover</button>
                        </div>
                    </div>
                </div>
                <?php

            } else {
                ?>
                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 2 da Ocorrência', 'OCO_Anexo2'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo2" id="OCO_Anexo2">
                </div>
                <?php

            } ?>
                <?php if (isset($ocorrencia[0]->OCO_Anexo3) && $ocorrencia[0]->OCO_Anexo3 != "") {
                    ?>
                <div class="col-sm-4" id="anexo3">
                    <div class="card" style="width: 18rem;">
                        <?php
                        $rest = substr($ocorrencia[0]->OCO_Anexo3, -3);
                        if ($rest != 'pdf') {
                            ?>
                        <img class="card-img-top" src="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo3) ?>" alt="Anexo Ocorrência 3">
                        <?php

                    } else {
                        ?>
                        <a class="btn btn-primary btn-block" target="_blank" href="<?php echo base_url('/assets/img/ocorrencias/' . $ocorrencia[0]->OCO_Anexo3) ?>">Anexo 3</a>
                        <?php

                    }
                    ?>
                        <div class="card-footer">
                            <button type="button" id='anex3' class="btn btn-danger btn-block">Remover</button>
                        </div>
                    </div>
                </div>
                <?php

            } else {
                ?>
                <div class="col-sm-4 form-group">
                    <?php echo form_label('Foto 3 da Ocorrência', 'OCO_Anexo3'); ?>
                    <input type="file" class="form-control" name="OCO_Anexo3" id="OCO_Anexo3">
                </div>
                <?php

            } ?>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo form_submit('', 'Atualizar', 'class="btn btn-primary"');
        echo ' ';
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $('#anex1').click(function name(e) {
        $('#anexo1').html('');
        $('#anexo1').html('<label for="OCO_Anexo1">Anexo 1 da Ocorrência</label><input type="file" class="form-control" name="OCO_Anexo1" id="OCO_Anexo1">');
    });
    $('#anex2').click(function name(e) {
        $('#anexo2').html('');
        $('#anexo2').html('<label for="OCO_Anexo2">Anexo 2 da Ocorrência</label><input type="file" class="form-control" name="OCO_Anexo2" id="OCO_Anexo2">');
    });
    $('#anex3').click(function name(e) {
        $('#anexo3').html('');
        $('#anexo3').html('<label for="OCO_Anexo3">Anexo 3 da Ocorrência</label><input type="file" class="form-control" name="OCO_Anexo3" id="OCO_Anexo3">');
    });
</script>

<?php
 /* End of file ocorrencia_edit.php */
/* Location: ./system/application/views/ocorrencia_edit.php */
?> 