<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Project_areas extends admin 
{
	var $documents_path;
	var $csv_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('project_areas_model');
		$this->load->model('projects_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/file_model');		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->documents_path = realpath(APPPATH . '../assets/documents/projects');
		
		//path to imports
		$this->csv_path = realpath(APPPATH . '../assets/csv');
		
	}
    
	/*
	*
	*	Default action is to show all the project_areas
	*
	*/
	public function index($order = 'project_area_id', $order_method = 'DESC') 
	{
		$where = 'project_areas.project_area_id > 0 AND project_area_delete = 0';
		$table = 'project_areas';
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'gbm-administration/project-watersheds/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->project_areas_model->get_all_project_areas($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}

		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		
		$data['title'] = 'Project Areas';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['project_areas'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_areas/all_project_areas_list', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new project_area
	*
	*/
	public function add_project_area() 
	{
		//form validation rules
		$this->form_validation->set_rules('project_area_name', 'Area Name', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_status', 'Area Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->project_areas_model->add_project_areas())
			{
				$this->session->set_userdata('success_message', 'Project area added successfully');
				redirect('gbm-administration/project-watersheds');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add project area. Please try again');
			}
		}
		
		$data['title'] = 'Add Project Area';
		$v_data['title'] = $data['title'];
		$data['content'] = $this->load->view('project_areas/add_project_area', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	public function project_area_detail($project_area_id)
	{
		$v_data['title'] = 'Project Area ';
		$v_data['project_area_id'] = $project_area_id;

		$where = 'project_areas.parent_project_area_id  = '.$project_area_id;
		$table = 'project_areas';

		// count target areas
		$v_data['totol_areas'] = $this->users_model->count_items($table, $where);


		$meeting_where = 'meeting.project_area_id  = '.$project_area_id;
		$meeting_table = 'meeting';

		// count target areas
		$v_data['totol_meetings'] = $this->users_model->count_items($meeting_table, $meeting_where);


		$community_where = 'project_area_id  = '.$project_area_id;
		$community_table = 'community_group';

		// count target areas
		$v_data['totol_communities'] = $this->users_model->count_items($community_table, $community_where);
		// end of counting
		$data['title'] =$v_data['title'] ;
		$data['content'] = $this->load->view('project_areas/project_area_detail', $v_data, true);

		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Edit an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function edit_project_area($project_area_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('project_area_name', 'Area Name', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_status', 'Area Status', 'required|xss_clean');

		$this->form_validation->set_rules('project_area_longitude', 'Longitude', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_latitude', 'Latitude', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->project_areas_model->update_project_area($project_area_id))
			{
				$this->session->set_userdata('success_message', 'project_area updated successfully');
				redirect('tree-planting/project-areas');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update project_area. Please try again');
			}
		}
		
		//open the add new project_area
		$data['title'] = 'Edit project area';
		$v_data['title'] = $data['title'];
		$v_data['project_area_id'] = $project_area_id;
		
		//select the project_area from the database
		$query = $this->project_areas_model->get_project_area($project_area_id);
		
		$v_data['project_area'] = $query->result();
		$query_uploads = $this->project_areas_model->get_project_area_uploads($project_area_id);
		
		$v_data['query_uploads'] = $query_uploads;
		
		$data['content'] = $this->load->view('project_areas/edit_project_area', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Delete an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function delete_project_area($project_area_id)
	{
		$this->project_areas_model->delete_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project_area has been deleted');
		
		redirect('tree-planting/project-areas');
	}
    
	/*
	*
	*	Activate an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function activate_project_area($project_area_id)
	{
		$this->project_areas_model->activate_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project_area activated successfully');
		
		redirect('tree-planting/project-areas');
	}
    
	/*
	*
	*	Deactivate an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function deactivate_project_area($project_area_id)
	{
		$this->project_areas_model->deactivate_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project_area disabled successfully');
		
		redirect('tree-planting/project-areas');
	}




	// project area locations



	/*
	*
	*	Default action is to show all the project_area_locations
	*
	*/
	public function area_locations($project_id,$order = 'project_area_name', $order_method = 'ASC') 
	{
		 $where = 'project_areas.project_area_id = project_watershed.project_area_id AND project_watershed.project_watershed_delete = 0 AND  project_watershed.project_id  = '.$project_id;
		$table = 'project_areas,project_watershed';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/area-locations/'.$project_id.'/'.$order.'/'.$order_method;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->project_areas_model->get_all_project_area_locations($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		$project_areas = $this->project_areas_model->get_unselected_project_areas($project_id);
		$data['title'] = 'Project Watersheds';
		$v_data['title'] = $data['title'];
		$v_data['project_areas'] = $project_areas;
		$v_data['order'] = $order;
		$v_data['project_id'] = $project_id;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_area_locations/all_project_area_locations', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new project_area
	*
	*/
	public function add_area_location($project_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('project_area_name', 'Area Name', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_status', 'Area Status', 'required|xss_clean');

		$this->form_validation->set_rules('project_area_longitude', 'Longitude', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_latitude', 'Latitude', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->project_areas_model->add_area_location($project_id))
			{
				$this->session->set_userdata('success_message', 'Target Area Location added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add project_area. Please try again');
			}
		}
		redirect('tree-planting/area-locations/'.$project_id);
	}

    
	/*
	*
	*	Edit an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function edit_project_area_location($project_area_id,$parent_project_area_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('project_area_name', 'Area Name', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_status', 'Area Status', 'required|xss_clean');

		$this->form_validation->set_rules('project_area_longitude', 'Longitude', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_latitude', 'Latitude', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->project_areas_model->update_project_area_location($project_area_id,$parent_project_area_id))
			{
				$this->session->set_userdata('success_message', 'project_area updated successfully');
				redirect('tree-planting/area-locations');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update project_area. Please try again');
			}
		}
		
		//open the add new project_area
		$data['title'] = 'Edit project area';
		$v_data['title'] = $data['title'];
		$v_data['project_area_id'] = $project_area_id;
		
		//select the project_area from the database
		$query = $this->project_areas_model->get_project_area_location($project_area_id);
		
		$v_data['project_area'] = $query->result();
		
		$data['content'] = $this->load->view('project_area_locations/edit_project_area_location', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Delete an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function delete_project_area_location($project_area_id)
	{
		$this->project_areas_model->delete_project_area_location($project_area_id);
		$this->session->set_userdata('success_message', 'project_area has been deleted');
		
		redirect('tree-planting/area-locations');
	}
    
	/*
	*
	*	Activate an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function activate_area_location($parent_project_area_id,$project_area_id)
	{
		$this->project_areas_model->activate_area_location($project_area_id);
		$this->session->set_userdata('success_message', 'project_area activated successfully');
		
		redirect('tree-planting/area-locations/'.$parent_project_area_id);
	}
    
	/*
	*
	*	Deactivate an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function deactivate_area_location($parent_project_area_id,$project_area_id)
	{
		$this->project_areas_model->deactivate_area_location($project_area_id);
		$this->session->set_userdata('success_message', 'project_area disabled successfully');
		
		redirect('tree-planting/area-locations/'.$parent_project_area_id);
	}

	public function upload_area_documents($project_area_id)
	{

		//form validation rules
		$this->form_validation->set_rules('attachement_name', 'Attachement Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			
			if(is_uploaded_file($_FILES['post_image']['tmp_name']))
			{
				$documents_path = $this->documents_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_documents($documents_path, 'post_image');
				if($response['check'])
				{
					$file_name = $response['file_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					
				}
			}
			
			else{
				$file_name = '';
			}
			
			if($this->project_areas_model->add_project_area_upload($file_name, $project_area_id))
			{
				$this->session->set_userdata('success_message', 'Document was uploaded successfully added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add post. Please try again');
			}
			redirect('tree-planting/edit-project-area/'.$project_area_id);
		}

	}
	//import projects
	function import_watershed_template()
	{
		//export products template in excel 
		$this->project_areas_model->import_watershed_template();
	}
	//do the personnel import
	function do_watershed_import($project_id)
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->project_areas_model->import_csv_projects($this->csv_path,$project_id);
				
				if($response == FALSE)
				{
					$v_data['import_response_error'] = 'Something went wrong. Please try again.';
				}
				
				else
				{
					if($response['check'])
					{
						$v_data['import_response'] = $response['response'];
					}
					
					else
					{
						$v_data['import_response_error'] = $response['response'];
					}
				}
			}
			
			else
			{
				$v_data['import_response_error'] = 'Please select a file to import.';
			}
		}
		
		else
		{
			$v_data['import_response_error'] = 'Please select a file to import.';
		}
		
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		redirect ('tree-planting/area-locations/'.$project_id);
	}
	
	//edit tree planting project ares
	public function edit_tree_project_area($project_area_id)
	{
		
		//form validation rules
		$this->form_validation->set_rules('project_area_name', 'Area Name', 'required|xss_clean');
		$this->form_validation->set_rules('project_area_status', 'Area Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->project_areas_model->update_tree_project_area($project_area_id))
			{
				$this->session->set_userdata('success_message', 'project_area watershed updated successfully');
				redirect('gbm-administration/project-watersheds');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update projectarea. Please try again');
			}
		}
		
		//open the edit new project_area
		$data['title'] = 'Edit project watershed';
		$v_data['title'] = $data['title'];
		$v_data['project_area_id'] = $project_area_id;
		
		//select the project_area from the database
		$query = $this->project_areas_model->get_project_area_location($project_area_id);
		
		$v_data['project_area'] = $query->result();
		
		$data['content'] = $this->load->view('project_area_locations/edit_tree_watershed', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	
	public function deactivate_tree_project_area($project_area_id)
	{
		$this->project_areas_model->deactivate_tree_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project area watershed deactivated successfully');
	 
		redirect('gbm-administration/project-watersheds');
	}
	
	public function activate_tree_project_area($project_area_id)
	{
		$this->project_areas_model->activate_tree_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project area watershed activated successfully');
		
		redirect('gbm-administration/project-watersheds');
	}
	public function delete_tree_project_area($project_area_id)
	{
		
		$this->project_areas_model->delete_tree_project_area($project_area_id);
		$this->session->set_userdata('success_message', 'project area watershed deleted successfully');
		
		redirect('gbm-administration/project-watersheds');
	}
}
?>