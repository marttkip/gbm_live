<?php echo $this->load->view('projects/projects/project_header','',true);?>
<?php 
$row = $meeting_details->result();

$meeting_id = $row[0]->meeting_id;
$meeting_type_id = $row[0]->meeting_type_id;

if($meeting_type_id == 1)
{
	$activity_title = 'CEE';
}
else if($meeting_type_id == 2)
{
	$activity_title = 'Stakeholders';
}
else
{
	$activity_title = $row[0]->activity_title;
}


 ?>

<?php	

		$result = '';
		if($meeting_type_id == 1)
		{
			$items = '
					  <th>Group Name</th>
					 ';
		}
		else if($meeting_type_id == 2) 
		{
			$items = '
						<th>Attendee Email</th>
						<th>Organization Name</th>
					 ';
		}
		else
		{
			$items = '
						<th>Group Name</th>
						<th>Attendee Email</th>
						<th>Organization Name</th>
					 ';
		}


		

		
		//if community_group_members exist display them
		if ($meeting_attendees->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th><a >Name</a></th>
						<th><a >National Id</a></th>
						<th><a >Phone Number</a></th>
						<th><a >Profile Status</a></th>
						'.$items.'
						<th colspan="5">Actions</th>
					</tr>
				</thead>
				  <tbody>
			';
			foreach ($meeting_attendees->result() as $row)
			{
				$attendee_id = $row->attendee_id;
				$attendee_name = $row->attendee_name;
				//create deactivated status display
				if($row->attendee_status == 0)
				{
					$status = '<span class="label label-warning">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'tree-planting/activate-group-member/'.$attendee_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to activate '.$attendee_name.'?\');" title="Activate '.$attendee_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($row->attendee_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'tree-planting/deactivate-group-member/'.$attendee_id.'/'.$meeting_id.'" onclick="return confirm(\'Do you want to deactivate '.$attendee_name.'?\');" title="Deactivate '.$attendee_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}
				

				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->attendee_name.' </td>
						<td>'.$row->attendee_national_id.' </td>
						<td>'.$row->attendee_number.' </td>
						<td>'.$status.'</td>	
						<td>'.$row->attendee_group_name.' </td>	
						<td>'.$row->attendee_email.' </td>
						<td>'.$row->attendee_organization.' </td>
						<td><a href="'.site_url().'tree-planting/edit-group-member/'.$attendee_id.'/'.$meeting_id.'" class="btn btn-sm btn-success"title="Edit '.$attendee_name.'"><i class="fa fa-pencil"></i></a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'tree-planting/delete-group-member/'.$attendee_id.'/'.$meeting_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$attendee_name.'?\');" title="Delete '.$attendee_name.'"><i class="fa fa-trash"></i></a></td>
					</tr> 
				';
			
			}
				
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no community group members";
		}

			
?>
<section class="panel panel-featured panel-featured-success">
	<header class="panel-heading">
		<h2 class="panel-title pull-left"><?php echo $title;?></h2>
		
		 <div class="widget-icons pull-right">
		 	<a data-toggle="modal" data-target="#upload_attendees" class="btn btn-warning btn-sm" style=""> Import Meeting Trainees</a>
		 
		 	

			<a  class="btn btn-sm btn-success fa fa-folder" id="open_new_community_group_member" onclick="get_new_community_group_member();" > Add meeting attendee</a>
	        
			<a  class="btn btn-sm btn-warning fa fa-folder-open" id="close_new_community_group_member" style="display:none;" onclick="close_new_community_group_member();"> Close new meeting attendee</a>
			<a href="<?php echo site_url();?>meeting/print-attendees/<?php echo $project_id;?>/<?php echo $meeting_id;?>" class="btn btn-sm btn-primary fa fa-print" style="" target="_blank" > Print Trainees</a>
			
			<a href="<?php echo site_url();?>tree-planting/trainings/<?php echo $project_id;?>" class="btn btn-sm btn-info fa fa-arrow-left" > Back to trainings</a>
			

		</div>
		 <div class="clearfix"></div>
	</header>
	<div class="panel-body">
			<div class="modal fade" id="upload_attendees" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Meeting Attendees</h4>
			</div>
			<div class="modal-body">
		        <!-- Widget content -->
				<div class="panel-body">
		        <div class="padd">
		            
		        <div class="row">
		        <div class="col-md-12">
				<?php
				$error = $this->session->userdata('error_message');
				$success = $this->session->userdata('success_message');
				
				if(!empty($error))
				{
					echo '<div class="alert alert-danger">'.$error.'</div>';
					$this->session->unset_userdata('error_message');
				}
				
				if(!empty($success))
				{
					echo '<div class="alert alert-success">'.$success.'</div>';
					$this->session->unset_userdata('success_message');
				}
				?>
		            <?php
		                if(isset($import_response))
		                {
		                    if(!empty($import_response))
		                    {
		                        echo $import_response;
		                    }
		                }
		                
		                if(isset($import_response_error))
		                {
		                    if(!empty($import_response_error))
		                    {
		                        echo '<div class="center-align alert alert-danger">'.$import_response_error.'</div>';
		                    }
		                }
		            ?>
		                
		            
		            <?php echo form_open_multipart('import/import-trainees/'.$project_id.'/'.$meeting_id, array("class" => "form-horizontal", "role" => "form"));?>
		            
		            <div class="row">
		                <div class="col-md-12">
		                    <ul>
		                        <li>Download the import template <a href="<?php echo site_url().'import/trainees-template';?>" target= "_blank">here.</a></li>
		                        
		                        <li>Save your file as a <strong>CSV (Comma Delimited)</strong> file before importing</li>
		                        <li>After adding your projects to the import template please import them using the button below</li>
		                    </ul>
		                </div>
		            </div>
		            
		            <div class="row">
						<div class="col-md-12" style="margin-top:10px">
							<div class="fileUpload btn btn-primary">
		                        <span>Import Trainees</span>
		                        <input type="file" class="upload" onChange="this.form.submit();" name="import_csv" />
		                    </div>
						</div>
		            </div>
		                   
		                    
		        </div>
		        </div>
		            <?php echo form_close();?>
				</div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
		</div>
	</div>
</div>
    	<div style="display:none;" class="col-md-12" style="margin-bottom:20px;" id="new_community_group_member">
        	<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Add a new meeting attendee</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("add-neeting-attendee/".$project_id."/".$meeting_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
            				<input type="hidden" name="meeting_type_id" value="<?php echo $meeting_type_id?>">

                				<div class="col-md-12">
                					<div class="row">
                    					<div class="col-md-4">
                        					<div class="form-group">
									            <label class="col-lg-4 control-label">Member Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_name" id="attendee_name" placeholder="Name" value="">
									            </div>
									        </div>
									        <div class="form-group" id="attendee_group_name_div">
									            <label class="col-lg-4 control-label">Group Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_group_name" id="attendee_group_name" placeholder="Group Name" value="">
									            </div>
									        </div>
									        
									    </div>
									    <div class="col-md-4">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">National id: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_national_id" id="attendee_national_id" placeholder="National ID" value="">
									            </div>
									        </div>
									        <div class="form-group" id="attendee_email_div">
									            <label class="col-lg-4 control-label">Attendee Email: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_email" id="attendee_email" placeholder="Attendee Email" value="">
									            </div>
									        </div>
									    </div>
									    <div class="col-md-4">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">Phone number: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_number" id="attendee_number" placeholder="Phone" value="">
									            </div>
									        </div>
									        <div class="form-group" id="attendee_organization_div">
									            <label class="col-lg-4 control-label">Organization Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="attendee_organization" id="attendee_organization" placeholder="Organization Name" value="">
									            </div>
									        </div>
									         
									    </div>
									    <div class="col-md-4">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">Gender: </label>
									            
									            <div class="col-lg-8">
									            	<select class="form-control" name="gender_id">
									            		<option value="1">Male</option>
									            		<option value="2">Female</option>
									            	</select>
									            </div>
									        </div>
									         
									    </div>
									</div>
								    <div class="row" style="margin-top:10px;">
										<div class="col-md-12">
									        <div class="form-actions center-align">
									            <button class="submit btn btn-primary" type="submit">
									                Add member
									            </button>
									        </div>
									    </div>
									</div>
                				</div>
                				<?php echo form_close();?>
                				<!-- end of form -->
                			</div>

            				
            			</div>
            			
            		</div>
				</div>
			</section>
        </div>
        <div class="col-md-12">
			<div class="table-responsive">
            	
				<?php 
				
				$success = $this->session->userdata('success_message');

				if(!empty($success))
				{
					echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
					$this->session->unset_userdata('success_message');
				}
				
				$error = $this->session->userdata('error_message');
				
				if(!empty($error))
				{
					echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
					$this->session->unset_userdata('error_message');
				}

				$search =  $this->session->userdata('all_community_group_members_search');
				if(!empty($search))
				{
					echo '<a href="'.site_url().'close_search_community_group_members" class="btn btn-sm btn-warning">Close Search</a>';
				}

				echo $result;
				
				?>
		
            </div>
             <div class="widget-foot">
        
				<?php if(isset($links)){echo $links;}?>
            
                <div class="clearfix"></div> 
            
            </div>

         </div>

	</div>
</section>
<script type="text/javascript">
	$(function() {
	    $("#attendee_id").customselect();
	});
	$(document).ready(function(){
		$(function() {
			$("#attendee_id").customselect();
		});
	});
	$(document).ready(function(){

		var meeting_type_id = <?php echo $meeting_type_id;?>;

		if(meeting_type_id == 1)
		{
			var myTarget1 = document.getElementById("attendee_name");
			var myTarget2 = document.getElementById("attendee_number");
			var myTarget3 = document.getElementById("attendee_national_id");
			var myTarget4 = document.getElementById("attendee_organization_div");
			var myTarget5 = document.getElementById("attendee_email_div");
			var myTarget6 = document.getElementById("attendee_group_name_div");

			myTarget1.style.display = '';
			myTarget2.style.display = '';
			myTarget3.style.display = '';
			myTarget4.style.display = 'none';
			myTarget5.style.display = 'none';
			myTarget6.style.display = '';

		}
		else if(meeting_type_id == 2)
		{
			var myTarget1 = document.getElementById("attendee_name");
			var myTarget2 = document.getElementById("attendee_number");
			var myTarget3 = document.getElementById("attendee_national_id");
			var myTarget4 = document.getElementById("attendee_organization_div");
			var myTarget5 = document.getElementById("attendee_email_div");
			var myTarget6 = document.getElementById("attendee_group_name_div");

			myTarget1.style.display = '';
			myTarget2.style.display = '';
			myTarget3.style.display = '';
			myTarget4.style.display = '';
			myTarget5.style.display = '';
			myTarget6.style.display = 'none';
		}
		else
		{
			var myTarget1 = document.getElementById("attendee_name");
			var myTarget2 = document.getElementById("attendee_number");
			var myTarget3 = document.getElementById("attendee_national_id");
			var myTarget4 = document.getElementById("attendee_organization_div");
			var myTarget5 = document.getElementById("attendee_email_div");
			var myTarget6 = document.getElementById("attendee_group_name_div");;

			myTarget1.style.display = '';
			myTarget2.style.display = '';
			myTarget3.style.display = '';
			myTarget4.style.display = '';
			myTarget5.style.display = '';
			myTarget6.style.display = '';
		}
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
		var button = document.getElementById("assign_new_community_group_member");
		var button2 = document.getElementById("close_assign_new_community_group_member");

		myTarget2.style.display = '';
		button.style.display = 'none';
		button2.style.display = '';
	}
	function close_assign_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member_allocation");
		var button = document.getElementById("assign_new_community_group_member");
		var button2 = document.getElementById("close_assign_new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		button2.style.display = 'none';
	}


	// lease details


	function get_community_group_member_leases(attendee_id){

		var myTarget2 = document.getElementById("lease_details"+attendee_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_lease_details"+attendee_id);
		var button2 = document.getElementById("close_lease_details"+attendee_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = '';
	}
	function close_community_group_member_leases(attendee_id){

		var myTarget2 = document.getElementById("lease_details"+attendee_id);
		var button = document.getElementById("open_lease_details"+attendee_id);
		var button2 = document.getElementById("close_lease_details"+attendee_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = 'none';
	}

	// community_group_member_info
	function get_community_group_member_info(attendee_id){

		var myTarget2 = document.getElementById("community_group_member_info"+attendee_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_community_group_member_info"+attendee_id);
		var button2 = document.getElementById("close_community_group_member_info"+attendee_id);

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = '';
	}
	function close_community_group_member_info(attendee_id){

		var myTarget2 = document.getElementById("community_group_member_info"+attendee_id);
		var button = document.getElementById("open_community_group_member_info"+attendee_id);
		var button2 = document.getElementById("close_community_group_member_info"+attendee_id);
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var myTarget4 = document.getElementById("new_community_group_member");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		myTarget4.style.display = 'none';
		button2.style.display = 'none';
	}


  </script>