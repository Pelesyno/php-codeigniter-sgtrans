<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mNotificacao extends CI_Model
{
    function getNotificacoes()
    {
        return $this->db->get('notificacoes');
    }

    function getNotificacoesL()
    {
        return $this->db->order_by('NOT_Id', 'DESC')
                    ->limit(5)
                    ->get('notificacoes');
    }

    function get_notification_count()
    {
        return $this->db->where('NOT_Read', 1)
                    ->count_all_results('notificacoes');
    }

    function listIPVA()
	{
        $this->db->join('veiculo', 'IPVA.IPVA_VEI_Id = veiculo.VEI_Id');
        $this->db->where('IPVA_Emplacado', 0);
		return $this->db->get('IPVA');
	}
}