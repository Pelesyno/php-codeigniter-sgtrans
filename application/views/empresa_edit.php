<div class="card">
    <?php echo form_open_multipart('empresa/update'); ?>
    <h5 class="card-header">
        <i class="fas fa-building"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    echo form_label('Nome da Empresa');
                    echo form_input('EMP_Nome', $empresa[0]->EMP_Nome, ' class="input-block-level input-xlarge form-control"');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('CNPJ');
                    echo form_input('EMP_Cnpj', $empresa[0]->EMP_Cnpj, ' class="input-block-level input-large form-control"');
                    ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?php
                    echo form_label('Sigla');
                    echo form_input('EMP_Sigla', $empresa[0]->EMP_Sigla, ' class="input-block-level input-large form-control"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Endereço da Empresa');
                    echo form_input('EMP_Endereco', $empresa[0]->EMP_Endereco, ' class="input-block-level input-large form-control"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('E-mail Corporativo');
                    echo form_input('EMP_Email', $empresa[0]->EMP_Email, ' class="input-block-level input-large form-control"');
                    ?>
               </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Telefone de Contato');
                    echo form_input('EMP_Telefone', $empresa[0]->EMP_Telefone, ' class="input-block-level input-large form-control"');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Tolerância do Consumo de Combustível em %');
                    echo form_input('EMP_Tolerancia', $empresa[0]->EMP_Tolerancia, ' class="input-block-level input-large form-control"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php echo form_label('Logo', 'EMP_Logo'); ?>
                    <input type="file" class="form-control" name="EMP_Logo" id="EMP_Logo">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo form_submit('', 'Atualizar', 'class="btn btn-primary"');
        echo ' ';
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
    <?php echo form_close(); ?>
</div> 
