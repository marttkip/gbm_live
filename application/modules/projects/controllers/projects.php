<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";
class Projects extends admin
{ 
	var $documents_path;
	
	function __construct()
	{

		parent:: __construct();
		$this->load->model('projects_model');
		$this->load->model('project_areas_model');
		$this->load->model('admin/users_model');		
		$this->load->model('admin/file_model');		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->documents_path = realpath(APPPATH . '../assets/documents/projects');
	}
    
	/*
	*
	*	Default action is to show all the projects
	*
	*/
	public function index() 
	{
		// get my approval roles

		$where = 'projects.project_status_id = project_status.project_status_id AND projects.project_grant_county = counties.county_id';
		$table = 'projects, project_status,counties';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'tree-planting/projects';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 3;
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
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->projects_model->get_all_projects($table, $where, $config["per_page"], $page);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		$v_data['project_status_query'] = $this->projects_model->get_project_status();
		// $v_data['level_status'] = $this->projects_model->project_level_status();
		$v_data['title'] = "Projects";
		$data['content'] = $this->load->view('projects/projects/all_projects', $v_data, true);
		
		$data['title'] = 'Projects';
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new project
	*
	*/
	public function add_project() 
	{
		//form validation rules
		$this->form_validation->set_rules('project_instructions', 'project Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'required|xss_clean');
		$this->form_validation->set_rules('project_end_date', 'Project End Date', 'required|xss_clean');

		$this->form_validation->set_rules('project_donor', 'Donor', 'required|xss_clean');
		$this->form_validation->set_rules('project_title', 'Project Title', 'required|xss_clean');
		$this->form_validation->set_rules('project_location', 'Project Location', 'required|xss_clean');

		$this->form_validation->set_rules('project_grant_value', 'Project Grant Value', 'required|xss_clean');
		$this->form_validation->set_rules('project_grant_county', 'Project grant county', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->projects_model->add_project())
			{
				$this->session->set_userdata('success_message', 'Youhave successfully added a project');
			}
			else
			{
				$this->session->set_userdata('error_message', 'Could not update project. Please try again');
			}
			redirect('tree-planting/projects');
		}
		
		//open the add new project
		$data['title'] = 'Add project';
		$v_data['title'] = 'Add project';
		$v_data['project_status_query'] = $this->projects_model->get_project_status();

		$county_order = 'county_name';
		$county_table = 'counties';
		$county_where = 'county_status = 1';

		$county_query = $this->projects_model->get_active_list($county_table, $county_where, $county_order);
		$rs8 = $county_query->result();
		$county_list = '';
		foreach ($rs8 as $county_rs) :
			$county_id = $county_rs->county_id;
			$county_name = $county_rs->county_name;

		    $county_list .="<option value='".$county_id."'>".$county_name."</option>";

		endforeach;

		$v_data['county_list'] = $county_list;

		$data['content'] = $this->load->view('projects/projects/add_project', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	public function project_detail($project_id,$project_number)
	{
		$v_data['title'] = 'Project '.$project_number;
		$v_data['project_id'] = $project_id;

		$where = 'project_areas.parent_project_area_id  = 0';
		$table = 'project_areas';

		// count target areas
		$v_data['totol_areas'] = $this->users_model->count_items($table, $where);


		$meeting_where = 'meeting.project_area_id  = '.$project_id;
		$meeting_table = 'meeting';

		// count target areas
		$v_data['totol_meetings'] = $this->users_model->count_items($meeting_table, $meeting_where);


		$community_where = 'project_area_id  = '.$project_id;
		$community_table = 'community_group';

		// count target areas
		$v_data['totol_communities'] = $this->users_model->count_items($community_table, $community_where);
		// end of counting
		$data['title'] =$v_data['title'] ;
		$data['content'] = $this->load->view('projects/projects/project_detail', $v_data, true);

		$this->load->view('admin/templates/general_page', $data);
	}
    public function add_project_item($project_id,$project_number)
    {

		$this->form_validation->set_rules('product_id', 'Product', 'required|xss_clean');
		$this->form_validation->set_rules('quantity', 'Quantity', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->projects_model->add_project_item($project_id))
			{
				$this->session->set_userdata('success_message', 'project created successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'Something went wrong, please try again');
			}
		}
		else
		{

		}
		$v_data['title'] = 'Add project Item to '.$project_number;
		$v_data['project_status_query'] = $this->projects_model->get_project_status();
		$v_data['products_query'] = $this->products_model->all_products();
		$v_data['project_number'] = $project_number;
		$v_data['project_id'] = $project_id;
		$v_data['project_item_query'] = $this->projects_model->get_project_items($project_id);
		$v_data['project_suppliers'] = $this->projects_model->get_project_suppliers($project_id);

		$v_data['suppliers_query'] = $this->suppliers_model->all_suppliers();
		$data['content'] = $this->load->view('projects/project_item', $v_data, true);

		$this->load->view('admin/templates/general_page', $data);
    }


    public function print_lpo_new($supplier_project_id)
	{
		$data = array('supplier_project_id'=>$supplier_project_id);

		$data['contacts'] = $this->site_model->get_contacts();
		
		$this->load->view('projects/views/lpo_print', $data);
		
	}
	public function print_rfq_new($project_id,$supplier_id,$project_number)
	{
		$data = array('project_id'=>$project_id,'supplier_id'=>$supplier_id,'project_number'=>$project_number);

		$data['contacts'] = $this->site_model->get_contacts();
		
		$this->load->view('projects/views/request_for_quotation', $data);
		
	}

    public function update_project_item($project_id,$project_number,$project_item_id)
    {
    	$this->form_validation->set_rules('quantity', 'Quantity', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
	    	if($this->projects_model->update_project_item($project_id,$project_item_id))
			{
				$this->session->set_userdata('success_message', 'project Item updated successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'project Item was not updated');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('tree-planting/add-project-item/'.$project_id.'/'.$project_number.'');

    }
    public function update_supplier_prices($project_id,$project_number,$project_item_id)
    {
    	$this->form_validation->set_rules('unit_price', 'Unit Price', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
	    	if($this->projects_model->update_project_item_price($project_id,$project_item_id))
			{
				$this->session->set_userdata('success_message', 'project Item updated successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'project Item was not updated');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'Sorry, Please enter a number in the field');
		}
		redirect('tree-planting/add-project-item/'.$project_id.'/'.$project_number.'');

    }
    public function submit_supplier($project_id,$project_number)
    {
    	$this->form_validation->set_rules('supplier_id', 'Quantity', 'numeric|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->projects_model->add_supplier_to_project($project_id))
			{
				$this->session->set_userdata('success_message', 'project Item updated successfully');
			}
			else
			{
				$this->session->set_userdata('success_message', 'project Item updated successfully');
			}
		}
		else
		{
			$this->session->set_userdata('success_message', 'project Item updated successfully');
		}
		redirect('tree-planting/add-project-item/'.$project_id.'/'.$project_number.'');
    }
	/*
	*
	*	Edit an existing project
	*	@param int $project_id
	*
	*/
	public function edit_project($project_id,$project_number) 
	{
		//form validation rules
		$this->form_validation->set_rules('project_instructions', 'project Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'required|xss_clean');
		$this->form_validation->set_rules('project_end_date', 'Project End Date', 'required|xss_clean');

		$this->form_validation->set_rules('project_donor', 'Donor', 'required|xss_clean');
		$this->form_validation->set_rules('project_title', 'Project Title', 'required|xss_clean');
		$this->form_validation->set_rules('project_location', 'Project Location', 'required|xss_clean');

		$this->form_validation->set_rules('project_grant_value', 'Project Grant Value', 'required|xss_clean');
		$this->form_validation->set_rules('project_grant_county', 'Project grant county', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project
			if($this->projects_model->update_project($project_id))
			{
				$this->session->set_userdata('success_message', 'project updated successfully');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update project. Please try again');
			}
		}
		
		//open the add new project
		$data['title'] = 'Edit project';
		
		//select the project from the database
		$query = $this->projects_model->get_project($project_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['project'] = $query;
			$query_uploads = $this->projects_model->get_project_uploads($project_id);
			$v_data['query_uploads'] = $query_uploads;
			$county_order = 'county_name';
			$county_table = 'counties';
			$county_where = 'county_status = 1';

			$county_query = $this->projects_model->get_active_list($county_table, $county_where, $county_order);
			$rs8 = $county_query->result();
			$county_list = '';
			foreach ($rs8 as $county_rs) :
				$county_id = $county_rs->county_id;
				$county_name = $county_rs->county_name;

			    $county_list .="<option value='".$county_id."'>".$county_name."</option>";

			endforeach;

			$v_data['county_list'] = $county_list;
			$data['content'] = $this->load->view('projects/projects/edit_project', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Project does not exist';
		}
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add products to an project
	*	@param int $project_id
	*	@param int $product_id
	*	@param int $quantity
	*
	*/
	public function add_product($project_id, $product_id, $quantity, $price)
	{
		if($this->projects_model->add_product($project_id, $product_id, $quantity, $price))
		{
			redirect('edit-project/'.$project_id);
		}
	}
    
	/*
	*
	*	Add products to an project
	*	@param int $project_id
	*	@param int $project_item_id
	*	@param int $quantity
	*
	*/
	public function update_cart($project_id, $project_item_id, $quantity)
	{
		if($this->projects_model->update_cart($project_item_id, $quantity))
		{
			redirect('edit-project/'.$project_id);
		}
	}
    
	/*
	*
	*	Delete an existing project
	*	@param int $project_id
	*
	*/
	public function delete_project($project_id)
	{
		//delete project
		$this->db->delete('projects', array('project_id' => $project_id));
		$this->db->delete('project_item', array('project_item_id' => $project_id));
		redirect('all-projects');
	}
    
	/*
	*
	*	Add products to an project
	*	@param int $project_item_id
	*
	*/
	public function delete_project_item($project_id, $project_item_id)
	{
		if($this->projects_model->delete_project_item($project_item_id))
		{
			redirect('edit-project/'.$project_id);
		}
	}
    
	/*
	*
	*	Complete an project
	*	@param int $project_id
	*
	*/
	public function finish_project($project_id)
	{
		$data = array(
					'project_status'=>2
				);
				
		$this->db->where('project_id = '.$project_id);
		$this->db->update('projects', $data);
		
		redirect('all-projects');
	}
	public function send_project_for_correction($project_id)
	{

    	$data = array(
					'project_approval_status'=>0,
					'project_status_id'=>1
				);
				
		$this->db->where('project_id = '.$project_id);
		$this->db->update('projects', $data);
		
		redirect('tree-planting/projects');
	}
    public function send_project_for_approval($project_id,$project_status= NULL)
    {
    	if($project_status == NULL)
    	{
    		$project_status = 1;
    	}
    	else
    	{
    		$project_status = $project_status;
    	}
    	
		$this->projects_model->update_project_status($project_id,$project_status);


		redirect('tree-planting/projects');
    }
	/*
	*
	*	Cancel an project
	*	@param int $project_id
	*
	*/
	public function cancel_project($project_id)
	{
		$data = array(
					'project_status'=>3
				);
				
		$this->db->where('project_id = '.$project_id);
		$this->db->update('projects', $data);
		
		redirect('all-projects');
	}
    
	/*
	*
	*	Deactivate an project
	*	@param int $project_id
	*
	*/
	public function deactivate_project($project_id)
	{
		$data = array(
					'project_status'=>1
				);
				
		$this->db->where('project_id = '.$project_id);
		$this->db->update('projects', $data);
		
		redirect('all-projects');
	}

	public function upload_project_documents($project_id,$project_number)
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
			
			if($this->projects_model->add_project_upload($file_name, $project_id))
			{
				$this->session->set_userdata('success_message', 'Document was uploaded successfully added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add post. Please try again');
			}
			redirect('tree-planting/project-edit/'.$project_id.'/'.$project_number);
		}

	}
}
?>