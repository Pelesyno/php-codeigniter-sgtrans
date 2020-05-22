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

$datas[] = 'Carregando';

?>
<div class="card">
    <?php echo form_open('solicitacao/create', 'name="form_abastece"'); ?>
    <h5 class="card-header">
        <i class="fab fa-uber"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Tipo de Veiculo');
                    echo form_dropdown('SOL_Tipo_Veiculo', $tipos, set_value('SOL_Tipo_Veiculo', isset($solicitacao[0]->SOL_Tipo_Veiculo) ? $solicitacao[0]->SOL_Tipo_Veiculo : ""), 'class="form-control" id="SOL_Tipo_Veiculo" required');
                    echo form_error('SOL_Tipo_Veiculo');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Quantidade de pessoas');
                    echo form_number('SOL_QPessoas', set_value('SOL_QPessoas', isset($solicitacao[0]->SOL_QPessoas) ? $solicitacao[0]->SOL_QPessoas : ""), 'class="form-control" min="1" required');
                    echo form_error('SOL_QPessoas');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Destino');
                    echo form_input('SOL_Destino', set_value('SOL_Destino', isset($solicitacao[0]->SOL_Destino) ? $solicitacao[0]->SOL_Destino : ""), 'class="form-control" required');
                    echo form_error('SOL_Destino');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Data');
                    echo form_dropdown('SOL_Data', $datas, set_value('SOL_Data', isset($solicitacao[0]->SOL_Data) ? $solicitacao[0]->SOL_Data : ""), 'class="form-control" id="SOL_Data" required disabled');
                    echo form_error('SOL_Data');
                    ?>
                </div>

                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Hora');
                    echo form_dropdown('SOL_Hora', $datas, set_value('SOL_Hora', isset($solicitacao[0]->SOL_Hora) ? $solicitacao[0]->SOL_Hora : ""), 'class="form-control" id="SOL_Hora" required disabled');
                    echo form_error('SOL_Hora');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                <?php
                    echo form_label('Duração');
                    echo form_input('SOL_Duracao', set_value('SOL_Duracao', isset($solicitacao[0]->SOL_Duracao) ? $solicitacao[0]->SOL_Duracao : ""),
                     'class="form-control" data-slider-id="ex1Slider" data-slider-min="30" data-slider-max="180" data-slider-step="30" data-slider-value="30" id="SOL_Duracao" required');
                    echo form_error('SOL_Duracao');
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
</script>
<script type="text/javascript">
    $(function() {
        var base_url = "<?php echo base_url(); ?>"
        $('#SOL_Tipo_Veiculo').change(function() {
            $('#SOL_Hora').attr('disabled', 'disabled');
            $('#SOL_Hora').html('<option>Carregando...</option>');
            var VEI_Tipo = $('#SOL_Tipo_Veiculo').val();
            $.post(base_url + 'index.php/solicitacao/verificarDatas', {
                VEI_Tipo: VEI_Tipo
            }, function(data) {
                console.log(data);
                $('#SOL_Data').html(data);
                $('#SOL_Data').removeAttr('disabled');
            });
        })
    });
</script>
<script type="text/javascript">
    $(function() {
        var base_url = "<?php echo base_url(); ?>"
        $('#SOL_Data').change(function() {
            var VEI_Tipo = $('#SOL_Tipo_Veiculo').val();
            var SOL_Data = $('#SOL_Data').val();
            $.post(base_url + 'index.php/solicitacao/verificarHoras', {
                VEI_Tipo: VEI_Tipo,
                SOL_Data: SOL_Data
            }, function(data) {
                console.log(data);
                $('#SOL_Hora').html(data);
                $('#SOL_Hora').removeAttr('disabled');
            });
        })
    });
</script>
<script>
    var slider = new Slider("#SOL_Duracao", {
        tooltip: 'always'
    });
</script>