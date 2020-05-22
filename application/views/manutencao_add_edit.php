<?php
if (isset($manutencao[0]->MAN_DataHoraSaida) && $manutencao[0]->MAN_DataHoraSaida != '0000-00-00') {
    $this->session->set_flashdata('erro', 'Manutenção já Finalizada!!!');
    redirect('manutencao/listing', 'refresh');
}
//Montando Dropdown das Oficinas
$oficinass = array('' => 'Selecione a Oficina');
foreach ($oficinas->result() as $oficina) :
    $oficinass[$oficina->OFI_Id] = $oficina->OFI_RazaoSocial;
endforeach;

//Montando Dropdown das Veiculos
$veiculoss = array('' => 'Selecione o Veiculo');
foreach ($veiculos->result() as $veiculo) :
    //$veiculoss[$veiculo->VEI_Id] = $veiculo->MOD_Nome . " " . $veiculo->VEI_Cilindrada . " - " . $veiculo->VEI_Placa;
    $veiculoss[$veiculo->VEI_Id] = $veiculo->VEI_Placa;
endforeach;

//Montando Dropdown das Peças
$pecass = array('' => 'Selecione a Peça');
foreach ($pecas->result() as $peca) :
    $pecass[$peca->PEC_Id] = $peca->PEC_Nome;
endforeach;

//Montando Dropdown das Serviços
$servicoss = array('' => 'Selecione o Serviço');
foreach ($servicos->result() as $servico) :
    $servicoss[$servico->SER_Id] = $servico->SER_Nome;
endforeach;
?>
<div class="card">
    <?php
    if (isset($update)) {
        echo form_open('manutencao/update', 'name="form_manutencao"');
        echo form_hidden('MAN_Id', set_value('MAN_Id', isset($manutencao[0]->MAN_Id) ? $manutencao[0]->MAN_Id : ''));
    } else {
        echo form_open('manutencao/create', 'name="form_manutencao"');
    }
    ?>
    <h5 class="card-header">
        <i class="fas fa-gas-pump"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Veiculo');
                    echo form_dropdown(
                        'VEI_Id',
                        $veiculoss,
                        set_value('VEI_Id', isset($manutencao[0]->VEI_Id) ? $manutencao[0]->VEI_Id : ""),
                        'class="form-control" id="VEI_Id" required'
                    );
                    echo form_error('VEI_Id');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data e Hora Entrada');
                    echo form_date('MAN_DataHoraEntrada', set_value('MAN_DataHoraEntrada', isset($manutencao[0]->MAN_DataHoraEntrada) ? $manutencao[0]->MAN_DataHoraEntrada : date("Y-m-d")), ' class="form-control" required');
                    echo form_error('MAN_DataHoraEntrada')
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Odometro');
                    echo form_number('MAN_Odometro', set_value('MAN_Odometro', isset($manutencao[0]->MAN_Odometro) ? $manutencao[0]->MAN_Odometro : ""), ' class="form-control" id="MAN_Odometro" required');
                    echo form_error('MAN_Odometro');
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data e Hora Saida');
                    echo form_date('MAN_DataHoraSaida', set_value('MAN_DataHoraSaida', isset($manutencao[0]->MAN_DataHoraSaida) ? $manutencao[0]->MAN_DataHoraSaida : ""), ' class="form-control"');
                    echo form_error('MAN_DataHoraSaida');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <?php
                    echo form_label('Peças');
                    echo form_dropdown('PEC_Id', $pecass, '', ' class="form-control" id="PEC_Id"');
                    echo form_error('PEC_Id');
                    ?>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info" onclick="addPecas()" name="incluirPeca" type="button">Incluir</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <?php
                    echo form_label('Serviços');
                    echo form_dropdown('SER_Id', $servicoss, '', ' class="form-control" id="SER_Id"');
                    echo form_error('SER_Id');
                    ?>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info" onclick="addServicos()" name="incluirServico" type="button">Incluir</button>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="pecasUtilizadas" id="pecasUtilizadas">
                <input type="hidden" name="servicosUtilizados" id="servicosUtilizados">
                <?php
                if (isset($update)) {
                    ?>
                    <div class="col-sm-4 form-group">
                        <?php
                        echo form_label('Custo Total');
                        echo form_input('MAN_CustoTotal', set_value('MAN_CustoTotal', isset($manutencao[0]->MAN_CustoTotal) ? $manutencao[0]->MAN_CustoTotal : ""), ' class="form-control" disabled');
                        echo form_error('MAN_CustoTotal');
                        ?>
                    </div>
                    <div class="col-sm-8 form-group">
                    <?php } else {
                    ?>
                        <div class="col-sm-12 form-group">
                        <?php
                    }
                    echo form_label('Oficina');
                    echo form_dropdown('OFI_Id', $oficinass, set_value('OFI_Id', isset($manutencao[0]->OFI_Id) ? $manutencao[0]->OFI_Id : ""), 'class="form-control" required');
                    echo form_error('OFI_Id');
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted text-right">
            <?php
            if (isset($update)) {
                echo form_submit('', 'Atualizar', 'class="btn btn-primary" id="btn-salvar" disabled');
            } else {
                echo form_submit('', 'Cadastrar', 'class="btn btn-primary"');
            }
            echo ' ';
            echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
            ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <table id="pecas" class='table table-hover table-striped table-sm'>
        <thead class="thead-dark">
            <tr>
                <th colspan="4" class="text-center">Peças</th>
            </tr>
            <tr>
                <th>Cod.</th>
                <th>Peça</th>
                <th>Valor</th>
                <?php if (isset($update)) { ?>
                    <th>Excluir</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($update)) {
                ?>
                <script type="text/javascript">
                    var array_pecas = [];
                </script>
                <?php
                foreach ($pecasUtilizadas->result() as $pecaUtilizada) :
                    ?>
                    <script type="text/javascript">
                        array_pecas[array_pecas.length] = "<?php echo $pecaUtilizada->PEC_Id; ?>";
                        $('#pecasUtilizadas').val(array_pecas.join("|"));
                    </script>
                    <tr id="<?php echo 'pec' . $pecaUtilizada->PEC_Id; ?>">
                        <td><?php echo $pecaUtilizada->PEC_Id; ?></td>
                        <td><?php echo $pecaUtilizada->PEC_Nome; ?></td>
                        <td><?php echo 'R$ '.number_format($pecaUtilizada->PU_Valor, 2, ',', '.'); ?></td>
                        <td><i class="fas fa-trash-alt" onclick="deletePeca(<?php echo $pecaUtilizada->PEC_Id; ?>)"></i></td>
                    </tr>
                <?php
            endforeach;
        } else {
            ?>
                <script type="text/javascript">
                    var array_pecas = [];
                </script>
            <?php } ?>
        </tbody>
    </table>
    <table id="servicos" class='table table-hover table-striped table-sm'>
        <thead class="thead-dark">
            <tr>
                <th colspan="4" class="text-center">Serviços</th>
            </tr>
            <tr>
                <th>Cod.</th>
                <th>Serviço</th>
                <th>Valor</th>
                <?php if (isset($update)) { ?>
                    <th>Excluir</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($update)) {
                ?>
                <script type="text/javascript">
                    var array_servicos = [];
                </script>
                <?php
                foreach ($servicosUtilizadas->result() as $servicoUtilizado) :
                    ?>
                    <script type="text/javascript">
                        array_servicos[array_servicos.length] = "<?php echo $servicoUtilizado->SER_Id; ?>";
                        $('#servicosUtilizados').val(array_servicos.join("|"));
                    </script>
                    <tr id="<?php echo 'ser' . $servicoUtilizado->SER_Id; ?>">
                        <td><?php echo $servicoUtilizado->SER_Id; ?></td>
                        <td><?php echo $servicoUtilizado->SER_Nome; ?></td>
                        <td><?php echo 'R$ '.number_format($servicoUtilizado->SU_Valor, 2, ',', '.'); ?></td>
                        <td><i class="fas fa-trash-alt" onclick="deleteServico(<?php echo $servicoUtilizado->SER_Id; ?>)"></i></td>
                    </tr>
                <?php
            endforeach;
        } else {
            ?>
                <script type="text/javascript">
                    var array_servicos = [];
                </script>
            <?php } ?>
        </tbody>
    </table>
    <script type="text/javascript">
        $('form :input').change(function() {
            if ($(this).val() != $(this).data('valor')) {
                $('#btn-salvar').attr('disabled', false)
            } else {
                $('#btn-salvar').attr('disabled', true)
            }
        });

        function addPecas() {
            array_pecas[array_pecas.length] = $('#PEC_Id').val();
            var base_url = "<?php echo base_url(); ?>";
            var e = document.getElementById("PEC_Id");
            var itemSelecionado = e.options[e.selectedIndex].text;
            preco = $.post(base_url + 'index.php/peca/getPreco', {
                PEC_Id: $('#PEC_Id').val()
            }, function(data) {
                var tr = '<tr id="pec'+ $('#PEC_Id').val() +'">' +
                    '<td>' + $('#PEC_Id').val() + '</td>' +
                    '<td>' + itemSelecionado + '</td>' +
                    '<td>' + data + '</td>' +
                    '<td><i class="fas fa-trash-alt" onclick="deletePeca('+ $('#PEC_Id').val() +')"></i></td>' +
                    '</tr>';
                $('#pecas').find('tbody').append(tr);
            });
            $('#pecasUtilizadas').val(array_pecas.join("|"));
        }

        function deleteServico(id) {
            var index = array_servicos.indexOf(id.toString());
            if (index > -1) {
                array_servicos.splice(index, 1);
            }
            var seletor = "#ser" + id;
            $(seletor).hide();
            $('#servicosUtilizados').val(array_servicos.join("|"));
            $('#btn-salvar').attr('disabled', false)
        }

        function deletePeca(id) {
            var index = array_pecas.indexOf(id.toString());
            if (index > -1) {
                array_pecas.splice(index, 1);
            }
            var seletor = "#pec" + id;
            $(seletor).hide();
            $('#pecasUtilizadas').val(array_pecas.join("|"));
            $('#btn-salvar').attr('disabled', false)
        }

        function addServicos() {
            array_servicos[array_servicos.length] = $('#SER_Id').val();
            var base_url = "<?php echo base_url(); ?>";
            var e = document.getElementById("SER_Id");
            var itemSelecionado = e.options[e.selectedIndex].text;
            $.post(base_url + 'index.php/servico/getPreco', {
                SER_Id: $('#SER_Id').val()
            }, function(data) {
                var tr = '<tr id="ser'+ $('#SER_Id').val() +'">' +
                    '<td>' + $('#SER_Id').val() + '</td>' +
                    '<td>' + itemSelecionado + '</td>' +
                    '<td>' + data + '</td>' +
                    '<td><i class="fas fa-trash-alt" onclick="deleteServico('+ $('#SER_Id').val() +')"></i></td>' +
                    '</tr>';
                $('#servicos').find('tbody').append(tr);
            });
            $('#servicosUtilizados').val(array_servicos.join("|"));
        }

        $(function() {
            var base_url = "<?php echo base_url(); ?>"
            $('#VEI_Id').change(function() {
                var VEI_Id = $('#VEI_Id').val();
                $.getJSON(base_url + 'index.php/abastece/getOdometro/' + VEI_Id, function(response) {
                    odometro = response['odometro'];
                    $('#MAN_Odometro').val(odometro);
                    document.form_manutencao.MAN_Odometro.setAttribute("min", odometro);
                });
            })
        });
    </script>