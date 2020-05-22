<div class="card">

    <h5 class="card-header">
        <i class="fas fa-gas-pump"></i>
        <?php echo $headline; ?>
    </h5>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 form-group">
                    <?php
                    echo form_label('Veiculo: ' . $veiculo[0]->MOD_Nome . ' - ' . $veiculo[0]->VEI_Placa);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data e Hora Entrada: ' . mysql_to_pt($manutencao[0]->MAN_DataHoraEntrada));
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Odometro: ' . $manutencao[0]->MAN_Odometro);
                    ?>
                </div>
                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Data e Hora Saida: ' . mysql_to_pt($manutencao[0]->MAN_DataHoraSaida));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    ?>
                    <table id="pecas" class='table table-hover table-striped table-sm'>
                        <thead>
                            <tr class="table-warning">
                                <th colspan="3" class="text-center">Peças</th>
                            </tr>
                            <tr>
                                <th>Cod.</th>
                                <th>Peça</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pecasUtilizadas->result() as $pecaUtilizada) :
                                ?>
                                <tr>
                                    <td><?php echo $pecaUtilizada->PEC_Id; ?></td>
                                    <td><?php echo $pecaUtilizada->PEC_Nome; ?></td>
                                    <td><?php echo number_format($pecaUtilizada->PU_Valor, 2, ',', '.'); ?></td>
                                </tr>
                            <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    ?>
                    <table id="servicos" class='table table-hover table-striped table-sm'>
                        <thead>
                            <tr class="table-warning">
                                <th colspan="3" class="text-center">Serviços</th>
                            </tr>
                            <tr>
                                <th>Cod.</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($servicosUtilizadas->result() as $servicoUtilizado) :
                                ?>
                                <tr>
                                    <td><?php echo $servicoUtilizado->SER_Id; ?></td>
                                    <td><?php echo $servicoUtilizado->SER_Nome; ?></td>
                                    <td><?php echo number_format($servicoUtilizado->SU_Valor, 2, ',', '.'); ?></td>
                                </tr>
                            <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-4 form-group">
                    <?php
                    echo form_label('Custo Total: ' . number_format($manutencao[0]->MAN_CustoTotal, 2, ',', '.'));
                    ?>
                </div>
                <div class="col-sm-8 form-group">
                    <?php
                    echo form_label('Oficina: ' . $oficina[0]->OFI_RazaoSocial);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted text-right">
        <?php
        if ($manutencao[0]->MAN_DataHoraSaida == '0000-00-00') {
            echo anchor('manutencao/edit/' . $manutencao[0]->MAN_Id, '<i class="fas fa-pencil-alt"></i> Editar', 'title="Editar Manutenção" class="btn btn-primary"');
            echo ' ';
        }
        echo   $Voltar = '<a href="JavaScript: window.history.back();"><span class="btn btn-warning">Voltar</span></a>';
        ?>
    </div>
    <?php echo form_close(); ?>
</div>