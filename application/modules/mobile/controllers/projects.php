<?php   

class Projects extends MX_Controller
{ 
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('mobile/projects_model');
	}
    
	
    	public function register_meeting($project_area_id)
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json);
    		
    		$response = $this->projects_model->add_meeting($project_area_id,$data_array);
    		
		echo json_encode($response);
    	}
    	public function register_attendee($meeting_id)
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json);
    		
    		$response = $this->projects_model->add_meeting_attendee($meeting_id,$data_array);
    		
		echo json_encode($response);
    		
    	}
    	
    	public function get_all_meetings($project_area_id)
    	{
    		
    		$response = $this->projects_model->get_all_meetings($project_area_id);
    		
		echo json_encode($response);
    	}
    	public function addprojectarea()
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json);
    		$response = $this->projects_model->register_project_area($data_array);
    		
		echo json_encode($response);
    	}
    	public function register_tng($project_area_id)
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json);
    		
    		$response = $this->projects_model->add_tng($project_area_id,$data_array);
    		
		echo json_encode($response);
    	}
    	
    	public function get_all_project_areas()
    	{
    		
    		$response = $this->projects_model->get_all_project_areas();
    		
		echo json_encode($response);
    	}
    	
    	public function get_meeting_members($meeting_id)
    	{
    		$response = $this->projects_model->get_all_meeting_attendees($meeting_id);
    		
		echo json_encode($response);
    	}  
    	public function get_community_groups($project_area_id)
    	{
    		$response = $this->projects_model->get_all_community_groups($project_area_id);
    		
		echo json_encode($response);
    	}
    	public function get_community_group_members($community_group_id)
    	{
    		$response = $this->projects_model->get_all_community_group_members($community_group_id);
    		
		echo json_encode($response);
    	}    	
    	public function get_all_planting_sites($project_area_id)
    	{
    		
    		$response = $this->projects_model->get_all_planting_sites($project_area_id);
    		
		echo json_encode($response);
    	}
    	
    	public function add_seedling_production($seedling_production_id)
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json,true);
    		$response = $this->projects_model->add_seedling_production($seedling_production_id,$data_array);
    		
		echo json_encode($response);
    	}
    	public function get_all_nursery_tally($seedling_production_id)
    	{
    		
    		$response = $this->projects_model->get_tally_sheets($seedling_production_id);
    		
		echo json_encode($response);
    	}
    	public function add_group_members($community_group_id)
    	{
    		$json = file_get_contents('php://input');
    		// change values to array
    		$data_array = json_decode($json);
    		
    		$response = $this->projects_model->add_group_members($community_group_id,$data_array);
    		
		echo json_encode($response);
    		
    	}
    	
}
?>