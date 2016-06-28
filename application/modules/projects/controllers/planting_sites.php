<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Planting_sites extends admin 
{
	var $documents_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('planting_sites_model');
		$this->load->model('projects_model');
		$this->load->model('meeting_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/file_model');		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->documents_path = realpath(APPPATH . '../assets/documents/projects');
		
		
	}
    
	

	// project area locations



	/*
	*
	*	Default action is to show all the project_planting_sites
	*
	*/
	public function index($project_id,$step_id = 0,$order = 'site_name', $order_method = 'ASC') 
	{
		$where = 'planting_site.project_id  = '.$project_id;
		$table = 'planting_site';
		//pagination
		$segment = 8;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/planting-sites/'.$project_id.'/'.$step_id.'/'.$order.'/'.$order_method;
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
		$query = $this->planting_sites_model->get_all_project_planting_sites($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Planting Sites';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['project_id'] = $project_id;
		$v_data['step_id'] = $step_id;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_planting_sites/all_project_planting_sites', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new project_area
	*
	*/
	public function add_planting_site($project_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('site_name', 'Site Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->planting_sites_model->add_planting_site($project_id))
			{
				$this->session->set_userdata('success_message', 'Target Area Location added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add project_area. Please try again');
			}
		}
		redirect('tree-planting/planting-sites/'.$project_id);
	}

    
	/*
	*
	*	Edit an existing project_area
	*	@param int $site_id
	*
	*/
	public function edit_project_planting_site($project_id,$site_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('site_name', 'Site Name', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->planting_sites_model->update_project_planting_site($project_id,$site_id))
			{
				$this->session->set_userdata('success_message', 'project_area updated successfully');
				redirect('tree-planting/planting-sites');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update project_area. Please try again');
			}
		}
		
		//open the add new project_area
		$data['title'] = 'Edit planting site';
		$v_data['title'] = $data['title'];
		$v_data['site_id'] = $site_id;
		
		//select the project_area from the database
		$query = $this->planting_sites_model->get_project_planting_site($site_id);
		
		$v_data['project_area'] = $query->result();
		
		$data['content'] = $this->load->view('project_planting_sites/edit_project_planting_site', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Delete an existing project_area
	*	@param int $site_id
	*
	*/
	public function delete_project_planting_site($site_id)
	{
		$this->planting_sites_model->delete_project_planting_site($site_id);
		$this->session->set_userdata('success_message', 'project_area has been deleted');
		
		redirect('tree-planting/planting-sites');
	}
    
	/*
	*
	*	Activate an existing project_area
	*	@param int $site_id
	*
	*/
	public function activate_planting_site($project_id,$site_id)
	{
		$this->planting_sites_model->activate_planting_site($site_id);
		$this->session->set_userdata('success_message', 'project_area activated successfully');
		
		redirect('tree-planting/planting-sites/'.$project_id);
	}
    
	/*
	*
	*	Deactivate an existing project_area
	*	@param int $site_id
	*
	*/
	public function deactivate_planting_site($project_id,$site_id)
	{
		$this->planting_sites_model->deactivate_planting_site($site_id);
		$this->session->set_userdata('success_message', 'project_area disabled successfully');
		
		redirect('tree-planting/planting-sites/'.$project_id);
	}

	/*
	*
	*	Default action is to show all the project_planting_sites
	*
	*/
	public function activities($project_id,$site_id,$step_id = 0) 
	{
		// var_dump($step_id); die();
		 $where = 'projects.project_id = casual_payment.cp_project_id AND counties.county_id = projects.project_id AND casual_payment.cp_planting_site_id  = '.$site_id.' AND casual_payment.cp_step = '.$step_id;
		$table = 'casual_payment,projects,counties';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/activities/'.$project_id.'/'.$site_id.'/'.$step_id;
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
		$query = $this->planting_sites_model->get_all_site_activities($table, $where, $config["per_page"], $page, $order='cp_id', $order_method = 'DESC');
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Planting Site Activities';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['project_id'] = $project_id;
		$v_data['site_id'] = $site_id;
		$v_data['step_id'] = $step_id;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_planting_sites/site_activities', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function follow_up($project_id,$site_id,$step_id = 0) 
	{
		// var_dump($step_id); die();
		 $where = 'projects.project_id = planting_followup.project_id AND planting_site.site_id = planting_followup.planting_site_id AND planting_followup.planting_site_id  = '.$site_id.' AND planting_followup.project_id = '.$project_id.' AND planting_followup.step_id = '.$step_id;
		$table = 'planting_followup,projects,planting_site';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'planting-site/follow-up/'.$project_id.'/'.$site_id.'/'.$step_id;
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
		$query = $this->planting_sites_model->get_all_site_activities($table, $where, $config["per_page"], $page, $order='followup_id', $order_method = 'DESC');
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Follow up';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['project_id'] = $project_id;
		$v_data['site_id'] = $site_id;
		$v_data['step_id'] = $step_id;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_planting_sites/site_follow_up', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	public function add_activity($project_id,$site_id)
	{

		//form validation rules
		$this->form_validation->set_rules('payment_date', 'Payment Date', 'required|xss_clean');
		$this->form_validation->set_rules('activity_title', 'Activity Title', 'required|xss_clean');
		$this->form_validation->set_rules('payment_reason', 'Payment Date', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->planting_sites_model->add_activity($project_id,$site_id))
			{
				$this->session->set_userdata('success_message', 'Activity has been added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add the activity. Please try again');
			}

		}
		else
		{
			$this->session->set_userdata('error_message', 'Please fill in all the fields');
		}
		$step_id = $this->input->post('cp_step');
		// var_dump($step_id);
		redirect('planting-site/activities/'.$project_id.'/'.$site_id.'/'.$step_id);
	}
	public function add_followup($project_id,$site_id,$step_id)
	{
		//form validation rules
		$this->form_validation->set_rules('month_id', 'Month', 'required|xss_clean');
		$this->form_validation->set_rules('year', 'Year', 'required|xss_clean');
		$this->form_validation->set_rules('total_planted', 'Total Planted', 'required|xss_clean');
		$this->form_validation->set_rules('surviving_trees', 'surviving_trees', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update project_area
			if($this->planting_sites_model->add_followup($project_id,$site_id,$step_id))
			{
				$this->session->set_userdata('success_message', 'Followup has been added successfully');
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add the followup. Please try again');
			}

		}
		else
		{
			$this->session->set_userdata('error_message', 'Please fill in all the fields');
		}
		// var_dump($step_id);
		redirect('planting-site/follow-up/'.$project_id.'/'.$site_id.'/'.$step_id);
	}
	public function activity_participants($project_id,$cp_id)
	{
		$where = 'cp_id = '.$cp_id;
		$table = 'casual_payment_members';
		//pagination
		$segment = 5;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/activities/'.$project_id.'/'.$cp_id;
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
		$query = $this->planting_sites_model->get_all_site_activities($table, $where, $config["per_page"], $page, $order='cpm_name', $order_method='ASC');
		
		//change of order method 
		$data['title'] = 'Casual Laborers';
		$v_data['title'] = $data['title'];
		
		$v_data['project_id'] = $project_id;
		$v_data['cp_id'] = $cp_id;
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('project_planting_sites/cp_payment_member', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}

	public function print_activity_participants($project_id,$cp_id)
	{
		$where = 'cp_id = '.$cp_id;
		$table = 'casual_payment_members';
		$query = $this->planting_sites_model->get_all_site_activities($table, $where);
		
		//change of order method 
		
		$v_data['project_id'] = $project_id;
		$v_data['branch_data'] = $this->meeting_model->get_branch_details();
		$v_data['cp_id'] = $cp_id;
		$v_data['query'] = $query;
		
		$this->load->view('project_planting_sites/print_cp_payment_member', $v_data);
	}

	public function add_activity_attendee($project_id,$cp_id)
	{
		$this->form_validation->set_rules('cpm_name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('cpm_national_id', 'National ID', 'required|xss_clean');
		$this->form_validation->set_rules('cpm_phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('cpm_amount', 'Amount', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->planting_sites_model->add_cpm_attendee($cp_id))
			{
				$this->session->set_userdata('success_message', 'Member added successfully');
			}	
			else
			{
				$this->session->set_userdata('error_message', 'Something went wrong, please try again');
			}
		}
		else
		{
			$this->session->set_userdata('error_message', 'Something went wrong, please try again');
		}
		redirect('activity-participants/'.$project_id.'/'.$cp_id);
	}



}
?>