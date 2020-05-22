<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('modelo/update');
        echo form_hidden('MOD_Id', set_value('MOD_Id', isset($modelo[0]->MOD_Id) ? $modelo[0]->MOD_Id : ''));
    } else {
        echo form_open('modelo/create');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-car"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    //Montando Dropdown das Marcas
                    foreach ($marcas->result() as $marca) :
                        $marcass[$marca->MAR_Id] = $marca->MAR_Nome;
                    endforeach;
                    echo form_label('Marca', 'MAR_Id');
                    echo form_dropdown('MAR_Id', $marcass, set_value('MAR_Id', isset($modelo[0]->MAR_Id) ? $modelo[0]->MAR_Id : ""), 'class="form-control" id="VEI_Marca"');
                    echo form_error('MAR_Id');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Modelo', 'MOD_Nome');
                    echo form_input('MOD_Nome', set_value('MOD_Nome', isset($modelo[0]->MOD_Nome) ? $modelo[0]->MOD_Nome : ''), ' class="form-control"');
                    echo form_error('MOD_Nome');
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
    });
</script> 