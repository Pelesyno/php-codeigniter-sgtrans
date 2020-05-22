<?php if ($this->session->userdata('FUN_Id') == "3") { ?>
<li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'usuario') {
                                    echo 'active';
                                } else {
                                    echo '';
                                } ?>">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user"></i> Usuário
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <li class="nav-item">
        <a class="nav-item" href="<?php echo base_url('/index.php/usuario/edit/' . $this->session->userdata('USU_Id')); ?>"><i class="fas fa-user-edit"></i> Alterar Senha</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'solicitacao') {
                                        echo 'active';
                                    } else {
                                        echo '';
                                    } ?>">
        <a class="nav-link dropdown-toggle" href="#">
            <i class="fab fa-uber"></i> Solicitação
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="nav-item" href="<?php echo base_url('/index.php/solicitacao/listing'); ?>"><i class="fab fa-uber"></i> Visualizar Solicitações</a>
            </li>
        </ul>
    </li>
<?php 
} ?> 