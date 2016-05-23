<?php

class Projects_model extends CI_Model 
{
	
	
	
	public function add_meeting($project_area_id,$data_array)
	{
		
		if($this->db->insert('meeting', $data_array))
		{
			$response['meeting_id']=$this->db->insert_id();
			$response['status']=1;
        		$response['message'] ="Meeting Successfully Created";
		}
		else{
			$response['status']=1;
        		$response['message'] ="Something went wrong please try again";
		}
		return $response;
	}
	
	
	/*
	*	Create meeting number
	*
	*/
	public function create_meeting_number()
	{
		//select product code
		$this->db->from('meeting');
		$this->db->where("meeting_id > 0");
		$this->db->select('MAX(meeting_number) AS number');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$number =  $result[0]->number;
			$number++;//go to the next number
			
			if($number == 1){
				$number = "GBM-M".date('y')."-001";
			}
		}
		else{//start generating receipt numbers
			$number = "GBM-M".date('y')."-001";
		}
		
		return $number;
	}
	
	public function add_meeting_attendee($meeting_id,$array)
	{
		if($this->db->insert('attendees',$array))
		{
			$insert_id = $this->db->insert_id();
			// submit the same to the meeting attendees 

			$array_two = array(
						'attendee_id' => $insert_id,
						'meeting_id' => $meeting_id
					   );

			if($this->db->insert('meeting_attendees',$array_two))
			{
				$response['status']=1;
	        		$response['message'] ="Meeting Successfully Created";
			}
			else{
				$response['status']=1;
	        		$response['message'] ="Something went wrong please try again";
			}
		
		}
		else
		{
			$response['status']=0;
	        	$response['message'] ="Something went wrong please try again";
		}
		return $response;
	}
	
	public function get_all_meetings($project_area_id)
	{
		$this->db->where('project_area_id  ='.$project_area_id);
		$query = $this->db->get('meeting');
		
		if($query->num_rows() > 0)
		{
			$response['meeting_details'] = array();
			foreach ($query->result() as $key) {
				# code...
				$product = array();
				$product['meeting_id'] = $key->meeting_id;
				$product['activity_title'] = $key->activity_title;
				$product['grant_name'] = $key->grant_name;
				$product['grant_county'] = $key->grant_county;
				
				array_push($response['meeting_details'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull Meetings Recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	
	public function get_all_project_areas()
	{
		$this->db->where('project_area_status = 1 AND parent_project_area_id = 0');
		$query = $this->db->get('project_areas');
		
		if($query->num_rows() > 0)
		{
			$response['project_area_details'] = array();
			foreach ($query->result() as $key) {
				# code...
				$product = array();
				$product['project_area_id'] = $key->project_area_id;
				$product['project_area_name'] = $key->project_area_name;
				$product['project_area_latitude'] = $key->project_area_latitude;
				$product['project_area_longitude'] = $key->project_area_longitude;
				
				array_push($response['project_area_details'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull Project Areas Recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	public function register_project_area($data_array)
	{
		
		if($this->db->insert('project_areas',$data_array))
		{
			$response['status']=1;
        		$response['message'] ="Project Area Successfully Created";
		}
		else{
			$response['status']=0;
        		$response['message'] ="Something went wrong please try again";
		}
		return $response;
	}
	public function add_tng($project_area_id,$data_array)
	{
		if($this->db->insert('community_group', $data_array))
		{
			$response['community_group_id']=$this->db->insert_id();
			$response['status']=1;
        		$response['message'] ="Community group created successfully";
		}
		else{
			$response['status']=0;
        		$response['message'] ="Something went wrong please try again";
		}
		return $response;
	}
	
	/*
	*	Retrieve all meeting
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_meeting_attendees($meeting_id)
	{
		$this->db->where('attendees.attendee_delete = 0 AND meeting_attendees.meeting_id ='.$meeting_id.' AND attendees.attendee_id = meeting_attendees.attendee_id');
		$query = $this->db->get('attendees,meeting_attendees');
		
		if($query->num_rows() > 0)
		{
			$response['meeting_attendee_details'] = array();
			foreach ($query->result() as $key) {
				# code...
				$product = array();
				$product['attendee_id'] = $key->attendee_id;
				$product['attendee_name'] = $key->attendee_name;
				$product['attendee_national_id'] = $key->attendee_national_id;
				$product['attendee_number'] = $key->attendee_number;
				
				array_push($response['meeting_attendee_details'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull meeting attendees recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	public function get_all_community_groups($project_area_id)
	{
	        $this->db->where('is_ctn = 0 AND project_area_id = '.$project_area_id);
		$query = $this->db->get('community_group');
		
		if($query->num_rows() > 0)
		{
			$response['community_groups'] = array();
			foreach ($query->result() as $row) {
				# code...
				$product = array();
				$product['community_group_id'] = $row->community_group_id;
				$product['community_group_name'] = $row->community_group_name;
				$product['community_group_contact_person_name'] = $row->community_group_contact_person_name;
				$product['community_group_contact_person_phone1'] = $row->community_group_contact_person_phone1;
				$product['community_group_contact_person_phone2'] = $row->community_group_contact_person_phone2;
				$product['community_group_contact_person_email1'] = $row->community_group_contact_person_email1;
				$product['community_group_contact_person_email2'] = $row->community_group_contact_person_email2;
				$product['community_group_description'] = $row->community_group_description;
				$product['community_group_status'] = $row->community_group_status;
				
				
				array_push($response['community_groups'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull community group recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	
	public function get_all_community_group_members($community_group_id)
	{
	
	        $this->db->where('community_group_id = '.$community_group_id);
		$query = $this->db->get('community_group_member');
		
		if($query->num_rows() > 0)
		{
			$response['community_group_members'] = array();
			foreach ($query->result() as $row) {
				# code...
				$product = array();
				$product['community_group_member_id'] = $row->community_group_member_id;
				$product['community_group_member_name'] = $row->community_group_member_name;
				$product['community_group_member_national_id'] = $row->community_group_member_national_id;
				$product['community_group_member_phone_number'] = $row->community_group_member_phone_number;
				$product['member_type_id'] = $row->member_type_id;
				
				
				array_push($response['community_group_members'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull community group member recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull groups Not Recieved";
		}
		return $response;
	}
	
	
	public function get_all_planting_sites($project_area_id)
	{
		$this->db->where('project_ares_status = 1 and parent_project_area_id  ='.$project_area_id);
		$query = $this->db->get('project_areas');
		
		if($query->num_rows() > 0)
		{
			$response['project_area_details'] = array();
			foreach ($query->result() as $key) {
				# code...
				$product = array();
				$product['project_area_id'] = $key->project_area_id;
				$product['project_area_name'] = $key->project_area_name;
				$product['project_area_latitude'] = $key->project_area_latitude;
				$product['project_area_longitude'] = $key->project_area_longitude;
				
				array_push($response['project_area_details'], $product);
			}
			$response['status']=1;
        	       $response['message'] ="Successfull Project Areas Recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	
	public function add_seedling_production($seedling_production_id,$data_array)
	{
		
		
		$data = array();
		 // create multiple arrays to accomodate all these funcitons
		 if($data_array['rp'])
		 {
		 
		    if($data_array['rp']['indegenous'])
		    {
		        $data['seedling_type_id'] = 1;
		    	$data['quantity'] = $data_array['rp']['indegenous'];
		    	$data['seedling_status_id'] = 1;
			$data['year'] = $data_array['year'];
			$data['month'] = $data_array['month'];
			$data['created_by'] = $data_array['created_by'];
		    	$check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['rp']['fruit'])
		    {
		    	$data['seedling_type_id'] = 2;
		    	$data['quantity'] = $data_array['rp']['fruit'];
		    	$data['seedling_status_id'] = 1;
			$data['year'] = $data_array['year'];
			$data['month'] = $data_array['month'];
			$data['created_by'] = $data_array['created_by'];
		    	
		    	$check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['rp']['exotic'])
		    {
		       $data['seedling_type_id'] =3;
		       $data['quantity'] = $data_array['rp']['exotic'];
		       $data['seedling_status_id'] = 1;
		       $data['year'] = $data_array['year'];
		       $data['month'] = $data_array['month'];
		       $data['created_by'] = $data_array['created_by'];
		    	
		    	$check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    
		 }
		 if($data_array['nrp'])
		 {
		    if($data_array['nrp']['indegenous'])
		    {
		        $data['seedling_type_id'] = 1;
		    	$data['quantity'] = $data_array['nrp']['indegenous'];
		    	$data['seedling_status_id'] = 2;
		    
		    $data['year'] = $data_array['year'];
		    $data['month'] = $data_array['month'];
		    $data['created_by'] = $data_array['created_by'];
		    $check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['nrp']['fruit'])
		    {
		    	$data['seedling_type_id'] = 2;
		    	$data['quantity'] = $data_array['nrp']['fruit'];
		    	$data['seedling_status_id'] = 2;
		    
		    $data['year'] = $data_array['year'];
		    $data['month'] = $data_array['month'];
		    $data['created_by'] = $data_array['created_by'];
		    $check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['nrp']['exotic'])
		    {
		       $data_array['seedling_type_id'] =3;
		       $data['quantity'] = $data_array['nrp']['exotic'];
		       $data['seedling_status_id'] = 2;
		    
			$data['year'] = $data_array['year'];
			$data['month'] = $data_array['month'];
			$data['created_by'] = $data_array['created_by'];
			$check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    
		    
		    
		 }
		  if($data_array['ip'])
		 {
		    if($data_array['ip']['indegenous'])
		    {
		        $data['seedling_type_id'] = 1;
		    	$data['quantity'] = $data_array['ip']['indegenous'];
		    	$data['seedling_status_id'] = 3;
		    
		    $data['year'] = $data_array['year'];
		    $data['month'] = $data_array['month'];
		    $data['created_by'] = $data_array['created_by'];
		    $check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['ip']['fruit'])
		    {
		    	$data['seedling_type_id'] = 2;
		    	$data['quantity'] = $data_array['ip']['fruit'];
		    	$data['seedling_status_id'] = 3;
		    
		    $data['year'] = $data_array['year'];
		    $data['month'] = $data_array['month'];
		    $data['created_by'] = $data_array['created_by'];
		    $check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    if($data_array['ip']['exotic'])
		    {
		       $data['seedling_type_id'] =3;
		       $data['quantity'] .= $data_array['ip']['exotic'];
		       $data['seedling_status_id'] = 3;
		    
		    $data['year'] = $data_array['year'];
		    $data['month'] = $data_array['month'];
		    $data['created_by'] = $data_array['created_by'];
		    $check = $this->check_if_month_exists($data['seedling_status_id'],$data['year'],$data['month'],$seedling_production_id,$data['seedling_type_id']);
		    	if($check > 0)
		    	{
		    	   // update
		    	   if($this->update_nursery_tally($data,$check))
		    	   {
		    	      $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    	else
		    	{
		    	   // insert
		    	   if($this->insert_nursery_tally($data))
		    	   {
		    	     $response['status'] = 1;
		    	      $response['message'] = 'sucess';
		    	   }
		    	   else
		    	   {
		    	   	$response['status'] = 0;
		    	        $response['message'] = 'sucess';
		    	   }
		    	}
		    }
		    
		  
		    
		 }
		return $response;
	}
	
	public function check_if_month_exists($seedling_status_id,$year,$month,$seedling_production_id,$seedling_type_id)
	{
		$this->db->where('seedling_production_id = '.$seedling_production_id.' AND year = "'.$year.'" AND month = "'.$month.'" AND seedling_status_id = '.$seedling_status_id.' AND seedling_type_id = '.$seedling_type_id);
		$query = $this->db->get('nursery_tally');
		if($query->num_rows() > 0)
		{
		   foreach($query->result() as $key)
		   {
		     return $key->nursery_tally_id;
		   }
		}
		else
		{
		  return 0;
		}
	
	}
	
	public function update_nursery_tally($data,$check)
	{
	       $this->db->where('nursery_tally_id = '.$check);
	       	if($this->db->update('nursery_tally',$data))
		{
		  return TRUE;
		}
		else
		{
		  return FALSE;
		}
	
	}
	public function insert_nursery_tally($data)
	{
	
		if($this->db->insert('nursery_tally',$data))
		{
		  return TRUE;
		}
		else
		{
		  return FALSE;
		}	    
	}
	
	public function get_tally_sheets($seedling_production_id)
	{
		$this->db->where('seedling_production_id = '.$seedling_production_id);
		$this->db->group_by('year,month');
		$query = $this->db->get('nursery_tally');
		
		if($query->num_rows() > 0)
		{
			$response['tally_details'] = array();
			foreach ($query->result() as $row) {
				# code...
				$product = array();
				$nursery_tally_id = $row->nursery_tally_id;
				$monthNum = $row->month;
				$year = $row->year;
				$nursery_tally_status = $row->nursery_tally_status;
				$production_id = $row->seedling_production_id;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$last_modified = date('jS M Y H:i a',strtotime($row->last_modified));
				$created = date('jS M Y H:i a',strtotime($row->created));
			
				$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));


				// select all the values in the respective months
						
				$this->load->model('projects/seedling_production_model');
				$seedlings_rs = $this->seedling_production_model->get_months_seedling_tally($monthNum,$year,$production_id);
				
				if($seedlings_rs->num_rows() > 0)
				{	
					$ready = 0;
				$not_ready = 0;
				$bags = 0;
					foreach ($seedlings_rs->result() as $key_value) {
						# code...
						$other_id = $key_value->nursery_tally_id;
						$checked_id = $key_value->seedling_status_id;
						if($checked_id == 1)
						{
							$ready = $key_value->quantity;
						}
						else if($checked_id == 2)
						{
							$not_ready = $key_value->quantity;
						}
	
						else
						{
							$bags = $key_value->quantity;
						}
					}
					$product['month_name'] = $monthName;
				$product['year'] = $year;
				$product['rp'] = $ready;
				$product['not_ready'] = $ready;
				$product['bags'] = $bags;
				array_push($response['tally_details'], $product);
				}
				
			}
			$response['status']=1;
        	       $response['message'] ="Successfull Project Areas Recieved";
		}
		else
		{
			$response['status']=0;
        	        $response['message'] ="Not Successfull Meetings Not Recieved";
		}
		return $response;
	}
	public function add_group_members($community_group_id,$array)
	{
		if($this->db->insert('community_group_member',$array))
		{
			$insert_id = $this->db->insert_id();
			// submit the same to the meeting attendees 
			$response['status']=1;
	        	$response['message'] ="Group members successfully Created";
		
		}
		else
		{
			$response['status']=0;
	        	$response['message'] ="Something went wrong please try again";
		}
		return $response;
	}
}
?>