<?php 
	// $v_data['cp_status_query'] = $meeting_status_query;
	//echo $this->load->view('inventory/search/search_orders', '' , TRUE); ?>
<?php
	$error = $this->session->userdata('error_message');
	$success = $this->session->userdata('success_message');
	$search_result ='';
	$search_result2  ='';
	if(!empty($error))
	{
		$search_result2 = '<div class="alert alert-danger">'.$error.'</div>';
		$this->session->unset_userdata('error_message');
	}
	
	if(!empty($success))
	{
		$search_result2 ='<div class="alert alert-success">'.$success.'</div>';
		$this->session->unset_userdata('success_message');
	}
			
	$search = $this->session->userdata('meetings_search');
	
	if(!empty($search))
	{
		$search_result = '<a href="'.site_url().'inventory/close-orders-search" class="btn btn-danger">Close Search</a>';
	}


	$result = '<div class="padd">';	
	$result .= ''.$search_result2.'';
	$result .= '
			';
	
	//if users exist display them
	if ($query->num_rows() > 0)
	{
		$count = $page;
		
		$result .= 
		'
		<div class="row">
			<div class="col-md-12">
				<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
				  <thead>
					<tr>
					  <th >#</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Grant Name</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Grant County</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Activity Title</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Date Created</th>
					  <th class="table-sortable:default table-sortable" title="Click to sort">Status</th>
					  <th colspan="3">Actions</th>
					</tr>
				  </thead>
				  <tbody>
				';
		
					//get all administrators
					// $personnel_query = $this->personnel_model->get_all_personnel();
					// var_dump($query->num_rows()); die();
					foreach ($query->result() as $row)
					{
						$cp_id = $row->cp_id;
						$cp_activitytitle = $row->cp_activitytitle;
						$grant_county = $row->project_grant_county;
						$county_name = $row->county_name;
						$grant_name = $row->project_donor;
						$cp_status = $row->cp_status;
						$cp_project_id = $row->cp_project_id;

						$created_by = '-';
						
						//create deactivated status display
						if($cp_status == 0)
						{
							$status = '<span class="label label-default">Deactivated</span>';
							$button = '<a class="btn btn-info btn-sm" href="'.site_url().'tree-planting/activate-training/'.$cp_project_id.'/'.$cp_id.'" onclick="return confirm(\'Do you want to activate '.$cp_activitytitle.'?\');" title="Activate '.$cp_activitytitle.'"><i class="fa fa-thumbs-up"></i></a>';
						}
						//create activated status display
						else if($cp_status == 1)
						{
							$status = '<span class="label label-success">Active</span>';
							$button = '<a class="btn btn-default btn-sm" href="'.site_url().'tree-planting/deactivate-training/'.$cp_project_id.'/'.$cp_id.'" onclick="return confirm(\'Do you want to deactivate '.$cp_activitytitle.'?\');" title="Deactivate '.$cp_activitytitle.'"><i class="fa fa-thumbs-down"></i></a>';
						}
						$count++;
						$result .= 
						'
							<tr>
								<td>'.$count.'</td>
								<td>'.$grant_name.'</td>
								<td>'.$county_name.'</td>
								<td>'.$cp_activitytitle.'</td>
								<td>'.date('jS M Y',strtotime($row->cp_payment_date)).'</td>
								<td>'.$status.'</td>
								<td><a href="'.site_url().'activity-participants/'.$cp_project_id.'/'.$cp_id.'" class="btn btn-warning  btn-sm fa fa-users"> Participants</a></td>
								<td>'.$button.'</td>
								
							</tr> 
						';
					}
		
			$result .= 
			'
					  </tbody>
					</table>
				</div>
			</div>
			';
	}
	
	else
	{
		$result .= "There are no activities created";
	}
	$result .= '</div>';
	
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>

<section class="panel panel-featured panel-featured-success">
    <header class="panel-heading">
         <h2 class="panel-title pull-left"><?php echo $title;?></h2>
         <div class="widget-icons pull-right">
         		<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/<?php echo $step_id;?>" class="btn btn-info btn-sm pull-right" >Back to planting sites</a>
            	<a  class="btn btn-sm btn-success pull-right" id="open_new_community_group_member" onclick="get_new_community_group_member();" style=" margin-right: 5px;">Add new activity</a>
				<a  class="btn btn-sm btn-warning pull-right" id="close_new_community_group_member" style="display:none; margin-right: 5px;" onclick="close_new_community_group_member();">Close activity panel</a>
          </div>
          <div class="clearfix"></div>
    </header>
    <div class="panel-body">
    	<div style="display:none;" class="col-md-12" id="new_community_group_member" >
        	<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Add a new activity</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            				echo form_open("planting-site/add-activity/".$project_id."/".$site_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
            						<input type="hidden" name="cp_step" value="<?php echo $step_id?>">
                				<div class="row">
						        	<div class="col-sm-6">
						                <!-- Company Name -->
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Activity Title</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="activity_title" placeholder="Activity Title" value="<?php echo set_value('activity_title');?>">
						                    </div>
						                </div> 

						               
						            </div>
						            
						        	<div class="col-sm-6">
						        		<div class="form-group">
						                    <label class="col-lg-4 control-label">Payment Date</label>
						                    <div class="col-lg-8">
						                        <div class="input-group">
								                    <span class="input-group-addon">
								                        <i class="fa fa-calendar"></i>
								                    </span>
								                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="payment_date" placeholder="Payment Date" value="<?php echo set_value('payment_date');?>">
								                </div>
						                    </div>
						                </div>
						                
						                <!-- Activate checkbox -->
						               
						            </div>
						        </div>
						        <br/>
						        <div class="row">
						        	<div class="col-sm-12">
						        		 <div class="form-group">
						                    <label class="col-lg-4 control-label">Reason for Payment</label>
						                    <div class="col-lg-6">
						                        <textarea  class="form-control" name="payment_reason" placeholder="Description" rows="5" ></textarea>
						                    </div>
						                </div>
						        	</div>
						        </div>
						        <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-primary" type="submit">
						                Add a activity
						            </button>
						        </div>
						        <br />
                				<?php echo form_close();?>
                				<!-- end of form -->
                			</div>

            				
            			</div>
            			
            		</div>
				</div>
			</section>
        </div>

		<?php echo $result;?>
    </div>
</section>

<script type="text/javascript">
	$(function() {
	    $("#community_group_member_id").customselect();
	});
	$(document).ready(function(){
		$(function() {
			$("#community_group_member_id").customselect();
		});
	});

	function get_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_new_community_group_member");
		var button2 = document.getElementById("close_new_community_group_member");

		myTarget2.style.display = '';
		button.style.display = 'none';
		button2.style.display = '';
	}
	function close_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_new_community_group_member");
		var button2 = document.getElementById("close_new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		button2.style.display = 'none';
	}


	function assign_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member_allocation");
		var myTarget3 = document.getElementById("new_community_group_member");
		var button = document.getElementById("assign_new_community_group_member");
		var button2 = document.getElementById("close_assign_new_community_group_member");

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		button2.style.display = '';
	}
	function close_assign_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member_allocation");
		var button = document.getElementById("assign_new_community_group_member");
		var myTarget3 = document.getElementById("new_community_group_member");
		var button2 = document.getElementById("close_assign_new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		button2.style.display = 'none';
	}


	// lease details


	function get_community_group_member_leases(community_group_member_id){

		var myTarget2 = document.getElementById("lease_details"+community_group_member_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_lease_details"+community_group_member_id);
		var button2 = document.getElementById("close_lease_details"+community_group_member_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = '';
	}
	function close_community_group_member_leases(community_group_member_id){

		var myTarget2 = document.getElementById("lease_details"+community_group_member_id);
		var button = document.getElementById("open_lease_details"+community_group_member_id);
		var button2 = document.getElementById("close_lease_details"+community_group_member_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = 'none';
	}

	// community_group_member_info
	function get_community_group_member_info(community_group_member_id){

		var myTarget2 = document.getElementById("community_group_member_info"+community_group_member_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_community_group_member_info"+community_group_member_id);
		var button2 = document.getElementById("close_community_group_member_info"+community_group_member_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = '';
	}
	function close_community_group_member_info(community_group_member_id){

		var myTarget2 = document.getElementById("community_group_member_info"+community_group_member_id);
		var button = document.getElementById("open_community_group_member_info"+community_group_member_id);
		var button2 = document.getElementById("close_community_group_member_info"+community_group_member_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = 'none';
	}

  </script>
  