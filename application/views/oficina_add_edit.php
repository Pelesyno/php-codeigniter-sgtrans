<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('oficina/update');
        echo form_hidden('OFI_Id', set_value('OFI_Id', isset($oficina[0]->OFI_Id) ? $oficina[0]->OFI_Id : ''));
    } else {
        echo form_open('oficina/create');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-screwdriver"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Razão Social');
                    echo form_input('OFI_RazaoSocial', set_value('OFI_RazaoSocial', isset($oficina[0]->OFI_RazaoSocial) ? $oficina[0]->OFI_RazaoSocial : ''), ' class="form-control" ');
                    echo form_error('OFI_RazaoSocial');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Fantasia');
                    echo form_input('OFI_Fantasia', set_value('OFI_Fantasia', isset($oficina[0]->OFI_Fantasia) ? $oficina[0]->OFI_Fantasia : ''), ' class="form-control" ');
                    echo form_error('OFI_Fantasia');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('CNPJ');
                    echo form_input('OFI_Cnpj', set_value('OFI_Cnpj', isset($oficina[0]->OFI_Cnpj) ? $oficina[0]->OFI_Cnpj : ''), ' class="form-control" id="OFI_Cnpj" ');
                    echo form_error('OFI_Cnpj');
                    ?>
                </div>
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Telefone');
                    echo form_input('OFI_Telefone', set_value('OFI_Telefone', isset($oficina[0]->OFI_Telefone) ? $oficina[0]->OFI_Telefone : ''), ' class="form-control" id="OFI_Telefone"');
                    echo form_error('OFI_Telefone');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Endereço');
                    echo form_input('OFI_Endereco', set_value('OFI_Endereco', isset($oficina[0]->OFI_Endereco) ? $oficina[0]->OFI_Endereco : ''), ' class="form-control"');
                    echo form_error('OFI_Endereco');
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
        $("#OFI_Cnpj").mask("99.999.999/9999-99");
        $("#OFI_Telefone").mask("(99)99999-9999");
    });
</script> 