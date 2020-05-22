<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('peca/update');
        echo form_hidden('PEC_Id', set_value('PEC_Id', isset($peca[0]->PEC_Id) ? $peca[0]->PEC_Id : ''));
    } else {
        echo form_open('peca/create');
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
                    echo form_label('Descrição', 'PEC_Nome');
                    echo form_input('PEC_Nome', set_value('PEC_Nome', isset($peca[0]->PEC_Nome) ? $peca[0]->PEC_Nome : ''), ' class="form-control"');
                    echo form_error('PEC_Nome');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Preço', 'PEC_Preco');
                    echo form_input('PEC_Preco', set_value('PEC_Preco', isset($peca[0]->PEC_Preco) ? $peca[0]->PEC_Preco : ''), ' class="form-control"');
                    echo form_error('PEC_Preco');
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