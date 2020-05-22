<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MTipoocorrencia extends CI_Model
{

	function addTipoocorrencia($data)
	{
		$this->db->insert('tipo_ocorrencia', $data);
		if ($this->db->affected_rows())
			return true;
		else
			return false;
	}

	function listTipoocorrencias()
	{
		$this->db->order_by('TOC_Nome', 'ASC');
		return $this->db->get('tipo_ocorrencia');
	}

	function getTipoocorrencia($TOC_Id)
	{
		return $this->db->get_where('tipo_ocorrencia', array('TOC_Id' => $TOC_Id));
	}

	function updateTipoocorrencia($TOC_Id, $data)
	{
		$this->db->where('TOC_Id', $TOC_Id);
		$this->db->update('tipo_ocorrencia', $data);
	}

	function deleteTipoocorrencia($TOC_Id)
	{
		$this->db->where('TOC_Id', $TOC_Id);
		$this->db->delete('tipo_ocorrencia');
	}
}