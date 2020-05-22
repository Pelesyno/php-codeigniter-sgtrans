<div class="card">
    <h5 class="card-header">
        <div class="row">
            <div class="col-sm-8"><i class="fas fa-address-book"></i>
                <?php echo $headline;
                ?></div>
            <div class="col-sm-4 text-right">
                <?php
                echo anchor('tipoocorrencia/add/', '<span class="btn btn-primary">Adicionar Tipo de Ocorrência </span>');
                ?>
            </div>
        </div>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 form-group"></div>
                <div class="col-sm-8 form-group">
                    <?php
                    echo $data_table; ?>
                </div>
                <div class="col-sm-2 form-group"></div>
            </div>
        </div>
    </div>
</div> 