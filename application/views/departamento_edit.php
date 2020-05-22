<div class="card">
    <?php echo form_open('departamento/update'); ?>
    <h5 class="card-header">
        <i class="fas fa-address-book"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Departamento');
                    echo form_hidden('DEP_Id', $departamento[0]->DEP_Id);
                    echo form_input('DEP_Nome', $departamento[0]->DEP_Nome, ' class="form-control" required');
                    ?>
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