<?php

class Projects_model extends CI_Model 
{
	/*
	*	Retrieve all projects
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_projects($table, $where, $per_page, $page)
	{
		//retrieve all projects
		$this->db->from($table);
		$this->db->select('projects.*,project_status.project_status_name,counties.county_name');
		$this->db->where($where);
		$this->db->order_by('projects.created, project_number');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function get_project_content($table, $where,$select)
	{
		$this->db->from($table);
		$this->db->select($select);
		$this->db->where($where);
		$query = $this->db->get('');
		
		return $query;
	}
	
	/*
	*	Retrieve all projects of a user
	*
	*/
	public function get_user_projects($user_id)
	{
		$this->db->where('user_id = '.$user_id);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('projects');
		
		return $query;
	}
	public function get_community_groups()
	{
		$this->db->where('community_group_id > 0 ');
		$query = $this->db->get('community_group');
		
		return $query;
	}
	public function get_project_handover($project_id)
	{
		$this->db->where('project_id = '.$project_id);
		$query = $this->db->get('project_handover');
		
		return $query;

	}
	public function get_project_suppliers($project_id)
	{
		$this->db->where('supplier.supplier_id = supplier_project.supplier_id AND supplier_project.project_id = '.$project_id);
		$query = $this->db->get('supplier,supplier_project');
		
		return $query;
	}
	public function get_supplier_project_details($supplier_project_id)
	{
		$this->db->where('supplier.supplier_id = supplier_project.supplier_id AND projects.project_id = supplier_project.project_id AND supplier_project.supplier_project_id = '.$supplier_project_id);
		$query = $this->db->get('supplier,supplier_project,projects');
		
		return $query;
	}
	public function get_project_approval_status($project_id)
	{
		$this->db->select('project_approval_status');
		$this->db->where('project_id = '.$project_id);
		$query = $this->db->get('projects');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $key) {
				# code...
				$project_approval_status = $key->project_approval_status;
			}
		}
		else
		{
			$project_approval_status = 0;
		}
		return $project_approval_status;
	}
	
	/*
	*	Retrieve an project
	*
	*/
	public function get_project($project_id)
	{
		$this->db->select('*');
		$this->db->where('projects.project_status_id = project_status.project_status_id AND projects.project_grant_county = counties.county_id AND projects.project_id = '.$project_id);
		$query = $this->db->get('projects, project_status,counties');
		
		return $query;
	}
	/*
	*	Retrieve all projects
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_project_status()
	{
		//retrieve all projects
		$this->db->from('project_status');
		$this->db->select('*');
		$this->db->order_by('project_status_name');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all project items of an project
	*
	*/
	public function get_project_items($project_id)
	{
		$this->db->select('product.product_name, project_item.*');
		$this->db->where('product.product_id = project_item.product_id AND project_item.project_id = '.$project_id);
		$query = $this->db->get('project_item, product');
		
		return $query;
	}

	public function add_project_handover($project_id)
	{
		//retrieve all projects
		$this->db->from('project_handover');
		$this->db->select('*');
		$this->db->where('project_id = '.$project_id);
		$query = $this->db->get();

		$data = array(
						'kfs_representative'=>$this->input->post('kfs_representative'),
						'gbm_representative'=>$this->input->post('gbm_representative'),
						'handover_date'=>$this->input->post('handover_date'),
						'handover_summery'=>$this->input->post('handover_summery'),
						'meeting_venue'=>$this->input->post('meeting_venue'),
					 );
		if($query->num_rows() > 0)
		{
			// update
			$this->db->where('project_id = '.$project_id);
			$this->db->update('project_handover',$data);
		}
		else
		{
			$data['project_id'] = $project_id;
			// insert 
			$this->db->insert('project_handover',$data);

		}
	}
	public function add_project_handover_attendee($project_id)
	{
		$data = array(
						'handover_attendee_name'=>$this->input->post('handover_attendee_name'),
						'handover_attendee_national_id'=>$this->input->post('handover_attendee_national_id'),
						'handover_attendee_phone'=>$this->input->post('handover_attendee_phone'),
						'handover_gender_id'=>$this->input->post('handover_gender_id'),
						'handover_attendee_organization'=>$this->input->post('handover_attendee_organization'),
					 );
		$data['project_id'] = $project_id;
		if($this->db->insert('handover_attendee',$data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function get_project_handover_attendee($project_id)
	{
		$this->db->select('*');
		$this->db->where('project_id = '.$project_id);
		$query = $this->db->get('handover_attendee');
		
		return $query;
	}
	/*
	*	Retrieve all project items of an project
	*
	*/
	public function get_project_detail($project_id)
	{
		$this->db->select('*');
		$this->db->where('projects.project_id = '.$project_id);
		$query = $this->db->get('projects');
		
		return $query;
	}
	
	/*
	*	Create project number
	*
	*/
	public function create_project_number()
	{
		//select product code
		$this->db->from('projects');
		$this->db->where("project_number LIKE '".$this->session->userdata('branch_code')."".date('y')."-%'");
		$this->db->select('MAX(project_number) AS number');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$number =  $result[0]->number;
			$number++;//go to the next number
			
			if($number == 1){
				$number = "".$this->session->userdata('branch_code')."".date('y')."-001";
			}
		}
		else{//start generating receipt numbers
			$number = "".$this->session->userdata('branch_code')."".date('y')."-001";
		}
		
		return $number;
	}
	
	/*
	*	Create the total cost of an project
	*	@param int project_id
	*
	*/
	public function calculate_project_cost($project_id)
	{
		//select product code
		$this->db->from('project_item');
		$this->db->where('project_id = '.$project_id);
		$this->db->select('SUM(price * quantity) AS total_cost');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$total_cost =  $result[0]->total_cost;
		}
		
		else
		{
			$total_cost = 0;
		}
		
		return $total_cost;
	}
	/*
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_active_list($table, $where, $order, $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('');
		
		return $query;
	}
	/*
	*	Add a new project
	*
	*/
	public function add_project()
	{
		$project_number = $this->create_project_number();
		
		$data = array(
				'project_number'=>$project_number,
				'created_by'=>$this->input->post('personnel_id'),
				'project_status_id'=>1,
				'project_instructions'=>$this->input->post('project_instructions'),
				'project_start_date'=>$this->input->post('project_start_date'),
				'project_end_date'=>$this->input->post('project_end_date'),
				'project_title'=>$this->input->post('project_title'),
				'project_donor'=>$this->input->post('project_donor'),
				'project_grant_county'=>$this->input->post('project_grant_county'),
				'project_grant_value'=>$this->input->post('project_grant_value'),
				'project_location'=>$this->input->post('project_location'),
				'created'=>date('Y-m-d H:i:s'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		if($this->db->insert('projects', $data))
		{
			$project_id = $this->db->insert_id();

			// insert project planting sites

			foreach ($_POST['watersheds'] as $key) {
				# code...
				$watershed_data = array(
					'project_id'=>$project_id,
					'project_area_id'=>$key,
					'created'=>date("Y-m-d H:i:s"),
				);

				$this->db->insert('project_watershed', $watershed_data);
				
			}



			// insert into the project_level_status

			$insert_data = array(
					'project_id'=>$project_id,
					'project_level_status_status'=>0,
					'created'=>date("Y-m-d H:i:s"),
					'created_by' => $this->session->userdata('personnel_id'),
					'modified_by' =>$this->session->userdata('personnel_id')
				);

			$this->db->insert('project_level_status', $insert_data);

			return $project_id;



		}
		else{
			return FALSE;
		}
	}

	public function add_supplier_to_project($project_id)
	{
		$supplier_id = $this->input->post('supplier_id');

		$this->db->from('supplier_project');
		$this->db->where('project_id = '.$project_id.' AND supplier_id = '.$supplier_id);
		$this->db->select('*');
		$query = $this->db->get();

		if($query->num_rows() == 0)
		{

			$data = array(
					'project_id'=>$project_id,
					'supplier_id'=>$supplier_id,
					'created_by'=>$this->session->userdata('personnel_id'),
					'created'=>date('Y-m-d H:i:s'),
					'modified_by'=>$this->session->userdata('personnel_id')
				);
				
			if($this->db->insert('supplier_project', $data))
			{
				return $this->db->insert_id();
			}
			else{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update an project
	*	@param int $project_id
	*
	*/
	public function update_project($project_id)
	{
		
		$data = array(
				'project_status_id'=>1,
				'project_instructions'=>$this->input->post('project_instructions'),
				'project_start_date'=>$this->input->post('project_start_date'),
				'project_end_date'=>$this->input->post('project_end_date'),
				'project_title'=>$this->input->post('project_title'),
				'project_donor'=>$this->input->post('project_donor'),
				'project_grant_county'=>$this->input->post('project_grant_county'),
				'project_grant_value'=>$this->input->post('project_grant_value'),
				'project_location'=>$this->input->post('project_location'),
			);
		
		$this->db->where('project_id', $project_id);
		if($this->db->update('projects', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all projects
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_payment_methods()
	{
		//retrieve all projects
		$this->db->from('payment_method');
		$this->db->select('*');
		$this->db->order_by('payment_method_name');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a project product
	*
	*/
	public function add_project_item($project_id)
	{
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		//Check if item exists
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id.' AND project_id = '.$project_id);
		$query = $this->db->get('project_item');
		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			$qty = $result->quantity;
			
			$quantity += $qty;
			
			$data = array(
					'project_item_quantity'=>$quantity
				);
				
			$this->db->where('product_id = '.$product_id.' AND project_id = '.$project_id);
			if($this->db->update('project_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			$data = array(
					'project_id'=>$project_id,
					'product_id'=>$product_id,
					'project_item_quantity'=>$quantity
				);
				
			if($this->db->insert('project_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}
	public function update_project_item($project_id,$project_item_id)
	{
		$data = array(
					'project_item_quantity'=>$this->input->post('quantity')
				);
				
		$this->db->where('project_item_id = '.$project_item_id);
		if($this->db->update('project_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function update_project_item_price($project_id,$project_item_id)
	{
		$data = array(
					'supplier_unit_price'=>$this->input->post('unit_price')
				);
				
		$this->db->where('project_item_id = '.$project_item_id);
		if($this->db->update('project_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an project item
	*
	*/
	public function update_cart($project_item_id, $quantity)
	{
		$data = array(
					'quantity'=>$quantity
				);
				
		$this->db->where('project_item_id = '.$project_item_id);
		if($this->db->update('project_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing project item
	*	@param int $product_id
	*
	*/
	public function delete_project_item($project_item_id)
	{
		if($this->db->delete('project_item', array('project_item_id' => $project_item_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_next_approval_status_name($status)
	{
		$this->db->select('inventory_level_status_name');
		$this->db->where('inventory_level_status_id = '.$status);
		$query = $this->db->get('inventory_level_status');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $key) {
				# code...
				$inventory_level_status_name = $key->inventory_level_status_name;
			}
		}
		else
		{
			$inventory_level_status_name = 0;
		}
		return $inventory_level_status_name;	
	}
	public function check_assigned_next_approval($next_level_status)
	{
		$this->db->select('*');
		$this->db->where('approval_status_id = '.($next_level_status+1).' AND personnel_id = '.$this->session->userdata('personnel_id').'');
		$query = $this->db->get('personnel_approval');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}	
	}
	public function check_if_can_access($project_approval_status,$project_id)
	{
		if($project_approval_status == 0)
		{
			$addition =' AND personnel_approval.approval_status_id = 1';
		}
		else
		{
			$addition = 'AND project_level_status.project_level_status_status = 1 AND personnel_approval.approval_status_id <= '.($project_approval_status+1);
		}
		$this->db->select('*');
		$this->db->where('project_level_status.project_id = '.$project_id.' '.$addition.'  AND personnel_approval.personnel_id = '.$this->session->userdata('personnel_id').'');
		$this->db->order_by('project_level_status.project_level_status_id','DESC');
		$this->db->limit(1);
		$query = $this->db->get('personnel_approval,project_level_status');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}
	public function get_rfq_authorising_personnel($project_id)
	{
		$this->db->select('*');
		$this->db->where('project_level_status.created_by = personnel.personnel_id AND job_title.job_title_id = personnel_job.job_title_id AND personnel.personnel_id = personnel_job.personnel_id AND project_level_status.project_level_status_status = 1 AND title.title_id = personnel.title_id AND project_level_status.personnel_project_approval_status = 2');
		$query = $this->db->get('personnel,project_level_status,title,personnel_job,job_title');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $key) {
				# code...
				$other_names = $key->personnel_onames;
				$first_name = $key->personnel_fname;
				$title_name = $key->title_name;
				$job_title_name = $key->job_title_name;

				$item = '<br>'.$title_name.' '.$first_name.' '.$other_names.' <br> '.$job_title_name.' <br> ';
			}

		}
		else
		{
			$item = '';
		}
		return $item;
	}
	public function update_project_status($project_id,$project_status)
	{
		$data = array(
					'project_approval_status'=>$project_status
				);
				
		$this->db->where('project_id = '.$project_id);
		if($this->db->update('projects', $data))
		{
			$this->save_project_approval_status($project_id,$project_status);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function save_project_approval_status($project_id,$project_status)
	{
		$insert_data = array(
					'project_id'=>$project_id,
					'personnel_project_approval_status'=>$project_status,
					'project_level_status_status'=>1,
					'created'=>date("Y-m-d H:i:s"),
					'created_by' => $this->session->userdata('personnel_id'),
					'modified_by' =>$this->session->userdata('personnel_id')
				);
		if($this->db->insert('project_level_status', $insert_data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}


	}
	public function get_lpo_authorising_personnel($project_id)
	{
		$this->db->select('*');
		$this->db->where('project_level_status.created_by = personnel.personnel_id AND job_title.job_title_id = personnel_job.job_title_id AND personnel.personnel_id = personnel_job.personnel_id AND project_level_status.project_level_status_status = 1 AND title.title_id = personnel.title_id AND project_level_status.personnel_project_approval_status = 6');
		$query = $this->db->get('personnel,project_level_status,title,personnel_job,job_title');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $key) {
				# code...
				$other_names = $key->personnel_onames;
				$first_name = $key->personnel_fname;
				$title_name = $key->title_name;
				$job_title_name = $key->job_title_name;

				$item = '<br>'.$title_name.' '.$first_name.' '.$other_names.' <br> '.$job_title_name.' <br> ';
			}

		}
		else
		{
			$item = '';
		}
		return $item;
	}
	public function add_project_upload($file_name,$project_id)
	{
		$document_name = $this->input->post('attachement_name');
		$arrayName = array(
							'document_name'=>$document_name,
							'file_name' => $file_name,
							'project_id' =>$project_id,
							'created_by' => $this->session->userdata('personnel_id'),
							'created' => date('Y-m-d'),

							);
		if($this->db->insert('project_documents',$arrayName))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}


	}
	public function get_project_uploads($project_id)
	{
		$this->db->where('project_id = '.$project_id.' AND document_status = 1 AND document_delete = 0');
		$query = $this->db->get('project_documents');

		return $query;
	}
	//import template
	function import_projects_template()
	{
		$this->load->library('Excel');
		
		$title = 'Projects Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Project Name';
		$report[$row_count][1] = 'Location';
		$report[$row_count][2] = 'Donor';
		$report[$row_count][3] = 'Grant Value';
		$report[$row_count][4] = 'Grant County ID';
		$report[$row_count][5] = 'Project Start Date (yyyy-mm-dd)';
		$report[$row_count][6] = 'Project End Date (yyyy-mm-dd)';
		$report[$row_count][7] = 'Goal';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	//import projects
	public function import_csv_projects($upload_path)
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
			$response2 = $this->sort_projects_data($array);
		
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
	public function sort_projects_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 8))
		{
			$items['created_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Project Name</th>
						  <th>Project Location</th>
						  <th>Project Donor</th>
						  <th>Project Start Date</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$project_number = $this->create_project_number();
				$project_name = $items['project_title'] = $array[$r][0];
				$items['project_location'] = $array[$r][1];
				$items['project_donor'] = $array[$r][2];
				$items['project_grant_value'] = $array[$r][3];
				$items['project_grant_county']=$array[$r][4];
				$items['project_start_date']=$array[$r][5];
				$items['project_end_date']=$array[$r][6];
				$items['project_instructions']=$array[$r][7];
				$items['project_status_id'] = 1;
				$items['created'] = date('Y-m-d H-i-s');
				$items['project_number'] = $project_number;
				$comment ='';
				//var_dump($items);die();
		
				//check if the project name already exists
				if($this->check_project_exists($project_name))
				{
					
					$comment .= '<br/>Duplicate project entered, project not added successfully';
					$class = 'danger';
				}
				//insert data to db
				else
				{
						if($this->db->insert('projects', $items))
						{
							$comment .= '<br/>Project successfully added to the database';
							$class = 'success';
						}
						
						else
						{
							$comment .= '<br/>Internal error. Could not add project to the database. Please contact the site administrator';
							$class = 'warning';
						}

				}
				$response .= '
								<tr class="'.$class.'">
									<td>'.$r.'</td>
									<td'.$items['project_title'].'</td>
									<td'.$items['project_location'].'</td>
									<td'.$items['project_donor'].'</td>
									<td'.$items['project_start_date'].'</td>
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
	public function check_project_exists($project_name)
	{
		
		$this->db->where(array ('project_title'=> $project_name));
		
		$query = $this->db->get('projects');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
}