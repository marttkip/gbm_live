<?php

class Project_areas_model extends CI_Model 
{	
	/*
	*	Retrieve all project_areas
	*
	*/
	public function all_project_areas()
	{
		$this->db->where(array('project_area_status' => 1, 'branch_code' => $this->session->userdata('branch_code')));
		$this->db->order_by('project_area_name');
		$query = $this->db->get('project_areas');
		
		return $query;
	}

	/*
	*	Retrieve all project_areas
	*
	*/
	public function all_project_areas_parent()
	{
		$this->db->where(array('project_area_status' => 1, 'parent_project_area_id' => 0, 'branch_code' => $this->session->userdata('branch_code')));
		$this->db->order_by('project_area_name');
		$query = $this->db->get('project_areas');
		
		return $query;
	}
	/*
	*	Retrieve all project_areas
	*
	*/
	public function all_project_areas_children($project_area_id)
	{
		$this->db->where(array('project_area_status' => 1, 'parent_project_area_id '=>$project_area_id , 'branch_code' => $this->session->userdata('branch_code')));
		$this->db->order_by('project_area_name');
		$query = $this->db->get('project_areas');
		
		return $query;
	}
	
	/*
	*	Retrieve all project_areas
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_project_areas($table, $where, $per_page, $page, $order = 'project_area_id', $order_method = 'DESC')
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
	*	Add a new project_area
	*	@param string $image_name
	*
	*/
	public function add_project_area()
	{
		$start_location = explode(',', $this->input->post('location')); 

		$project_area_latitude = $start_location[0];
		$project_area_longitude = $start_location[1];

		$data = array(
				'project_area_name'=>$this->input->post('project_area_name'),
				'project_area_status'=>$this->input->post('project_area_status'),
				'project_area_longitude'=>$project_area_longitude,
				'project_area_latitude'=>$project_area_latitude,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('personnel_id'),
				'branch_code'=>$this->session->userdata('branch_code'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		if($this->db->insert('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing project_area
	*	@param string $image_name
	*	@param int $project_area_id
	*
	*/
	public function update_project_area($project_area_id)
	{
		$data = array(
				'project_area_name'=>$this->input->post('project_area_name'),
				'project_area_status'=>$this->input->post('project_area_status'),
				'project_area_longitude'=>$this->input->post('project_area_longitude'),
				'project_area_latitude'=>$this->input->post('project_area_latitude'),
				'branch_code'=>$this->session->userdata('branch_code'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		$this->db->where('project_area_id', $project_area_id);
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single project_area's details
	*	@param int $project_area_id
	*
	*/
	public function get_project_area($project_area_id)
	{
		//retrieve all users
		$this->db->from('project_areas');
		$this->db->select('*');
		$this->db->where('project_area_id = '.$project_area_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing project_area
	*	@param int $project_area_id
	*
	*/
	public function delete_project_area($project_area_id)
	{
		if($this->db->delete('project_areas', array('project_area_id' => $project_area_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated project_area
	*	@param int $project_area_id
	*
	*/
	public function activate_project_area($project_area_id)
	{
		$data = array(
				'project_area_status' => 1
			);
		$this->db->where('project_area_id', $project_area_id);
		
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated project_area
	*	@param int $project_area_id
	*
	*/
	public function deactivate_project_area($project_area_id)
	{
		$data = array(
				'project_area_status' => 0
			);
		$this->db->where('project_area_id', $project_area_id);
		
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}



	/*
	*	Retrieve all project_areas
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_project_area_locations($table, $where, $per_page, $page, $order = 'project_area_name', $order_method = 'ASC')
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
	*	Add a new project_area
	*	@param string $image_name
	*
	*/
	public function add_area_location($project_id)
	{
		$data = array(
				'project_area_name'=>$this->input->post('project_area_name'),
				'project_area_status'=>$this->input->post('project_area_status'),
				'project_area_longitude'=>$this->input->post('project_area_longitude'),
				'project_area_latitude'=>$this->input->post('project_area_latitude'),
				'parent_project_area_id'=>$project_id,
				'project_id'=>$project_id,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('personnel_id'),
				'branch_code'=>$this->session->userdata('branch_code'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		if($this->db->insert('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing project_area
	*	@param string $image_name
	*	@param int $project_area_id
	*
	*/
	public function update_project_area_location($project_area_id,$parent_project_area_id)
	{
		$data = array(
				'project_area_name'=>$this->input->post('project_area_name'),
				'project_area_status'=>$this->input->post('project_area_status'),
				'project_area_longitude'=>$this->input->post('project_area_longitude'),
				'project_area_latitude'=>$this->input->post('project_area_latitude'),
				'parent_project_area_id'=>$parent_project_area_id,
				'branch_code'=>$this->session->userdata('branch_code'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
		$this->db->where('project_area_id', $project_area_id);
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/*
	*	Activate a deactivated project_area
	*	@param int $project_area_id
	*
	*/
	public function activate_area_location($project_area_id)
	{
		$data = array(
				'project_area_status' => 1
			);
		$this->db->where('project_area_id', $project_area_id);
		
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated project_area
	*	@param int $project_area_id
	*
	*/
	public function deactivate_area_location($project_area_id)
	{
		$data = array(
				'project_area_status' => 0
			);
		$this->db->where('project_area_id', $project_area_id);
		
		if($this->db->update('project_areas', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_project_ctn($project_area_id)
	{
		$ctn_where = 'is_ctn = 1 AND project_area_id ='.$project_area_id;
		$ctn_table = 'community_group';

		$this->db->where($ctn_where);
		$ctn_query = $this->db->get($ctn_table);

		return $ctn_query;
	}

	public function get_project_areas_nurseries($project_area_id)
	{
		$community_where = 'is_ctn = 0 AND project_area_id  = '.$project_area_id;

		$community_table = 'community_group';
		$this->db->where($community_where);
		$ctn_query = $this->db->get($community_table);

		return $ctn_query;	
	}
	function generateRandomString($length) {
	    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	function generateRandomInteger($length)
	{
		$characters = '1234567890';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;

	}
	function get_random_string($valid_chars, $length)
	{
	    // start with an empty random string
	    $random_string = "";

	    // count the number of chars in the valid chars string so we know how many choices we have
	    $num_valid_chars = strlen($valid_chars);

	    // repeat the steps until we've created a string of the right length
	    for ($i = 0; $i < $length; $i++)
	    {
	        // pick a random number from 1 up to the number of valid chars
	        $random_pick = mt_rand(1, $num_valid_chars);

	        // take the random character out of the string of valid chars
	        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
	        $random_char = $valid_chars[$random_pick-1];

	        // add the randomly-chosen char onto the end of our string so far
	        $random_string .= $random_char;
	    }

	    // return our finished random string
	    return $random_string;
	}

	public function add_project_area_upload($file_name,$project_area_id)
	{
		$document_name = $this->input->post('attachement_name');
		$arrayName = array(
							'document_name'=>$document_name,
							'file_name' => $file_name,
							'project_area_id' =>$project_area_id,
							'created_by' => $this->session->userdata('personnel_id'),
							'created' => date('Y-m-d'),

							);
		if($this->db->insert('project_area_documents',$arrayName))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}


	}
	public function get_project_area_uploads($project_area_id)
	{
		$this->db->where('project_area_id = '.$project_area_id.' AND document_status = 1 AND document_delete = 0');
		$query = $this->db->get('project_area_documents');

		return $query;
	}
	//import template
	function import_watershed_template()
	{
		$this->load->library('Excel');
		
		$title = 'Project Areas Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Project Name';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	//import projects
	public function import_csv_projects($upload_path,$project_id)
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
		if(($total_rows > 0) && ($total_columns == 1))
		{
			$items['created_by'] = $this->session->userdata('personnel_id');
			$items['created'] = date('Y-m-d');
			$items['project_id'] = $project_id;
			$items['last_modified'] = date('Y-m-d H-i-s');
			$items['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Watershed Name</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$watershed_name = $items['project_area_name'] = $array[$r][0];
				
				$comment ='';
				//var_dump($items);die();
		
				//check if the project name already exists
				if($this->check_project_area_exists($watershed_name,$project_id))
				{
					
					$comment .= '<br/>Duplicate watershed entered, project not added successfully';
					$class = 'danger';
				}
				//insert data to db
				else
				{
						if($this->db->insert('project_areas', $items))
						{
							$comment .= '<br/>Watershed successfully added to the database';
							$class = 'success';
						}
						
						else
						{
							$comment .= '<br/>Internal error. Could not add watershed to the database. Please contact the site administrator';
							$class = 'warning';
						}

				}
				$response .= '
								<tr class="'.$class.'">
									<td>'.$r.'</td>
									<td'.$items['project_title'].'</td>
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
	public function check_project_area_exists($watershed_name,$project_id)
	{
		
		$this->db->where(array ('project_area_name'=> $watershed_name,
							'project_id' => $project_id));
		
		$query = $this->db->get('project_areas');
		
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
?>