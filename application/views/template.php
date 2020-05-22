<?php
$this->load->view('partials/header');
$this->load->view('partials/menu');
?>
<div class="container">
    <br>
    <?php
    $this->load->view('partials/mensagem');
    ?>
    <br>
    <div class="row">
        <div class="col-sm-12">
            <?php $this->load->view($include); ?>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?> 