<?php

class Food_security_model extends CI_Model 
{
	public function get_food_security()
	{
		$where = 'projects.project_id = gla_food_security.project_id AND gla_food_security.form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_food_security,projects');
		return $food_security_query;
	}
	public function get_soil_water_conservation()
	{
		$where = 'projects.project_id = gla_soil_water_conservation.project_id AND gla_soil_water_conservation.form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_soil_water_conservation,projects');
		return $food_security_query;
	}
	public function get_trainers_of_trainees()
	{
		$where = 'projects.project_id = gla_tots_form.project_id AND gla_tots_form.form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_tots_form,projects');
		return $food_security_query;
	}
	
	public function get_location_details()
	{
		$where = 'location_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$location_details = $this->db->get('location');
		return $location_details;
	}
	
	public function add_food_security()
	{
		$data = array(
		'location_id'=>$this->input->post('location_id'),
		'name'=>$this->input->post('farmer_name'),
		'phone'=>$this->input->post('phone_number'),
		'gps'=>$this->input->post('gps'),
		'eastings'=>$this->input->post('eastings'),
		'northings'=>$this->input->post('northings'),
		'wh_type'=>$this->input->post('harvesting_type'),
		'wh_capacity'=>$this->input->post('harvesting_capacity'),
		'ag_type'=>$this->input->post('agro_tree_type'),
		'ag_spacing'=>$this->input->post('agro_tree_spacing'),
		'ag_quantity'=>$this->input->post('agro_tree_qty'),
		'sc_type'=>$this->input->post('soil_conservation_type'),
		'sc_bench'=>$this->input->post('soil_conservation_bench'),
		'sc_quantity'=>$this->input->post('soil_conservation_qty'),
		'kg_name'=>$this->input->post('kitchen_gardening_name'),
		'kg_variety'=>$this->input->post('kitchen_gardening_variety'),
		'ta_quantity'=>$this->input->post('trench_arrow_root_qty'),
		'ta_length'=>$this->input->post('trench_length'),
		'cm_type'=>$this->input->post('manure_type'),
		'project_id'=>$this->input->post('project_id'),
		'location_id'=>$this->input->post('location_id'),
		'status'=>1
		);
		// var_dump($data);die();
		if($this->db->insert('gla_food_security', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function add_trainer_of_trainees($thematic_id)
	{
		$data = array(
		'location_id'=>$this->input->post('location_id'),
		'tot_name'=>$this->input->post('tot_name'),
		'phone'=>$this->input->post('phone_number'),
		'gps'=>$this->input->post('gps'),
		'eastings'=>$this->input->post('eastings'),
		'northings'=>$this->input->post('northings'),
		'wh_type'=>$this->input->post('harvesting_type'),
		'ag_species'=>$this->input->post('ag_species'),
		'ag_quantity'=>$this->input->post('agro_tree_qty'),
		'sc_type'=>$this->input->post('soil_conservation_type'),
		'kg_name'=>$this->input->post('kitchen_gardening_name'),
		'kg_variety'=>$this->input->post('kitchen_gardening_variety'),
		'ta_length'=>$this->input->post('trench_length'),
		'cm_type'=>$this->input->post('manure_type'),
		'stoves'=>$this->input->post('stoves'),
		'me_types'=>$this->input->post('me_types'),
		'bee_keeping'=>$this->input->post('bee_keeping'),
		'tne_species'=>$this->input->post('tne_species'),
		'tne_treeno'=>$this->input->post('tne_treeno'),
		'project_id'=>$this->input->post('project_id'),
		'location_id'=>$this->input->post('location_id'),
		'status'=>1,
		'thematic_id'=>$thematic_id
		);
		// var_dump($data);die();
		if($this->db->insert('gla_tots_form', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function add_water_conservation()
	{
		$data = array(
		'name'=>$this->input->post('farmer_name'),
		'phone'=>$this->input->post('phone_number'),
		'gps'=>$this->input->post('gps'),
		'eastings'=>$this->input->post('eastings'),
		'northings'=>$this->input->post('northings'),
		'project_id'=>$this->input->post('project_id'),
		'location_id'=>$this->input->post('location_id'),
		'ag_type'=>$this->input->post('agro_tree_type'),
		'ag_spacing'=>$this->input->post('agro_tree_spacing'),
		'ag_quantity'=>$this->input->post('agro_tree_qty'),
		'sc_type'=>$this->input->post('soil_conservation_type'),
		'sc_spacing'=>$this->input->post('soil_conservation_spacing'),
		'sc_quantity'=>$this->input->post('soil_conservation_qty'),
		'sc_quantity'=>$this->input->post('soil_conservation_row'),
		'g_quantity'=>$this->input->post('grass_qty'),
		'g_rows'=>$this->input->post('grass_row'),
		'g_spacing'=>$this->input->post('grass_spacing'),
		'cc_type'=>$this->input->post('cover_crop_type'),
		'cc_rows'=>$this->input->post('cover_crop_row'),
		'cc_quantity'=>$this->input->post('cover_crop_qty'),
		'cc_spacing'=>$this->input->post('cover_crop_spacing'),
		'c_quantity'=>$this->input->post('coffee_qty'),
		'r_type'=>$this->input->post('riparian_type'),
		'r_dist'=>$this->input->post('riparian_distance'),
		'r_quantity'=>$this->input->post('riparian_qty')
		
		);
		if($this->db->insert('gla_soil_water_conservation', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_active_list($table, $where, $order, $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('');
		
		return $query;
	}
}
?>