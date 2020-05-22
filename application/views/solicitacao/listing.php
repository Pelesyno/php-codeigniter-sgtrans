<div class="card">
    <h5 class="card-header">
        <div class="row">
            <div class="col-sm-8"><i class="fab fa-uber"></i>
                <?php echo $headline;
                ?></div>
            <div class="col-sm-4 text-right">
                <?php
                echo anchor('solicitacao/add/', '<span class="btn btn-primary">Adicionar Solicitação </span>');
                ?>
            </div>
        </div>
    </h5>
    <div class="card-body">
        <div class="table-responsive">
            <?php echo $data_table; ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modalexcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remover Solicitação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja remover a Solicitação de: <strong><span id="modalid"></span></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button id="999" type="button" class="btn btn-danger">Remover</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('a[data-toggle=modal], button[data-toggle=modal]').click(function() {
            var data_id = '';

            if (typeof $(this).data('id') !== 'undefined') {
                data_id = $(this).data('id');
                data_transfer = $(this).data('transfer');
                $('#999').attr('data-id', data_id);
                $('#modalid').html(data_transfer);
            }
        })
    });

    $('#999').click(function name(e) {
        $('#modalexcluir').modal('hide');
        var base_url = "<?php echo base_url(); ?>"
        var id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: base_url + 'index.php/solicitacao/delete/' + id,
            success: function() {
                location.reload();
            }
        });
    });
</script> 