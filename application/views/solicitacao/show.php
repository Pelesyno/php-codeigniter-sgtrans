<div class="card">
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
                    echo form_label('Destino: <b>' . $solicitacao[0]->SOL_Destino . '</b>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Motorista: <b>' . $motorista . '</b>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Veicluo: <b>' . $veiculo . '</b>');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    switch ($solicitacao[0]->SOL_Status) {
                        case 0:
                            $status = 'Pendente';
                            break;
                        
                        case 1:
                            $status = 'Aprovado';
                            break;

                        case 2:
                            $status = 'Rejeitado';
                            break;

                        default:
                            $status = 'Pendente';
                            break;
                    }
                    echo form_label('Status da Solicitação: <b>' . $status . '</b>');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
</div>