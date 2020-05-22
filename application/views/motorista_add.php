<div class="row">
    <div class="col-sm-8 form-group">
        <?php
        echo form_label('Carteira de Habilitação');
        echo form_input('MOT_NumeroCnh', '', ' class="form-control" ');
        ?>
    </div>
    <div class="col-sm-4 form-group">
        <?php
        echo form_label('Data Validade CNH');
        echo form_date('MOT_DataValidadeCnh', '', ' class="form-control" ');
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group">
        <?php
        echo form_label('Categoria CNH');
        ?>
        <select name="MOT_Categoria" class="form-control">
            <option value="">Categoria</option>
            <option value="A">Categoria A</option>
            <option value="B">Categoria B</option>
            <option value="AB">Categoria AB</option>
            <option value="C">Categoria C</option>
            <option value="AC">Categoria AC</option>
            <option value="D">Categoria D</option>
            <option value="AD">Categoria AD</option>
            <option value="E">Categoria E</option>
            <option value="AE">Categoria AE</option>
        </select>
    </div>
</div> 