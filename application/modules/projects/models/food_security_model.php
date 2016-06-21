<?php

class Food_security_model extends CI_Model 
{
	public function get_food_security()
	{
		$where = 'form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_food_security');
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
		'cm1_type'=>$this->input->post('manure_type'),
		);
		if($this->db->insert('gla_food_security', $data))
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
		'wh_type'=>$this->input->post('harvesting_type'),
		'wh_capacity'=>$this->input->post('harvesting_capacity'),
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
}
?>