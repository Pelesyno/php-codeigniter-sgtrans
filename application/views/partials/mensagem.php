<?php
/**
 * Created by PhpStorm.
 * User: joice
 * Date: 25/02/2019
 * Time: 23:46
 */
if ($this->session->flashdata('sucesso')) {
    echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <strong>Sucesso!</strong> ' . $this->session->flashdata('sucesso') . '
              </div>';
}
if ($this->session->flashdata('erro')) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <strong>Ops!...</strong> ' . $this->session->flashdata('erro') . '
              </div>';
}
 