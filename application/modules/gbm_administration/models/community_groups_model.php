<?php

class Community_groups_model extends CI_Model 
{	
	/*
	*	Retrieve all community_group
	*
	*/
	public function all_community_groups()
	{
		$this->db->where('community_group_status = 1');
		$this->db->order_by('community_group_name');
		$query = $this->db->get('community_group');
		
		return $query;
	}
	
	/*
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_community_groups($table, $where, $per_page, $page, $order = 'community_group_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	
	/*
	*	Add a new company
	*	@param string $image_name
	*
	*/
	public function add_community_group($project_id)
	{
		$data = array(
				'community_group_name'=>$this->input->post('community_group_name'),
				'community_group_contact_person_name'=>$this->input->post('community_group_contact_person_name'),
				'community_group_contact_person_phone1'=>$this->input->post('community_group_contact_person_phone1'),
				'bank_name'=>$this->input->post('bank_name'),
				'account_name'=>$this->input->post('account_name'),
				'account_number'=>$this->input->post('account_number'),
				'now_activities'=>$this->input->post('now_activities'),
				'later_activities'=>$this->input->post('later_activities'),
				'chief'=>$this->input->post('chief_name'),
				'sub_chief'=>$this->input->post('sub_chief_name'),
				'address'=>$this->input->post('address'),
				'location'=>$this->input->post('location'),
				'county'=>$this->input->post('county'),
				'mp'=>$this->input->post('mp'),
				'community_group_status'=>0,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('personnel_id'),
				'modified_by'=>$this->session->userdata('personnel_id'),
				'project_id'=> $project_id,
				'project_area_id'=> $project_id
			);
			
		if($this->db->insert('community_group', $data))
		{
			$community_group_id = $this->db->insert_id();
			
			$arrayName = array(
			'project_area_id' => $project_id,
			'project_id' => $project_id,
			'nursery_id' => $community_group_id,
			'created' => date('Y-m-d'),
			'created_by' => $this->session->userdata('personnel_id')
			 );
			if($this->db->insert('seedling_production',$arrayName))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	//branch details
	public function get_branch_details()
	{
		$this->db->from('branch');
		$this->db->select('branch.*');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Update an existing company
	*	@param string $image_name
	*	@param int $company_id
	*
	*/
	public function update_community_group($company_id)
	{
		$data = array(
				'community_group_name'=>$this->input->post('community_group_name'),
				'community_group_contact_person_name'=>$this->input->post('community_group_contact_person_name'),
				'community_group_contact_person_phone1'=>$this->input->post('community_group_contact_person_phone1'),
				'community_group_contact_person_phone2'=>$this->input->post('community_group_contact_person_phone2'),
				'community_group_contact_person_email1'=>$this->input->post('community_group_contact_person_email1'),
				'community_group_contact_person_email2'=>$this->input->post('community_group_contact_person_email2'),
				'community_group_description'=>$this->input->post('community_group_description'),
				'community_group_status'=>$this->input->post('community_group_status'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		$this->db->where('community_group_id', $company_id);
		if($this->db->update('community_group', $data))
		{
			
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single company's details
	*	@param int $company_id
	*
	*/
	public function get_community_group($company_id)
	{
		//retrieve all users
		$this->db->from('community_group');
		$this->db->select('*');
		$this->db->where('community_group_id = '.$company_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing company
	*	@param int $company_id
	*
	*/
	public function delete_community_group($company_id)
	{
		if($this->db->delete('community_group', array('community_group_id' => $company_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated company
	*	@param int $company_id
	*
	*/
	public function activate_community_group($company_id)
	{
		$data = array(
				'community_group_status' => 1
			);
		$this->db->where('community_group_id', $company_id);
		
		if($this->db->update('community_group', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated company
	*	@param int $company_id
	*
	*/
	public function deactivate_community_group($company_id)
	{
		$data = array(
				'community_group_status' => 0
			);
		$this->db->where('community_group_id', $company_id);
		
		if($this->db->update('community_group', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	//import template
	function import_community_template()
	{
		$this->load->library('Excel');
		
		$title = 'Projects Community Group Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Community Group Name';
		$report[$row_count][1] = 'Contact Person Name';
		$report[$row_count][2] = 'Contact Person Phone';
		$report[$row_count][3] = 'Group Bank Name';
		$report[$row_count][4] = 'Account Name';
		$report[$row_count][5] = 'Account Number';
		$report[$row_count][6] = 'Current Activities';
		$report[$row_count][7] = 'Later Activities';
		$report[$row_count][8] = 'Chief';
		$report[$row_count][9] = 'Sub Chief';
		$report[$row_count][10] = 'Address';
		$report[$row_count][11] = 'Location';
		$report[$row_count][12] = 'County';
		$report[$row_count][13] = 'MP';

		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}

	//import projects
	public function import_csv_community_group($upload_path,$project_id)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_projects_data($array,$project_id);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	//sort the projects imported into the db
	public function sort_projects_data($array,$project_id)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		// var_dump($total_columns); die();
		if(($total_rows > 0) && ($total_columns == 14))
		{
			$items['created_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Community Group Name</th>
						  <th>Contact Person Name</th>
						</tr>
					  </thead>
					  <tbody>



			';
			
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{


				$items['community_group_name'] = $array[$r][0]; 
				$items['community_group_contact_person_name'] = $array[$r][1];
				$items['community_group_contact_person_phone1'] = $array[$r][2]; 
				$items['bank_name'] = $array[$r][3];
				$items['account_name'] = $array[$r][4]; 
				$items['account_number'] = $array[$r][5]; 
				$items['now_activities'] = $array[$r][6]; 
				$items['later_activities'] = $array[$r][7]; 
				$items['chief'] = $array[$r][8]; 
				$items['sub_chief'] = $array[$r][9]; 
				$items['address'] = $array[$r][10]; 
				$items['location'] = $array[$r][11];
				$items['county'] = $array[$r][12];
				$items['mp'] = $array[$r][13]; 
				$items['community_group_status'] = 1;
				$items['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['modified_by'] = $this->session->userdata('personnel_id');
				$items['project_id'] =  $project_id;
				$items['project_area_id'] =  $project_id;
				
				$comment ='';
				//var_dump($items);die();
				
				if($this->db->insert('community_group', $items))
				{
					$community_group_id = $this->db->insert_id();
					
					$arrayName = array(
					'project_area_id' => $project_id,
					'project_id' => $project_id,
					'nursery_id' => $community_group_id,
					'created' => date('Y-m-d'),
					'created_by' => $this->session->userdata('personnel_id')
					 );
					if($this->db->insert('seedling_production',$arrayName))
					{
						$comment .= '<br/>Community Group successfully added to the database';
						$class = 'success';
					}
					else
					{
						$comment .= '<br/>Internal error. Could not add project to the database. Please contact the site administrator';
						$class = 'warning';
					}
					
				}
				else{
					$comment .= '<br/>Internal error. Could not add project to the database. Please contact the site administrator';
					$class = 'warning';
				}
				
				

				
				$response .= '
								<tr class="'.$class.'">
									<td>'.$r.'</td>
									<td'.$items['community_group_name'].'</td>
									<td'.$items['community_group_contact_person_name'].'</td>
									<td'.$comment.'</td>
								</tr> 
						';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		//if no products exist
		else
		{
			$return['response'] = 'Member data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}





	//import template
	function import_community_members_template()
	{
		$this->load->library('Excel');
		
		$title = 'Projects Community Group Members Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Name';
		$report[$row_count][1] = 'National ID';
		$report[$row_count][2] = 'Phone Number';
		$report[$row_count][3] = 'Member Type ID (i.e Charman  1, Secretary 2 , Treasurer 3 and Member 4)';

		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}

	//import projects
	public function import_csv_community_group_members($upload_path,$community_group_id)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_community_group_member_data($array,$community_group_id);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	//sort the projects imported into the db
	public function sort_community_group_member_data($array,$community_group_id)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		// var_dump($total_columns); die();
		if(($total_rows > 0) && ($total_columns == 4))
		{
			$items['created_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Name</th>
						  <th>National ID</th>
						</tr>
					  </thead>
					  <tbody>';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{


				$items['community_group_member_name'] = $array[$r][0]; 
				$items['community_group_member_national_id'] = $array[$r][1];
				$items['community_group_member_phone_number'] = $array[$r][2]; 
				$items['member_type_id'] = $array[$r][3];
				$items['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['community_group_id'] =  $community_group_id;
				$items['community_group_member_status'] =  1;

				$comment ='';

				if($this->db->insert('community_group_member', $items))
				{
					$comment .= '<br/>Community Group successfully added to the database';
					$class = 'success';
				}
				else{
					$comment .= '<br/>Internal error. Could not add project to the database. Please contact the site administrator';
					$class = 'warning';
				}
				

				
				$response .= '
								<tr class="'.$class.'">
									<td>'.$r.'</td>
									<td'.$items['community_group_member_name'].'</td>
									<td'.$items['community_group_member_national_id'].'</td>
									<td'.$comment.'</td>
								</tr> 
						';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		//if no products exist
		else
		{
			$return['response'] = 'Member data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
}
?>