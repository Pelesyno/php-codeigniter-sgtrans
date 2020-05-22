<?php
//Montando Dropdown de Motoristas
$motoristass = array('' => 'Selecione o Motorista');
foreach ($motoristas->result() as $motorista) :
    $motoristass[$motorista->USU_Id] = $motorista->USU_Nome;
endforeach;

//Montando Dropdown de Veiculos
$veiculoss = array('' => 'Selecione o Veiculo');
foreach ($veiculos->result() as $veiculo) :
    $veiculoss[$veiculo->VEI_Id] = $veiculo->VEI_Placa;
endforeach;
?>
<div class="card">
    <?php echo form_open('solicitacao/update', 'name="form_abastece"'); ?>
    <h5 class="card-header">
        <i class="fab fa-uber"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
        <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Solicitante: <b>' . $solicitacao[0]->USU_Nome . '</b>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Tipo de Veiculo Solicitado: <b>' . $solicitacao[0]->TVE_Nome . '</b>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Data Solicitada: <b>' . mysql_to_pt($solicitacao[0]->SOL_Data) . ' - ' . $solicitacao[0]->SOL_Hora . '</b>');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_hidden('SOL_Id', set_value('SOL_Id', isset($solicitacao[0]->SOL_Id) ? $solicitacao[0]->SOL_Id : ''));
                    echo form_label('Motorista');
                    echo form_dropdown(
                        'SOL_MOT_Id',
                        $motoristass,
                        set_value('SOL_MOT_Id', isset($solicitacao[0]->SOL_MOT_Id) ? $solicitacao[0]->SOL_MOT_Id : ""),
                        'class="form-control" id="SOL_MOT_Id" required'
                    );
                    echo form_error('SOL_MOT_Id');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Veiculo');
                    echo form_dropdown(
                        'SOL_Veiculo',
                        $veiculoss,
                        set_value('SOL_Veiculo', isset($solicitacao[0]->SOL_Veiculo) ? $solicitacao[0]->SOL_Veiculo : ""),
                        'class="form-control" id="SOL_Veiculo" required'
                    );
                    echo form_error('SOL_Veiculo');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo form_submit('', 'Aprovar Solicitação', 'class="btn btn-success" id="btn-salvar"');
        echo ' ';
        echo anchor('solicitacao/rejeitar/'.$solicitacao[0]->SOL_Id, '<span class="btn btn-danger">Rejeitar Solicitação</span>');
        echo ' ';
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>

    <?php
    echo form_close(); ?>
</div>