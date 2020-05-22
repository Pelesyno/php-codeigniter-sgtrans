<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('posto/update');
        echo form_hidden('POS_Id', set_value('POS_Id', isset($posto[0]->POS_Id) ? $posto[0]->POS_Id : ''));
    } else {
        echo form_open('posto/create');
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
                    echo form_label('Razão Social');
                    echo form_input('POS_RazaoSocial', set_value('POS_RazaoSocial', isset($posto[0]->POS_RazaoSocial) ? $posto[0]->POS_RazaoSocial : ''), ' class="form-control" ');
                    echo form_error('POS_RazaoSocial');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Nome Fantasia');
                    echo form_input('POS_NomeFantasia', set_value('POS_NomeFantasia', isset($posto[0]->POS_NomeFantasia) ? $posto[0]->POS_NomeFantasia : ''), ' class="form-control" ');
                    echo form_error('POS_NomeFantasia');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('CNPJ');
                    echo form_input('POS_Cnpj', set_value('POS_Cnpj', isset($posto[0]->POS_Cnpj) ? $posto[0]->POS_Cnpj : ''), ' class="form-control" id="POS_Cnpj" ');
                    echo form_error('POS_Cnpj');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Telefone');
                    echo form_input('POS_Telefone', set_value('POS_Telefone', isset($posto[0]->POS_Telefone) ? $posto[0]->POS_Telefone : ''), ' class="form-control" id="POS_Telefone"');
                    echo form_error('POS_Telefone');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Endereço');
                    echo form_input('POS_Endereco', set_value('POS_Endereco', isset($posto[0]->POS_Endereco) ? $posto[0]->POS_Endereco : ''), ' class="form-control"');
                    echo form_error('POS_Endereco');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        if (isset($update)) {
            echo form_submit('', 'Atualizar', 'class="btn btn-primary"');
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
        $("#POS_Cnpj").mask("99.999.999/9999-99");
        $("#POS_Telefone").mask("(99)99999-9999");
    });
</script> 
