<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('servico/update', 'name="form_abastece"');
        echo form_hidden('SER_Id', set_value('SER_Id', isset($servico[0]->SER_Id) ? $servico[0]->SER_Id : ''));
    } else {
        echo form_open('servico/create', 'name="form_abastece"');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-gas-pump"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Descrição do Serviço');
                    echo form_input('SER_Nome', set_value('SER_Nome', isset($servico[0]->SER_Nome) ? $servico[0]->SER_Nome : ""), 'class="form-control" id="SER_Nome" ' . $edit );
                    echo form_error('SER_Nome');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Preço');
                    echo form_input('SER_Preco', set_value('SER_Preco', isset($servico[0]->SER_Preco) ? $servico[0]->SER_Preco : ""), ' class="form-control" ' . $edit );
                    echo form_error('SER_Preco');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Tempo Estimado');
                    echo form_input('SER_TempoEstimado', set_value('SER_TempoEstimado', isset($servico[0]->SER_TempoEstimado) ? $servico[0]->SER_TempoEstimado : ""), ' class="form-control" ' . $edit );
                    echo form_error('SER_TempoEstimado')
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