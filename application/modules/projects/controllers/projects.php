<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";
class Projects extends admin
{ 
	var $documents_path;
	var $csv_path;
	
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
		
		//path to imports
		$this->csv_path = realpath(APPPATH . '../assets/csv');
	}
    
	/*
	*
	*	Default action is to show all the projects
	*
	*/
	public function index($index =  NULL) 
	{
		// get my approval roles

		$where = 'projects.project_status_id = project_status.project_status_id AND projects.project_grant_county = counties.county_id';
		$table = 'projects, project_status,counties';
		//pagination
		
		if($index == NULL)
		{
			$segment = 3;
		}
		else
		{

			$segment = 4;
		}
		$this->load->library('pagination');
		$config['base_url'] = base_url().'tree-planting/projects';
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
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->projects_model->get_all_projects($table, $where, $config["per_page"], $page);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		$v_data['project_status_query'] = $this->projects_model->get_project_status();
		// $v_data['level_status'] = $this->projects_model->project_level_status();
		$v_data['title'] = "Projects";
		if($index == NULL)
		{
			// var_dump($index);die();
			$data['content'] = $this->load->view('projects/projects/all_projects', $v_data, true);
		}
		else
		{
			$data['content'] = $this->load->view('projects/projects/all_projects_list', $v_data, true);
		}
		
		
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
		
		// foreach ($_POST['watersheds'] as $key) {
		// 	# code...
			
		// 	echo $key."<hr>";
		// }
		// var_dump($_POST['watersheds']); die();
		//form validation rules
		$this->form_validation->set_rules('project_instructions', 'project Instructions', 'required|xss_clean');
		$this->form_validation->set_rules('project_start_date', 'Project Start Date', 'required|xss_clean');
		$this->form_validation->set_rules('project_end_date', 'Project End Date', 'required|xss_clean');

		$this->form_validation->set_rules('project_donor', 'Donor', 'required|xss_clean');
		$this->form_validation->set_rules('project_title', 'Project Title', 'required|xss_clean');
		$this->form_validation->set_rules('project_location', 'Project Location', 'required|xss_clean');

		$this->form_validation->set_rules('project_grant_value', 'Project Grant Value', 'required|xss_clean');
		$this->form_validation->set_rules('project_grant_county', 'Project grant county', 'required|xss_clean');
		$this->form_validation->set_rules('watersheds', 'Watersheds', 'required|xss_clean');
		// $this->form_validation->set_rules('planting_sites', 'Planting Sites', 'required|xss_clean');
		
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
			redirect('gbm-administration/projects');
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


		$project_area_order = 'project_areas.project_area_name';
		$project_area_table = 'project_areas';
		$project_area_where = 'project_area_status = 1';

		$project_area_query = $this->projects_model->get_active_list($project_area_table, $project_area_where, $project_area_order);
		$rs8 = $project_area_query->result();
		$water_sheds = '';
		foreach ($rs8 as $project_area_rs) :
			$project_area_id = $project_area_rs->project_area_id;
			$project_area_name = $project_area_rs->project_area_name;

		    $water_sheds .="<option value='".$project_area_id."'>".$project_area_name."</option>";

		endforeach;

		$v_data['water_sheds'] = $water_sheds;


		$site_order = 'planting_site.site_name';
		$site_table = 'planting_site';
		$site_where = 'status = 1';

		$site_query = $this->projects_model->get_active_list($site_table, $site_where, $site_order);
		$rs8 = $site_query->result();
		$planting_sites = '';
		foreach ($rs8 as $site_rs) :
			$site_id = $site_rs->site_id;
			$site_name = $site_rs->site_name;

		    $planting_sites .="<option value='".$site_id."'>".$site_name."</option>";

		endforeach;

		$v_data['planting_sites'] = $planting_sites;


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
    public function handover($project_id)
    {

    	$this->form_validation->set_rules('kfs_representative', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('gbm_representative', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_date', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_summery', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('meeting_venue', 'Quantity', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->projects_model->add_project_handover($project_id))
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
		redirect('tree-planting/project-handover/'.$project_id.'');

    }
    public function add_handover($project_id)
    {
    	$this->form_validation->set_rules('handover_attendee_name', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_attendee_national_id', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_attendee_phone', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_gender_id', 'Quantity', 'required|xss_clean');
    	$this->form_validation->set_rules('handover_attendee_organization', 'Quantity', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->projects_model->add_project_handover_attendee($project_id))
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
		redirect('tree-planting/project-handover/'.$project_id.'');
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
			
			$v_data['watershed_query'] = $this->project_areas_model->get_watershed_details($project_id);
			//var_dump($v_data['watershed_query']);die();
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
		redirect('gbm-administration');
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
		
		redirect('gbm-administration');
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
		
		redirect('gbm-administration');
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
		
		redirect('gbm-administration');
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

	public function upload_project_documents_page($project_id)
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
			
		}
		$redirect = $this->input->post('redirect_url');
		redirect($redirect);

	}
	//import projects
	function import_projects()
	{
		$v_data['title'] = $data['title'] = $this->site_model->display_page_title();
		
		$data['content'] = $this->load->view('import/import_projects', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	
	function import_projects_template()
	{
		//export projects template in excel 
		$this->projects_model->import_projects_template();
	}
	//do the project import
	function do_projects_import()
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->projects_model->import_csv_projects($this->csv_path);
				
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
		
		redirect ('gbm-administration/projects');
		//$data['content'] = $this->load->view('projects/all_projects', $v_data, true);
		//$this->load->view('admin/templates/general_page', $data);
	}
	public function project_handover($project_id)
	{
		$site_order = 'project_id = '.$project_id;
		$site_table = 'project_handover';
		$site_where = 'handover_status = 1';

		$handover_query = $this->projects_model->get_active_list($site_table, $site_where, $site_order);

		
		$v_data['title']= 'Project Handorver';
		$data['title'] = $v_data['title'];
		$v_data['project_id'] = $project_id;
		$data['content'] = $this->load->view('projects/projects/project_handover', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);


	}
	public function project_reports()
	{

		$where = 'projects.project_status_id = project_status.project_status_id AND projects.project_grant_county = counties.county_id';
		$table = 'projects, project_status,counties';
		//pagination
		
		
		$segment = 3;
		$this->load->library('pagination');
		$config['base_url'] = base_url().'reports/projects';
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
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->projects_model->get_all_projects($table, $where, $config["per_page"], $page);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		$v_data['project_status_query'] = $this->projects_model->get_project_status();
		// $v_data['level_status'] = $this->projects_model->project_level_status();
		$v_data['title'] = "Projects Reports";
		
		$data['content'] = $this->load->view('projects/reports/all_project_report', $v_data, true);
		
		$data['title'] = 'Projects Reports';
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function report($project_id)
	{
		$v_data['project_id'] = $project_id;
		$v_data['title'] = "Project Report";
		
		$data['content'] = $this->load->view('projects/reports/project_report', $v_data, true);
		
		$data['title'] = 'Project Report';
		
		$this->load->view('admin/templates/general_page', $data);

	}
}
?>