<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('marca/update');
        echo form_hidden('MAR_Id', set_value('MAR_Id', isset($marca[0]->MAR_Id) ? $marca[0]->MAR_Id : ''));
    } else {
        echo form_open('marca/create');
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
                    echo form_label('Marca', 'MAR_Nome');
                    echo form_input('MAR_Nome', set_value('MAR_Nome', isset($marca[0]->MAR_Nome) ? $marca[0]->MAR_Nome : ''), ' class="form-control"');
                    echo form_error('MAR_Nome');
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