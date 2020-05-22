<div class="card">
    <h5 class="card-header">
        <div class="row">
            <div class="col-sm-8"><i class="fas fa-users"></i>
                <?php echo $headline;
                ?></div>
            <div class="col-sm-4 text-right">
                <?php
                echo anchor('usuario/add/', '<span class="btn btn-primary">Adicionar Usuario </span>');
                ?>
            </div>
        </div>
    </h5>
    <div class="card-body">
        <div class="table-responsive">
            <?php echo $data_table; ?>
        </div>
    </div>
</div>
<?php
if ($funcao == "1") {
    echo br();
    ?>
<div class="card">
    <div class="card-header  text-white bg-danger">
        <i class="fas fa-user-secret"></i>
        <?php echo $headline2; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php echo $data_table2; ?>
        </div>
    </div>
</div>
<?php

}
/* End of file usuario_listing.php */
/* Location: ./application/controllers/usuario_listing.php */
?> 