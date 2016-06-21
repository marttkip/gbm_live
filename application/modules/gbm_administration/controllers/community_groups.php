<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Community_groups extends admin 
{
	var $csv_path;
	function __construct()
	{
		parent:: __construct();
		$this->load->model('community_groups_model');
		$this->load->model('projects/projects_model');
		$this->load->model('admin/users_model');

		//path to imports
		$this->csv_path = realpath(APPPATH . '../assets/csv');
	}
    
	/*
	*
	*	Default action is to show all the community_groups
	*
	*/
	public function index($project_id, $order = 'community_group_name', $order_method = 'ASC') 
	{
		$where = 'community_group_id > 0 AND is_ctn = 0 AND  project_id ='.$project_id;
		$table = 'community_group';
		//pagination
		$segment = 6;
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/community-groups/'.$project_id.'/'.$order.'/'.$order_method;
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
		$query = $this->community_groups_model->get_all_community_groups($table, $where, $config["per_page"], $page, $order, $order_method);
		
		//change of order method 
		if($order_method == 'DESC')
		{
			$order_method = 'ASC';
		}
		
		else
		{
			$order_method = 'DESC';
		}
		
		$data['title'] = 'Community Groups';
		$v_data['title'] = $data['title'];
		
		$v_data['order'] = $order;
		$v_data['order_method'] = $order_method;
		$v_data['query'] = $query;
		$v_data['project_id'] = $project_id;
		$v_data['all_community_groups'] = $this->community_groups_model->all_community_groups();
		$v_data['page'] = $page;
		$data['content'] = $this->load->view('community_groups/all_community_groups', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new company
	*
	*/
	public function add_community_group($project_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('community_group_name', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_name', 'Contact name', 'xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_phone1', 'Contact phone 1', 'xss_clean');
		$this->form_validation->set_rules('community_group_description', 'Company description', 'xss_clean');
		$this->form_validation->set_rules('community_group_status', 'Company Status', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
		
			if($this->community_groups_model->add_community_group($project_id))
			{
				$this->session->set_userdata('success_message', 'Insurance company added successfully');
				redirect('tree-planting/community-groups/'.$project_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add insurance company. Please try again');
			}
		}
		
		$data['title'] = 'Add Community Group';
		$v_data['title'] = $data['title'];
		$v_data['project_id'] =$project_id;
		$data['content'] = $this->load->view('community_groups/add_community_group', $v_data, true);
		$this->load->view('admin/templates/general_page', $data);
	}
	
    //print community group details
	public function print_community_group($community_group_id)
	{
		$where = 'community_group_id ='.$community_group_id;
		$this->db->select( '*');
		$this->db->where($where);
		$group_details = $this->db->get('community_group');
		
		if($group_details->num_rows() > 0)
		{
			$row = $group_details->result();
			$community_group_name = $row[0]->community_group_name;
			$address = $row[0]->address;
			$location = $row[0]->location;
			$sub_location = $row[0]->sub_location;
			$county = $row[0]->county;
			$chief = $row[0]->chief;
			$sub_chief = $row[0]->sub_chief;
			$mp = $row[0]->mp;
			$now_activities = $row[0]->now_activities;
			$account_number = $row[0]->account_number;
			$later_activities = $row[0]->later_activities;
			$community_group_contact_person_phone1 = $row[0]->community_group_contact_person_phone1;
			$community_group_contact_person_name = $row[0]->community_group_contact_person_name;
		}
		$data['community_group_name'] = $community_group_name;
		$data['address'] = $address;
		$data['location'] = $location;
		$data['sub_location'] = $sub_location;
		$data['county'] = $county;
		$data['chief'] = $chief;
		$data['sub_chief'] = $sub_chief;
		$data['mp'] = $mp;
		$data['now_activities'] = $now_activities;
		$data['account_number'] = $account_number;
		$data['later_activities'] = $later_activities;
		$data['community_group_contact_person_phone1'] = $community_group_contact_person_phone1;
		$data['community_group_contact_person_name']=$community_group_contact_person_name;
		$data['branch_data'] = $this->community_groups_model->get_branch_details();
		$this->load->view('community_groups/print_group', $data);
		
	}
	
	/*
	*
	*	Edit an existing company
	*	@param int $company_id
	*
	*/
	public function edit_community_group($company_id,$project_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('community_group_name', 'Company Name', 'required|xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_name', 'Contact name', 'xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_phone1', 'Contact phone 1', 'xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_phone2', 'Contact phone 2', 'xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_email1', 'Contact email 1', 'valid_email|xss_clean');
		$this->form_validation->set_rules('community_group_contact_person_email2', 'Contact email 2', 'valid_email|xss_clean');
		$this->form_validation->set_rules('community_group_description', 'Company description', 'xss_clean');
		$this->form_validation->set_rules('community_group_status', 'Company Status', 'xss_clean');
		$this->form_validation->set_rules('pricing_rate', 'Pricing Rate', 'xss_clean');
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update company
			if($this->community_groups_model->update_community_group($company_id))
			{
				$this->session->set_userdata('success_message', 'Company updated successfully');
				redirect('tree-planting/community-groups/'.$project_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update company. Please try again');
			}
		}
		
		//open the add new company
		$data['title'] = 'Edit Community Group';
		$v_data['title'] = $data['title'];
		
		//select the company from the database
		$query = $this->community_groups_model->get_community_group($company_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['company_array'] = $query->row();
			
			$data['content'] = $this->load->view('community_groups/edit_community_group', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Company does not exist';
		}
		
		$this->load->view('admin/templates/general_page', $data);
	}
    
	/*
	*
	*	Delete an existing company
	*	@param int $company_id
	*
	*/
	public function delete_community_group($company_id,$project_id)
	{
		$this->community_groups_model->delete_community_group($company_id);
		$this->session->set_userdata('success_message', 'Company has been deleted');
		redirect('tree-planting/community-groups/'.$project_id);
	}
    
	/*
	*
	*	Activate an existing company
	*	@param int $company_id
	*
	*/
	public function activate_community_group($company_id,$project_id)
	{
		$this->community_groups_model->activate_community_group($company_id);
		$this->session->set_userdata('success_message', 'Company activated successfully');
		redirect('tree-planting/community-groups/'.$project_id);
	}
    
	/*
	*
	*	Deactivate an existing company
	*	@param int $company_id
	*
	*/
	public function deactivate_community_group($company_id,$project_id)
	{
		$this->community_groups_model->deactivate_community_group($company_id);
		$this->session->set_userdata('success_message', 'Company disabled successfully');
		redirect('tree-planting/community-groups/'.$project_id);
	}

	//  imports 

	public function import_community_template()
	{
		//export projects template in excel 
		$this->community_groups_model->import_community_template();
	}

	//do the project import
	function do_community_import($project_id)
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->community_groups_model->import_csv_community_group($this->csv_path,$project_id);
				
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
		
		redirect ('tree-planting/community-groups/'.$project_id);
	}


	public function import_community_members_template()
	{
		//export projects template in excel 
		$this->community_groups_model->import_community_members_template();
	}

	//do the project import
	function do_community_members_import($community_group_id,$project_id)
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->community_groups_model->import_csv_community_group_members($this->csv_path,$community_group_id);
				
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
		
		redirect ('tree-planting/group-members/'.$community_group_id.'/'.$project_id);
	}
}
?>