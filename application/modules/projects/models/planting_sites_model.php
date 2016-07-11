<?php

class Planting_sites_model extends CI_Model 
{

	/*
	*	Retrieve all planting_site
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_project_planting_sites($table, $where, $per_page, $page, $order = 'site_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	/*
	*	Add a new project_area
	*	@param string $image_name
	*
	*/
	public function add_planting_site($project_id)
	{
		$data = array(
				'site_name'=>$this->input->post('site_name'),
				'status'=>1,
				'project_id'=>$project_id,
				'created_by'=>$this->session->userdata('personnel_id')
			);
			
		if($this->db->insert('planting_site', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing project_area
	*	@param string $image_name
	*	@param int $project_id
	*
	*/
	public function update_project_planting_site($project_id,$site_id)
	{
		$data = array(
				'site_name'=>$this->input->post('site_name'),
				'status'=>1,
				'project_id'=>$project_id
			);
			
		$this->db->where('site_id', $site_id);
		if($this->db->update('planting_site', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Activate a deactivated project_area
	*	@param int $project_id
	*
	*/
	public function activate_planting_site($site_id)
	{
		$data = array(
				'status' => 1
			);
		$this->db->where('site_id', $site_id);
		
		if($this->db->update('planting_site', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated project_area
	*	@param int $project_id
	*
	*/
	public function deactivate_planting_site($site_id)
	{
		$data = array(
				'status' => 0
			);
		$this->db->where('site_id', $site_id);
		
		if($this->db->update('planting_site', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	get a single project_area's details
	*	@param int $project_area_id
	*
	*/
	public function get_project_planting_site($site_id)
	{
		//retrieve all users
		$this->db->from('planting_site');
		$this->db->select('*');
		$this->db->where('site_id = '.$site_id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_project_details($project_id)
	{
		//retrieve all users
		$this->db->from('projects');
		$this->db->select('*');
		$this->db->where('project_id = '.$project_id);
		$query = $this->db->get();
		
		return $query;
	}


	/*
	*	Retrieve all planting_site
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_site_activities($table, $where, $per_page = NULL, $page = NULL, $order = 'cpm_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		if($per_page != NULL)
		{
			$query = $this->db->get('', $per_page, $page);
		}
		
		else
		{
			$query = $this->db->get();
		}
		
		return $query;
	}
	
	public function add_activity($project_id,$site_id)
	{
		$data = array(
				'cp_activitytitle'=>$this->input->post('activity_title'),
				'cp_payment_date'=>$this->input->post('payment_date'),
				'cp_reason'=>$this->input->post('payment_reason'),
				'cp_step'=>$this->input->post('cp_step'),
				'cp_status'=>1,
				'cp_project_id'=>$project_id,
				'cp_planting_site_id'=>$site_id,
				'created_by'=>$this->session->userdata('personnel_id'),
				'created'=>date('Y-m-d'),
			);
			
		if($this->db->insert('casual_payment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function add_followup($project_id,$site_id,$step_id)
	{
		$data = array(
				'year'=>$this->input->post('year'),
				'month'=>$this->input->post('month_id'),
				'planted_trees'=>$this->input->post('total_planted'),
				'surviving_trees'=>$this->input->post('surviving_trees'),
				'step_id'=>$step_id,
				'project_id'=>$project_id,
				'planting_site_id'=>$site_id,
				'created_by'=>$this->session->userdata('personnel_id'),
				'created'=>date('Y-m-d'),
			);
			
		if($this->db->insert('planting_followup', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function add_cpm_attendee($cp_id)
	{
			$data = array(
				'cpm_name'=>$this->input->post('cpm_name'),
				'cpm_national_id'=>$this->input->post('cpm_national_id'),
				'cpm_phone'=>$this->input->post('cpm_phone'),
				'cpm_amount'=>$this->input->post('cpm_amount'),
				'cpm_gender'=>$this->input->post('cpm_gender'),
				'cpm_status'=>1,
				'cp_id'=>$cp_id,
				'created_by'=>$this->session->userdata('personnel_id'),
				'created'=>date('Y-m-d'),
			);
			
		if($this->db->insert('casual_payment_members', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

}
?>