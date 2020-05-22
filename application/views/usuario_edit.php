 <div class="card">
     <?php
        echo form_open('usuario/update');
        $field_array = array('Login', 'Nome Completo', 'Senha', 'Setor', 'Perfil');
        echo form_hidden('USU_Id', $usuario[0]->USU_Id);
        $FUN_Id_Logado = $this->session->userdata('FUN_Id');
        if (($usuario[0]->FUN_Id == $FUN_Id_Logado) && ($FUN_Id_Logado == "2")) {
            $disabled = "disabled";
        }
        ?>
     <h5 class="card-header">
         <i class="fas fa-user-edit"></i>
         <?php echo $headline; ?>
     </h5>
     <div class="card-body">
         <div class="container">
             <div class="row">
                 <div class="col-sm-12 form-group">
                     <?php
                        echo form_label('Nome Completo');
                        echo form_input('USU_Nome', $usuario[0]->USU_Nome, 'title="Nome completo do usuário no sistema" class="required form-control" placeholder="Nome Completo"' . $disabled);
                        ?>
                 </div>
             </div>
             <div class="row">
                 <div class="col-sm-6 form-group">
                     <?php
                        echo form_label('Usuário');
                        echo form_input('USU_Login', $usuario[0]->USU_Login, 'title="Login do usuário no sistema" class="required form-control" placeholder="Login"' . $disabled);
                        ?>
                 </div>
                 <div class="col-sm-6 form-group">
                     <?php
                        echo form_label('Senha');
                        echo form_password('USU_Password', $usuario[0]->USU_Password, 'title="Senha para o usuário" class="required form-control" placeholder="Senha"');
                        ?>
                 </div>
             </div>

             <div class="row">
                 <div class="col-sm-6 form-group">
                     <?php
                        echo form_label('Email');
                        echo form_input('USU_Email', $usuario[0]->USU_Email, 'title="Email" class="form-control" placeholder="Email"' . $disabled);
                        ?>
                 </div>
                 <div class="col-sm-6 form-group">
                     <?php
                        echo form_label('Celular');
                        echo form_input('USU_Celular', $usuario[0]->USU_Celular, 'title="Celular" class="form-control" placeholder="Celular"' . $disabled);
                        ?>
                 </div>
             </div>
             <div class="row">
                 <div class="col-sm-6 form-group">
                     <?php echo form_label('Status'); ?>
                     <select name="USU_Ativo" title="Status do usuário no sistema" class="form-control" <?php echo $disabled; ?> required>
                         <option value="">Status</option>
                         <option value="Ativo" <?php if ($usuario[0]->USU_Ativo == "Ativo")
                                                    echo ('selected="selected"'); ?>>Ativo</option>
                         <option value="Inativo" <?php if ($usuario[0]->USU_Ativo == "Inativo")
                                                        echo ('selected="selected"'); ?>>Inativo</option>
                     </select>
                 </div>
                 <div class="col-sm-6 form-group">
                     <?php
                        echo form_label('Função'); ?>
                     <select name="FUN_Id" title="Função do usuário no sistema" class="required form-control" disabled>');
                         <?php
                            foreach ($funcoes->result() as $funcao) :
                                echo ('<option value="' . $funcao->FUN_Id . '"');
                                if ($funcao->FUN_Id == $usuario[0]->FUN_Id)
                                    echo ('selected="selected"');
                                echo ('>' . $funcao->FUN_Nome . '</option>');
                            endforeach;
                            echo ('</select>');
                            echo form_hidden('FUN_Id', $usuario[0]->FUN_Id);
                            ?>
                 </div>
             </div>
             <?php
                if ($usuario[0]->FUN_Id == 3) {
                    $this->load->view('motorista_edit');
                }
                ?>
             <?php
                if ($usuario[0]->FUN_Id == 4) {
                    $this->load->view('solicitante_edit');
                }
                ?>

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
 </div>
 <?php
    echo form_close();
    /* End of file usuario_edit.php */
    /* Location: ./system/application/views/usuario_edit.php */
    ?> 