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
	
	public function all_food_security($data_page_id)
	{
		$v_data['food_security'] = $this->food_security_model->get_food_security();
		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Food Security';

		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/all_food_security', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);

	}
	public function print_food_security($location_id)
	{
		
		$where = 'location_id ='.$location_id;
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_food_security');
		
		$data['food_security_query'] = $food_security_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_security', $data);
	}
	public function print_water_conservation($location_id)
	{
		
		$where = 'location_id ='.$location_id;
		$this->db->select( '*');
		$this->db->where($where);
		
		$food_security_query = $this->db->get('gla_soil_water_conservation');
		
		$data['food_security_query'] = $food_security_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_water_conservation', $data);
	}
	public function print_trainer_of_trainees($location_id)
	{
		$where = 'location_id ='.$location_id;
		$this->db->select( '*');
		$this->db->where($where);
		
		$tots_query = $this->db->get('gla_tots_form');
		
		$data['tots_query'] = $tots_query;
		$data['branch_data'] = $this->meeting_model->get_branch_details();
		$this->load->view('food_security/print_tot', $data);

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
	public function load_add_food_security($data_page_id)
	{
		$v_data['location_details'] = $this->food_security_model->get_location_details();
		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Add Food Security';
		$project_order = 'projects.project_title';
		$project_table = 'projects';
		$project_where = 'projects.project_status = 1';

		$project_query = $this->food_security_model->get_active_list($project_table, $project_where, $project_order);
		// var_dump($project_query); die();
		$rs8 = $project_query->result();
		$project_list = '';
		foreach ($rs8 as $project_rs) :
			$project_id = $project_rs->project_id;
			$project_title = $project_rs->project_title;

		    $project_list .="<option value='".$project_id."'>".$project_title."</option>";

		endforeach;
		$v_data['project_list'] = $project_list;


		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/add_food_security', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function load_trainer_of_trainees($data_page_id)
	{
		$v_data['location_details'] = $this->food_security_model->get_location_details();
		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Add Trainer of trainees';
		$project_order = 'projects.project_title';
		$project_table = 'projects';
		$project_where = 'projects.project_status = 1';

		$project_query = $this->food_security_model->get_active_list($project_table, $project_where, $project_order);
		// var_dump($project_query); die();
		$rs8 = $project_query->result();
		$project_list = '';
		foreach ($rs8 as $project_rs) :
			$project_id = $project_rs->project_id;
			$project_title = $project_rs->project_title;

		    $project_list .="<option value='".$project_id."'>".$project_title."</option>";

		endforeach;
		$v_data['project_list'] = $project_list;


		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/add_tot', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function add_food_security($data_page_id)
	{
		//form validation rules
		$this->form_validation->set_rules('location_id', 'Location', 'required|xss_clean');
		$this->form_validation->set_rules('farmer_name', 'Farmer Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean');
		// $this->form_validation->set_rules('gps', 'GPS', 'required|xss_clean');
		// $this->form_validation->set_rules('eastings', 'Eastings', 'required|xss_clean');
		// $this->form_validation->set_rules('northings', 'Northings', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_type', 'Harvesting Type', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_capacity', 'Harvesting Capacity', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_spacing', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_bench', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('kitchen_gardening_name', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('kitchen_gardening_variety', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('trench_arrow_root_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('trench_length', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('manure_type', 'Meeting Venue', 'required|xss_clean');
	
		//insert items if validation runs
		if ($this->form_validation->run())
		{
				// var_dump($_POST);die();

			if($this->food_security_model->add_food_security())
			{
				$this->session->set_userdata('success_message', 'You have successfully added a food security');
			}
			else
			{
				$this->session->set_userdata('error_message', 'Could not add the meeting. Please try again');
			}
			
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('food-security/'.$data_page_id);
	}
	public function add_trainer_of_trainees($data_page_id)
	{
		//form validation rules
		$this->form_validation->set_rules('location_id', 'Location', 'required|xss_clean');
		$this->form_validation->set_rules('tot_name', 'Farmer Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean');
		// $this->form_validation->set_rules('gps', 'GPS', 'required|xss_clean');
		// $this->form_validation->set_rules('eastings', 'Eastings', 'required|xss_clean');
		// $this->form_validation->set_rules('northings', 'Northings', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_type', 'Harvesting Type', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_capacity', 'Harvesting Capacity', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_spacing', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_bench', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('kitchen_gardening_name', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('kitchen_gardening_variety', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('trench_arrow_root_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('trench_length', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('manure_type', 'Meeting Venue', 'required|xss_clean');
	
		//insert items if validation runs
		if ($this->form_validation->run())
		{
				// var_dump($_POST);die();

			if($this->food_security_model->add_trainer_of_trainees($data_page_id))
			{
				$this->session->set_userdata('success_message', 'You have successfully added a food security');
			}
			else
			{
				$this->session->set_userdata('error_message', 'Could not add the meeting. Please try again');
			}
			
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('trainer-of-trainees/'.$data_page_id);
	}
	public function all_water_conservation($data_page_id)
	{
		$v_data['soil_conservation'] = $this->food_security_model->get_soil_water_conservation();

		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Water Conservation';
		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/all_water_conservations', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function all_trainer_of_trainees($data_page_id)
	{
		$v_data['trainer_of_trainees'] = $this->food_security_model->get_trainers_of_trainees();

		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Water Conservation';
		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/all_tots', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function gla_dashboard($data_page_id)
	{
		if($data_page_id == 1)
		{
			$section_name = 'GLA';
		}
		else if($data_page_id == 2)
		{
			$section_name = 'Climate Change';
		}
		else
		{
			$section_name = 'Tree planting';	
		}
		$data['title'] = $section_name.' Water Conservation';
		$v_data['title'] = $data['title'];
		$v_data['data_page_id'] = $data_page_id;
		$data['content'] = $this->load->view('food_security/gla_dashboard', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	
	public function load_water_conservation($data_page_id)
	{
		$v_data['location_details'] = $this->food_security_model->get_location_details();

		$data['title'] = 'Add Water Conservation';
		$v_data['title'] = $data['title'];
		$project_order = 'projects.project_title';
		$project_table = 'projects';
		$project_where = 'projects.project_status = 1';

		$project_query = $this->food_security_model->get_active_list($project_table, $project_where, $project_order);
		// var_dump($project_query); die();
		$rs8 = $project_query->result();
		$project_list = '';
		foreach ($rs8 as $project_rs) :
			$project_id = $project_rs->project_id;
			$project_title = $project_rs->project_title;

		    $project_list .="<option value='".$project_id."'>".$project_title."</option>";

		endforeach;
		$v_data['data_page_id'] = $data_page_id;
		$v_data['project_list'] = $project_list;
		$data['content'] = $this->load->view('food_security/add_water_conservation', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function add_water_conservation()
	{
		//form validation rules

		$this->form_validation->set_rules('location_id', 'Location', 'required|xss_clean');
		// $this->form_validation->set_rules('farmer_name', 'Farmer Name', 'required|xss_clean');
		// $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|xss_clean');
		// $this->form_validation->set_rules('gps', 'GPS', 'required|xss_clean');
		// $this->form_validation->set_rules('eastings', 'Eastings', 'required|xss_clean');
		// $this->form_validation->set_rules('northings', 'Northings', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_type', 'Harvesting Type', 'required|xss_clean');
		// $this->form_validation->set_rules('harvesting_capacity', 'Harvesting Capacity', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_spacing', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('agro_tree_qty', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_type', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_bench', 'Meeting Venue', 'required|xss_clean');
		// $this->form_validation->set_rules('soil_conservation_qty', 'Meeting Venue', 'required|xss_clean');
		
		//insert items if validation runs
		if ($this->form_validation->run())
		{
			// var_dump($_POST); die();
			if($this->food_security_model->add_water_conservation())
			{
				$this->session->set_userdata('success_message', 'You have successfully added a soil and water conservation');
			}
			else
			{
				$this->session->set_userdata('error_message', 'Could not add the conservation. Please try again');
			}
			
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		// redirect('water-conservation');
	}
}
?>