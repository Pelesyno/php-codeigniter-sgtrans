<div class="card">
    <h5 class="card-header">
        <i class="far fa-building"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row text-right">
                <div class="col-sm-2">
                    <img class="card-img-top" src="<?php echo base_url() . 'assets/img/logo.png' ?>" alt="logo">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <?php
                    $texto1  = "Empresa: " . $empresa[0]->EMP_Nome;
                    echo form_input('cod_pedido0', $texto1, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    $texto4  = "CNPJ : " . $empresa[0]->EMP_Cnpj;
                    echo form_input('cod_pedido3', $texto4, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
                <div class="col-sm-2 form-group">
                    <?php
                    $texto3  = "Sigla: " . $empresa[0]->EMP_Sigla;
                    echo form_input('cod_pedido2', $texto3, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    $texto2  = "Endereço: " . $empresa[0]->EMP_Endereco;
                    echo form_input('cod_pedido1', $texto2, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    $texto5  = "Email: " . $empresa[0]->EMP_Email;
                    echo form_input('cod_pedido4', $texto5, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    $texto5  = "Telefone: " . $empresa[0]->EMP_Telefone;
                    echo form_input('cod_pedido4', $texto5, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    $texto5  = "Tolerância de Consumo de Combustível: " . $empresa[0]->EMP_Tolerancia . "%";
                    echo form_input('cod_pedido4', $texto5, 'disabled="disabled" class="form-control"');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        echo $Botao_Edit_Pedido = anchor('empresa/edit/' . $empresa[0]->EMP_Id, '<span class="btn btn-primary">Editar Dados </span>');
        ?>
    </div>
</div> 
