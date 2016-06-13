<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";
class Food_security extends admin
{ 
	var $documents_path;
	
	function __construct()
	{

		parent:: __construct();
		$this->load->model('projects_model');
		$this->load->model('food_security_model');
		$this->load->model('project_areas_model');
		$this->load->model('meeting_model');
		$this->load->model('admin/users_model');		
		$this->load->model('admin/file_model');		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->documents_path = realpath(APPPATH . '../assets/documents/projects');
	}
	
	public function print_food_security()
	{
		
		$where = 'form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_food_security');
		
		$data['food_security_query'] = $food_security_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_security', $data);
	}
	public function print_water_conservation()
	{
		
		$where = 'form_id > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_soil_water_conservation');
		
		$data['food_security_query'] = $food_security_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_water_conservation', $data);
	}
	public function print_tot()
	{
		$where = 'form > 0';
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_tots_form');
		
		$data['food_security_query'] = $food_security_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_tot', $data);
	}
}
?>