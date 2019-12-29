<?php 

class Model_marketplace extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the active marketplace data */
	public function getActiveMarketplace()
	{
		$sql = "SELECT * FROM marketplace WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the data */
	public function getMarketplaceData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM marketplace where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM marketplace";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('marketplace', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('marketplace', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('marketplace');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalMarketplace()
	{
		$sql = "SELECT * FROM marketplace WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}

}