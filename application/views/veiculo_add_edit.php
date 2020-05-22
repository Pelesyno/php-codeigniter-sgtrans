<?php

//Montando Dropdown do tipo
$tipos[] = 'Tipo';
$tipos[1] = 'Hatch';
$tipos[2] = 'Sedã';
$tipos[3] = 'Van';
$tipos[4] = 'Picape';
$tipos[5] = 'SUV';
$tipos[6] = 'Micro-Ônibus';
$tipos[7] = 'Ônibus';

$ano = date('Y');

//Montando Dropdown das Marcas
foreach ($marcas->result() as $marca) :
    $marcass[$marca->MAR_Id] = $marca->MAR_Nome;
endforeach;

if (isset($veiculo[0]->VEI_Modelo)) {
    $modelo[$veiculo[0]->VEI_Modelo] = $veiculo[0]->MOD_Nome;
} else if (isset($_POST['VEI_Modelo'])) {
    $modelo[$_POST['VEI_Modelo']] = 'Selecione';
} else {
    $modelo[0] = 'Selecione a Marca';
}

if (isset($veiculo[0]->VEI_TipoPlaca) && $veiculo[0]->VEI_TipoPlaca == 1) {
    $VEI_TipoPlacaC = 'checked';
} elseif (isset($_POST['VEI_TipoPlaca']) && $_POST['VEI_TipoPlaca'] == 1) {
    $VEI_TipoPlacaC = 'checked';
} else {
    $VEI_TipoPlacaC = 'unchecked';
}

if (isset($veiculo[0]->VEI_TipoPlaca) && $veiculo[0]->VEI_TipoPlaca == 2) {
    $VEI_TipoPlacaM = 'checked';
} elseif (isset($_POST['VEI_TipoPlaca']) && $_POST['VEI_TipoPlaca'] == 2) {
    $VEI_TipoPlacaM = 'checked';
} else {
    $VEI_TipoPlacaM = 'unchecked';
}

//Montando dropdown dos Combustiveis
$combustivel[1] = 'Gasolina';
$combustivel[2] = 'Álcool';
$combustivel[3] = 'Diesel';
$combustivel[4] = 'Flex';

?>
<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('veiculo/update');
        echo form_hidden('VEI_Id', set_value('VEI_Id', isset($veiculo[0]->VEI_Id) ? $veiculo[0]->VEI_Id : ''));
    } else {
        echo form_open('veiculo/create');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-car"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <fieldset class="form-group">
                        <legend class="col-form-label pt=0">Tipo de Placa</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?php echo $VEI_TipoPlacaC; ?> name="VEI_TipoPlaca" id="VEI_TipoPlacaC" value="1" checked>
                            <label class="form-check-label" for="VEI_TipoPlacaC">
                                Convencional
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" <?php echo $VEI_TipoPlacaM; ?> name="VEI_TipoPlaca" id="VEI_TipoPlacaM" value="2">
                            <label class="form-check-label" for="VEI_TipoPlacaM">
                                Mercosul
                            </label>
                        </div>
                        <?php
                        echo form_error('VEI_TipoPlaca');
                        ?>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Placa do Veículo', 'VEI_Placa');
                    echo form_input('VEI_Placa', set_value('VEI_Placa', isset($veiculo[0]->VEI_Placa) ? $veiculo[0]->VEI_Placa : ''), 'class="form-control" id="VEI_Placa" style="text-transform: uppercase;"');
                    echo form_error('VEI_Placa');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('RENAVAM', 'VEI_Renavam');
                    echo form_input('VEI_Renavam', set_value('VEI_Renavam', isset($veiculo[0]->VEI_Renavam) ? $veiculo[0]->VEI_Renavam : ''), ' class="form-control" id="VEI_Renavam"');
                    echo form_error('VEI_Renavam');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Tipo', 'VEI_Tipo');
                    echo form_dropdown('VEI_Tipo', $tipos, set_value('VEI_Tipo', isset($veiculo[0]->VEI_Tipo) ? $veiculo[0]->VEI_Tipo : ''), 'class="form-control"');
                    echo form_error('VEI_Tipo'); ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Marca', 'VEI_Marca');
                    echo form_dropdown('VEI_Marca', $marcass, set_value('VEI_Marca', isset($veiculo[0]->VEI_Marca) ? $veiculo[0]->VEI_Marca : ""), 'class="form-control" id="VEI_Marca"');
                    echo form_error('VEI_Marca');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    echo form_label('Modelo', 'VEI_Modelo');
                    echo form_dropdown('VEI_Modelo', $modelo, set_value('VEI_Modelo', isset($veiculo[0]->VEI_Modelo) ? $veiculo[0]->VEI_Modelo : ""), 'class="form-control" id="VEI_Modelo"');
                    echo form_error('VEI_Modelo');
                    ?>
                </div>
                <div class="col-sm-3 form-group">
                    <?php
                    $data = date('d/m/Y');
                    $ano = substr($data, -4);
                    echo form_label('Ano de Frabicação');
                    echo form_number('VEI_AnoFabricacao', set_value('VEI_AnoFabricacao', isset($veiculo[0]->VEI_AnoFabricacao) ? $veiculo[0]->VEI_AnoFabricacao : ''), ' class="form-control" max-size="4" min="1990" max="' . $ano . '"');
                    echo form_error('VEI_AnoFabricacao');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Combustivel');
                    echo form_dropdown('VEI_Combustivel', $combustivel, isset($veiculo[0]->VEI_Combustivel) ? $veiculo[0]->VEI_Combustivel : "", 'class="form-control"');
                    echo form_error('VEI_Combustivel');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <?php
                    echo form_label('Capacidade Tanque - L');
                    echo form_number('VEI_CapacidadeTanque', set_value('VEI_CapacidadeTanque', isset($veiculo[0]->VEI_CapacidadeTanque) ? $veiculo[0]->VEI_CapacidadeTanque : ''), ' class="form-control" min="10"');
                    echo form_error('VEI_CapacidadeTanque');
                    ?>
                </div>
                <div class="col-md-4 form-group">
                    <?php
                    echo form_label('Cilindrada do Motor');
                    echo form_input('VEI_Cilindrada', set_value('VEI_Cilindrada', isset($veiculo[0]->VEI_Cilindrada) ? $veiculo[0]->VEI_Cilindrada : ''), ' class="form-control"');
                    echo form_error('VEI_Cilindrada');
                    ?>
                </div>
                <div class="col-md-4 form-group">
                    <?php
                    echo form_label('Consumo medio Km/L');
                    echo form_input('VEI_ConsumoMedio', set_value('VEI_ConsumoMedio', isset($veiculo[0]->VEI_ConsumoMedio) ? $veiculo[0]->VEI_ConsumoMedio : ''), ' class="form-control"');
                    echo form_error('VEI_ConsumoMedio');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Capacidade Pessoas');
                    echo form_number('VEI_CapacidadePessoas', set_value('VEI_CapacidadePessoas', isset($veiculo[0]->VEI_CapacidadePessoas) ? $veiculo[0]->VEI_CapacidadePessoas : ''), ' class="form-control" min="1"');
                    echo form_error('VEI_CapacidadePessoas');
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
        echo $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('form :input').change(function() {
            if ($(this).val() != $(this).data('valor')) {
                $('#btn-salvar').attr('disabled', false)
            } else {
                $('#btn-salvar').attr('disabled', true)
            }
        });
        $("#VEI_Renavam").mask("99999999999");
    });
</script>
<script type="text/javascript">
    $(function() {
        var base_url = "<?php echo base_url(); ?>"
        $('#VEI_Marca').change(function() {
            $('#VEI_Modelo').attr('disabled', 'disabled');
            $('#VEI_Modelo').html('<option>Carregando...</option>');
            var MAR_Id = $('#VEI_Marca').val();
            $.post(base_url + 'index.php/veiculo/getModelos', {
                MAR_Id: MAR_Id
            }, function(data) {
                $('#VEI_Modelo').html(data);
                $('#VEI_Modelo').removeAttr('disabled');
            });
        })
    });
</script> 