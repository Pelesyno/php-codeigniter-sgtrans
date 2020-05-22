<?php 
//Montando dropdown dos Tipo
$estado_tanque = array('' => 'Selecione o Nível');
$estado_tanque[1] = 'Tanque na Reserva';
$estado_tanque[2] = 'Tanque - 1/4';
$estado_tanque[3] = 'Tanque - 1/2';
$estado_tanque[4] = 'Tanque - 3/4';

//Montando dropdown dos Combustiveis
$combustivel = array('' => 'Selecione o Combustível');
$combustivel[1] = 'Gasolina';
$combustivel[2] = 'Álcool';
$combustivel[3] = 'Diesel';
$combustivel[4] = 'Flex';

//Montando Dropdown dos Postos
$postoss = array('' => 'Selecione o Posto');
foreach ($postos->result() as $posto) :
    $postoss[$posto->POS_Id] = $posto->POS_RazaoSocial;
endforeach;

//Montando Dropdown dos Motoristas
$motoristass = array('' => 'Selecione o Motorista');
foreach ($motoristas->result() as $motorista) :
    if ($motorista->FUN_Id == 2 || $motorista->FUN_Id == 3) {
        $motoristass[$motorista->USU_Id] = $motorista->USU_Nome;
    }
endforeach;

//Montando Dropdown dos Veiculos
$veiculoss = array('' => 'Selecione o Veículo');
foreach ($veiculos->result() as $veiculo) :
    $veiculoss[$veiculo->VEI_Id] = $veiculo->MOD_Nome . " " . $veiculo->VEI_Cilindrada . " - " . $veiculo->VEI_Placa;
endforeach;
?>

<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('abastece/update', 'name="form_abastece"');
        echo form_hidden('ABA_Id', set_value('ABA_Id', isset($abastece[0]->ABA_Id) ? $abastece[0]->ABA_Id : ''));
    } else {
        echo form_open('abastece/create', 'name="form_abastece"');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-gas-pump"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Veiculo Abastecido - Placa');
                    echo form_dropdown('VEI_Id', $veiculoss, set_value('VEI_Id', isset($abastece[0]->VEI_Id) ? $abastece[0]->VEI_Id : ""), 'class="form-control" id="VEI_Id" ' . $edit . ' required');
                    echo form_error('VEI_Id');
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo form_label('Motorista Responsavél pelo Abastecimento');
                    echo form_dropdown(
                        'USU_Id',
                        $motoristass,
                        set_value('USU_Id', isset($abastece[0]->USU_Id) ? $abastece[0]->USU_Id : ""),
                        'class="form-control" id="USU_Id" ' . $edit . ' required'
                    );
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Posto');
                    echo form_dropdown('POS_Id', $postoss, set_value('POS_Id', isset($abastece[0]->POS_Id) ? $abastece[0]->POS_Id : ""), ' class="form-control" ' . $edit . ' required');
                    echo form_error('POS_Id');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Valor Abastecido');
                    echo form_input('ABA_ValorAbastecido', set_value('ABA_ValorAbastecido', isset($abastece[0]->ABA_ValorAbastecido) ? number_format($abastece[0]->ABA_ValorAbastecido, 2, ',', '.') : ""), ' class="form-control" ' . $edit . ' required');
                    echo form_error('ABA_ValorAbastecido')
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Odometro Abastecimento anterior');
                    echo form_input('ABA_OdometroAntigo', 0, ' disabled=disabled class="form-control" id="ABA_OdometroAntigo"');
                    echo form_error('ABA_OdometroAntigo');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Odometro Abastecimento atual');
                    echo form_number('ABA_Odometro', set_value('ABA_Odometro', isset($abastece[0]->ABA_Odometro) ? $abastece[0]->ABA_Odometro : ""), ' class="form-control" id="ABA_Odometro" required');
                    echo form_error('ABA_Odometro');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Litros Abastecidos');
                    echo form_input('ABA_Litros', set_value('ABA_Litros', isset($abastece[0]->ABA_Litros) ? number_format($abastece[0]->ABA_Litros, 2, ',', '.') : ""), ' class="form-control" ' . $edit . ' required');
                    echo form_error('ABA_Litros');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Data do Abastecimento');
                    echo form_date('ABA_Data', set_value('ABA_Data', isset($abastece[0]->ABA_Data) ? $abastece[0]->ABA_Data : date("Y-m-d")), ' class="form-control" id="ABA_Data" ' . $edit . ' required');
                    echo form_error('ABA_Data');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Combustível Utilizado');
                    echo form_dropdown('ABA_Combustivel', $combustivel, set_value('ABA_Combustivel', isset($abastece[0]->ABA_Combustivel) ? $abastece[0]->ABA_Combustivel : ""), 'class="form-control" id="ABA_Combustivel" ' . $edit . ' required');
                    echo form_error('ABA_Combustivel');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Nível antes do Abastecimento');
                    echo form_dropdown('ABA_EstadoTanque', $estado_tanque, set_value('ABA_EstadoTanque', isset($abastece[0]->ABA_EstadoTanque) ? $abastece[0]->ABA_EstadoTanque : ""), 'class="form-control" id="ABA_EstadoTanque" ' . $edit . ' required');
                    echo form_error('ABA_EstadoTanque');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        if (isset($update)) {
            echo form_submit('', 'Atualizar', 'class="btn btn-primary" id="btn-salvar" disabled');
        } else {
            echo form_submit('', 'Cadastrar', 'class="btn btn-primary"');
        }
        echo ' ';
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>

    <?php
    echo form_close(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var odometro = 0;

        $('form :input').change(function() {
            if ($(this).val() != $(this).data('valor')) {
                $('#btn-salvar').attr('disabled', false)
            } else {
                $('#btn-salvar').attr('disabled', true)
            }
        });
    });
    $(function() {
        var base_url = "<?php echo base_url(); ?>"
        $('#VEI_Id').change(function() {
            var VEI_Id = $('#VEI_Id').val();
            $.getJSON(base_url + 'index.php/abastece/getOdometro/' + VEI_Id, function(response) {
                odometro = response['odometro'];
                newOdometro = parseInt(odometro) + parseInt(response['autonomia']);
                combustivel = response['combustivel'];

                $('#ABA_Combustivel').val(combustivel);
                $('#ABA_OdometroAntigo').val(odometro);
                $('#ABA_Odometro').val(newOdometro);
                document.form_abastece.ABA_Odometro.setAttribute("min", odometro);
            });
        })
    });
</script> 