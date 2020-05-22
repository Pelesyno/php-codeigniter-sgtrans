<div class="row">
    <div class="col-sm-12 form-group">
        <?php
        echo form_label('Departamento');
        echo('<select name="DEP_Id" title="Departamento do usuário" class="required form-control" ' . $disabled . '>');
        foreach ($departamentos->result() as $departamento):
            echo('<option value="' . $departamento->DEP_Id . '"');
            if ($departamento->DEP_Id == $solicitante[0]->DEP_Id)
                echo('selected="selected"');
            echo('>' . $departamento->DEP_Nome . '</option>');
        endforeach;
        echo('</select>');
        ?>
    </div>
</div>