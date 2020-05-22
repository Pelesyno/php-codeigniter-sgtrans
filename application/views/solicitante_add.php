<div class="row">
    <div class="col-sm-12 form-group">
        <?php
        echo form_label('Departamento');
        echo ('<select name="DEP_Id" class="form-control" >');
        echo ('<option value="">Departamento</option>');
        foreach ($departamentos->result() as $departamento) :
            echo ('<option value="' . $departamento->DEP_Id . '">' . $departamento->DEP_Nome . '</option>');
        endforeach;
        echo ('</select>');
        ?>
    </div>
</div> 