<?php if ($this->session->userdata('FUN_Id') == "1") { ?>
<li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'usuario') {
                                    echo 'active';
                                } else {
                                    echo '';
                                } ?>">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user"></i> Usuários
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <li class="nav-item">
            <a class="nav-item" href="<?php echo base_url('/index.php/usuario/add'); ?>"><i class="fas fa-users"></i> Cadastrar Usuários</a>
        </li>
        <div class="dropdown-divider"></div>
        <li class="nav-item">
            <a class="nav-item" href="<?php echo base_url('/index.php/usuario/listing'); ?>"><i class="fas fa-user-edit"></i> Listar usuários Ativos</a>
        </li>
        <li class="nav-item">
            <a class="nav-item" href="<?php echo base_url('/index.php/usuario/listing_inativos'); ?>"><i class="fas fa-user-plus"></i> Listar usuários inativos</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'departamento') {
                                    echo 'active';
                                } else {
                                    echo '';
                                } ?>">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-address-book"></i> Departamento
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <li class="nav-item">
            <a class="nav-item" href="<?php echo base_url('/index.php/departamento/listing'); ?>"><i class="far fa-address-book"></i></i> Visualizar Departamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-item" href="<?php echo base_url('/index.php/departamento/add'); ?>"><i class="fas fa-address-book"></i></i> Cadastrar Departamento</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown <?php if ($this->uri->segment(1) == 'empresa') {
                                    echo 'active';
                                } else {
                                    echo '';
                                } ?>">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-building"></i> Empresa
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <li class="nav-item">
        <a  class="nav-item" href="<?php echo base_url('/index.php/empresa/view'); ?>"><i class="far fa-building"></i> Visualizar Empresa</a>
        </li>
        <li class="nav-item">
        <a class="nav-item" href="<?php echo base_url('/index.php/empresa/edit'); ?>"><i class="fas fa-building"></i> Editar Empresa</a>
        </li>
    </ul>
</li>
<?php 
} ?> 