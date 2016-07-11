<?php

class Seedling_production_model extends CI_Model 
{	
	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	//community group details
	public function get_community_info($nursery_id)
	{
		$this->db->from('community_group');
		$this->db->where('community_group_id ='.$nursery_id);
		$this->db->select('community_group.*');
		$query = $this->db->get();
		
		return $query;
	}
	
	//branch details
	
	public function get_branch_details()
	{
		$this->db->from('branch');
		$this->db->select('branch.*');
		$query = $this->db->get();
		
		return $query;
	}
	
	//tally details
	public function get_monthly_tally($seedling_product_id)
	{
		$this->db->from('seedling_production');
		$this->db->where('seedling_production_id = '.$seedling_product_id);
		$this->db->select('seedling_production.*');
		$query = $this->db->get();
		
		return $query;
	}
	
	//month
	public function get_selected_month($seedling_product_id)
	{
		$this->db->from('nursery_tally');
		$this->db->where('seedling_production_id = '.$seedling_product_id);
		$this->db->select('nursery_tally.*');
		$query = $this->db->get();
		
		return $query;
	}
	//nursery details
	public function get_nursery_details($nursery_id)
	{
		$this->db->from('nurseries');
		$this->db->where('nursery_id = '.$nursery_id);
		$this->db->select('nurseries.*');
		$query = $this->db->get();
		
		return $query;
	}
	/*
	*	Retrieve all community_group
	*
	*/
	public function all_community_groups()
	{
		$this->db->where('seedling_production_status = 1');
		$this->db->order_by('seedling_production.created','DESC');
		$query = $this->db->get('seedling_production');
		
		return $query;
	}
	
	/*
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_seedling_records($table, $where, $per_page, $page, $order = 'community_group.community_group_name', $order_method = 'ASC')
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
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_counter_amount($table, $where, $select)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get('');
		$quantity = 0;
		foreach ($query->result() as $key) {
			# code...
			$quantity = $key->quantity;

			if($quantity == NULL)
			{
				$quantity = 0;
			}
		}
		return $quantity;
	}

	public function get_counter_amount_ctn($table, $where, $select)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select($select);
		$this->db->where($where);
		$query = $this->db->get('');
		$quantity = 0;
		foreach ($query->result() as $key) {
			# code...
			$quantity = $key->quantity;

			if($quantity == NULL)
			{
				$quantity = 0;
			}
		}
		return $quantity;
	}

	public function get_nursery_involved($nursery_id)
	{
		$where = 'community_group_id  = '.$nursery_id;
		$this->db->where($where);
		$query = $this->db->get('community_group');

		return $query;
	}
	public function add_seedling_production($project_area_id)
	{
		$arrayName = array(
			'project_area_id' => $project_area_id,
			'nursery_id' => $this->input->post('community_group_id'),
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

	}


	/*
	*	Retrieve all community_group
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_monthly_records($table, $where, $per_page, $page, $order = 'month', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$this->db->group_by('year,month');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_months_seedling_tally($month_id,$year,$production_id)
	{
		$where = 'nursery_tally_status = 1 AND month = "'.$month_id.'" AND year = '.$year.' AND seedling_production_id = '.$production_id;
		$this->db->where($where);
		$query = $this->db->get('nursery_tally');

		return $query;
	}

	public function add_seedling_production_tally($seedling_production_id)
	{
		$seedling_type_id = $this->input->post('seedling_type_id');
		$seedling_status_id = $this->input->post('seedling_status_id');
		$month_id = $this->input->post('month_id');
		$year = $this->input->post('year');
		$quantity = $this->input->post('quantity');
		$arrayName = array(
							'seedling_type_id' => $seedling_type_id, 
							'seedling_status_id' => $seedling_status_id,
							'seedling_production_id' => $seedling_production_id,
							'month' => $month_id,
							'year' => $year,
							'quantity' =>$quantity,
							'created' => date('Y-m-d'),
							'created_by' => $this->session->userdata('personnel_id')
						  );
		if($this->db->insert('nursery_tally',$arrayName))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	//import template
	function import_seedling_production_template()
	{
		$this->load->library('Excel');
		
		$title = 'Seedling Production Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Month';
		$report[$row_count][1] = 'Year';
		$report[$row_count][2] = 'Seedling Status (i.e. In potting bags 1, Not ready for planting 2, Ready for planting 3)';
		$report[$row_count][3] = 'Seedling Type (i.e. Exotic 1, Indigenous 2, Fruit 3)';
		$report[$row_count][4] = 'Quantity'; 
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}

	//import projects
	public function import_csv_seedling_production($upload_path,$seedling_production_id)
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
			$response2 = $this->sort_seedling_production($array,$seedling_production_id);
		
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
	public function sort_seedling_production($array,$seedling_production_id)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		// var_dump($total_columns); die();
		if(($total_rows > 0) && ($total_columns == 5))
		{
			$items['created_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Month</th>
						  <th>Year</th>
						</tr>
					  </thead>
					  <tbody>';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{


				$items['month'] = '0'.$array[$r][0]; 
				$items['year'] = $array[$r][1];
				$items['seedling_status_id'] = $array[$r][2]; 
				$items['seedling_type_id'] = $array[$r][3];
				$items['quantity'] = $array[$r][4];
				$items['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['seedling_production_id'] =  $seedling_production_id;

				$comment ='';


				if($this->db->insert('nursery_tally', $items))
				{
					$comment .= '<br/>Seedling Tally sheet  successfully added to the database';
					$class = 'success';
				}
				else{
					$comment .= '<br/>Internal error. Could not add seedling tally to the database. Please contact the site administrator';
					$class = 'warning';
				}
				

				
				$response .= '
								<tr class="'.$class.'">
									<td>'.$r.'</td>
									<td'.$items['month'].'</td>
									<td'.$items['year'].'</td>
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