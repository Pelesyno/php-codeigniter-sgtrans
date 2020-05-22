<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MDepartamento extends CI_Model
{

	function addDepartamento($data)
	{
		$this->db->insert('departamento', $data);
	}

	function listDepartamento()
	{
		$this->db->order_by('DEP_Nome', 'asc');
		return $this->db->get('departamento');
	}

	function getDepartamento($DEP_Id)
	{
		return $this->db->get_where('departamento', array('DEP_Id' => $DEP_Id));
	}

	function updateDepartamento($DEP_Id, $data)
	{
		$this->db->where('DEP_Id', $DEP_Id);
		$this->db->update('departamento', $data);
	}

	function deleteDepartamento($DEP_Id)
	{
		$this->db->where('DEP_Id', $DEP_Id);
		$this->db->delete('departamento');
	}
}