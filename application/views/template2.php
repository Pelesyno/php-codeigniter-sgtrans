<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');  ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <meta name="theme-color" content="#000">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/styles_Login.css'); ?>">
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <?php
                    echo form_open('login/process');
                    if (isset($msg) && $msg == 1)
                        echo '<div class="alert alert-danger"> <strong>Erro! </strong>Usuário ou senha inválidos. </div>';
                    ?>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <?php
                        echo form_input('username', '', 'title="Seu login no sistema" class="form-control" placeholder="Login"');
                        ?>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <?php
                        echo form_password('password', '', 'title="Sua senha de acesso" class="form-control" placeholder="Senha"');
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                        echo form_submit('', 'Entrar', 'class="btn float-right login_btn"');
                        ?>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        SG-TRANSPORTES
                    </div>
                    <div class="d-flex justify-content-center">
                        <?php
                        echo heading($headline, 6);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html> 