<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Seedling_production extends admin {
	var $csv_path;
	function __construct()
	{
		parent:: __construct();
		$this->load->model('seedling_production_model');
		$this->load->model('projects_model');
		$this->load->model('admin/users_model');

		//path to imports
		$this->csv_path = realpath(APPPATH . '../assets/csv');
	}
    
	

	public function index($project_id)
	{

			
		$where = 'community_group.is_ctn = 0 
						AND seedling_production.project_id = projects.project_id 
						AND community_group.community_group_id = seedling_production.nursery_id 
						AND seedling_production.project_id  = '.$project_id;
		$table = 'seedling_production,community_group,projects';
	
		$segment = 4;
		$community_group_members_search = $this->session->userdata('all_community_group_members_search');
		
		if(!empty($community_group_members_search))
		{
			$where .= $community_group_members_search;	
			
		}
		//pagination
		
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/seedling-production/'.$project_id;
		$config['total_rows'] = $this->seedling_production_model->count_items($table, $where);
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
		$query = $this->seedling_production_model->get_all_seedling_records($table, $where, $config["per_page"], $page);
		

		$community_group_order = 'community_group.community_group_name';
		$community_group_table = 'community_group';
		$community_group_where = 'community_group.community_group_status = 1 AND community_group.is_ctn = 0 AND community_group.project_id = '.$project_id.' AND community_group.community_group_id NOT IN (SELECT nursery_id FROM seedling_production)';

		$community_group_query = $this->seedling_production_model->get_active_list($community_group_table, $community_group_where, $community_group_order);
		$rs8 = $community_group_query->result();
		$community_group_list = '';
		foreach ($rs8 as $community_group_rs) :
			$community_group_id = $community_group_rs->community_group_id;
			$community_group_name = $community_group_rs->community_group_name;

		    $community_group_list .="<option value='".$community_group_id."'>".$community_group_name."</option>";

		endforeach;

		$v_data['community_group_list'] = $community_group_list;

		
		$data['title'] = 'Seedling Production';

		$v_data['title'] = $data['title'];
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['project_id'] = $project_id;
		$data['content'] = $this->load->view('seedling_production/all_seedling_production', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}
	
	public function print_seedling_production($seedling_production_id,$nursery_tally_id)
	{
		$where = 'seedling_production.seedling_production_id = nursery_tally.seedling_production_id AND seedling_production.seedling_production_id ='.$seedling_production_id.' AND nursery_tally.nursery_tally_id ='.$nursery_tally_id;
		$this->db->select( 'seedling_production.*, nursery_tally.month,nursery_tally.year');
		$this->db->where($where);
		
		$nursery_tally_details = $this->db->get('seedling_production, nursery_tally');
		
		if($nursery_tally_details->num_rows() > 0)
		{
			$row = $nursery_tally_details->result();
			$nursery_id = $row[0]->nursery_id;
			$seedling_product_id = $row[0]->seedling_production_id;
			$month =$row[0]->month;
			$year =$row[0]->year;
			$project_area_id =$row[0]->project_area_id;
		}
		$data['nursery_id'] = $nursery_id;
		$data['seedling_product_id'] = $seedling_product_id;
		$data['title'] = 'Nursery Report';
		$data['month'] = $month;
		$data['year'] = $year;
		$data['project_area_id'] = $project_area_id;
		$data['seedling_product_id'] = $seedling_product_id;
		$data['seedling_production_info'] = $this->seedling_production_model->get_monthly_tally($seedling_product_id);
		$data['community_group_info'] = $this->seedling_production_model->get_community_info($nursery_id);
		$data['nursery_info'] = $this->seedling_production_model->get_nursery_details($nursery_id);
		$data['branch_data'] = $this->seedling_production_model->get_branch_details();
		$this->load->view('seedling_production/nursery_report', $data);
	}

	public function add_seedling_production($project_area_id)
	{
		//form validation rules
		$this->form_validation->set_rules('community_group_id', 'Community Group', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if community_group_member has valid login credentials
			if($this->seedling_production_model->add_seedling_production($project_area_id))
			{
				$this->session->unset_userdata('community_group_members_error_message');
				$this->session->set_userdata('success_message', 'Seedling production data has been successfully added');

				redirect('tree-planting/seedling-production/'.$project_area_id);
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Sorry something went wrong. Please try again');
				redirect('tree-planting/seedling-production/'.$project_area_id);
			}
		}
	}

	public function tally_sheet($seedling_production_id , $project_id)
	{
		$where = 'seedling_production_id = '.$seedling_production_id;
		$table = 'nursery_tally';
	
		$segment = 5;
	
		//pagination
		
		$this->load->library('pagination');
		$config['base_url'] = site_url().'tree-planting/seedling-tally/'.$seedling_production_id.'/'.$project_id;
		$config['total_rows'] = $this->seedling_production_model->count_items($table, $where);
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
		$query = $this->seedling_production_model->get_monthly_records($table, $where, $config["per_page"], $page);
		

		$community_group_order = 'community_group.community_group_name';
		$community_group_table = 'community_group,seedling_production';
		$community_group_where = 'community_group.community_group_status = 1 AND community_group.community_group_id = seedling_production.nursery_id';

		$community_group_query = $this->seedling_production_model->get_active_list($community_group_table, $community_group_where, $community_group_order);
		$rs8 = $community_group_query->result();


		$community_group_list = '';
		foreach ($rs8 as $community_group_rs) :
			$community_group_id = $community_group_rs->community_group_id;
			$community_group_name = $community_group_rs->community_group_name;

		    $community_group_list .="<option value='".$community_group_id."'>".$community_group_name."</option>";

		endforeach;

		$v_data['community_group_list'] = $community_group_list;



		$seedling_type_order = 'seedling_type.seedling_type_name';
		$seedling_type_table = 'seedling_type';
		$seedling_type_where = 'seedling_type.seedling_type_id > 0';

		$seedling_type_query = $this->seedling_production_model->get_active_list($seedling_type_table, $seedling_type_where, $seedling_type_order);
		$rs10 = $seedling_type_query->result();


		$seedling_type_list = '';
		foreach ($rs10 as $seedling_type_rs) :
			$seedling_type_id = $seedling_type_rs->seedling_type_id;
			$seedling_type_name = $seedling_type_rs->seedling_type_name;

		    $seedling_type_list .="<option value='".$seedling_type_id."'>".$seedling_type_name."</option>";

		endforeach;

		$v_data['seedling_type_list'] = $seedling_type_list;
		$v_data['seedling_type_rs'] = $rs10;


		$seedling_status_order = 'seedling_status.seedling_status_name';
		$seedling_status_table = 'seedling_status';
		$seedling_status_where = 'seedling_status.seedling_status_id > 0';

		$seedling_status_query = $this->seedling_production_model->get_active_list($seedling_status_table, $seedling_status_where, $seedling_status_order);
		$rs11 = $seedling_status_query->result();


		$seedling_status_list = '';
		foreach ($rs11 as $seedling_status_rs) :
			$seedling_status_id = $seedling_status_rs->seedling_status_id;
			$seedling_status_name = $seedling_status_rs->seedling_status_name;

		    $seedling_status_list .="<option value='".$seedling_status_id."'>".$seedling_status_name."</option>";

		endforeach;

		$v_data['seedling_status_list'] = $seedling_status_list;
		$v_data['seedling_status_rs'] = $rs11;

		
		$data['title'] = 'Nursery Tally Sheet';

		$v_data['title'] = $data['title'];
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['project_id'] = $project_id;
		$v_data['seedling_production_id'] = $seedling_production_id;
		$data['content'] = $this->load->view('seedling_production/tally_sheet', $v_data, true);
		
		$this->load->view('admin/templates/general_page', $data);
	}

	public function add_seedling_production_tally($seedling_production_id,$project_area_id)
	{
		//form validation rules
		$this->form_validation->set_rules('seedling_type_id', 'Seedling Type', 'required|xss_clean');
		$this->form_validation->set_rules('seedling_status_id', 'Seedling Status', 'required|xss_clean');
		$this->form_validation->set_rules('month_id', 'Month', 'required|xss_clean');
		$this->form_validation->set_rules('year', 'year', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			// var_dump($_POST); die();
			//check if community_group_member has valid login credentials
			if($this->seedling_production_model->add_seedling_production_tally($seedling_production_id))
			{
				$this->session->unset_userdata('community_group_members_error_message');
				$this->session->set_userdata('success_message', 'Seedling production data has been successfully added');

				redirect('tree-planting/seedling-tally/'.$seedling_production_id.'/'.$project_area_id);
				
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Sorry something went wrong. Please try again');
				redirect('tree-planting/seedling-tally/'.$seedling_production_id.'/'.$project_area_id);
			}
		}
	}

	public function import_seedling_production_template()
	{
		//export projects template in excel 
		$this->seedling_production_model->import_seedling_production_template();
	}

	//do the project import
	function do_seedling_production_import($seedling_production_id,$project_id)
	{
		if(isset($_FILES['import_csv']))
		{
			if(is_uploaded_file($_FILES['import_csv']['tmp_name']))
			{
				//import products from excel 
				$response = $this->seedling_production_model->import_csv_seedling_production($this->csv_path,$seedling_production_id);
				
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
		
		redirect ('tree-planting/seedling-tally/'.$seedling_production_id.'/'.$project_id);
	}

}