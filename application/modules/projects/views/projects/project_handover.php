<?php
		
		$result = '';

	$handover = $this->projects_model->get_project_handover_attendee($project_id);

	if($handover->num_rows() > 0)
	{
		$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Phone Number</th>
						<th>National Id</th>
						<th>Gender</th>
						<th>Organization Name</th>
					</tr>
				</thead>
				  <tbody>
			';
		$count = 0;
		foreach ($handover->result() as $key) {
			# code...
			$handover_attendee_name = $key->handover_attendee_name;
			$handover_attendee_phone = $key->handover_attendee_phone;
			$handover_attendee_organization = $key->handover_attendee_organization;
			$handover_gender_id = $key->handover_gender_id;
			$handover_attendee_national_id = $key->handover_attendee_national_id;

			if($handover_gender_id == 1)
			{
				$gender = 'Male';
			}
			else
			{
				$gender = 'Female';
			}
			$count++;
			$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$handover_attendee_name.' </td>
						<td>'.$handover_attendee_national_id.' </td>
						<td>'.$handover_attendee_phone.' </td>
						<td>'.$gender.'</td>	
						<td>'.$handover_attendee_organization.' </td>
					</tr> 
				';

		}
	}
	else{
		$result .= "There are no community group members";
	}
	



	$project_handover = $this->projects_model->get_project_handover($project_id);
	if($project_handover->num_rows() > 0)
	{
		$rs_handover = $project_handover->result();

		$kfs_representative = $rs_handover[0]->kfs_representative;
		$gbm_representative = $rs_handover[0]->gbm_representative;
		$handover_date = $rs_handover[0]->handover_date;
		$handover_summery = $rs_handover[0]->handover_summery;
		$meeting_venue = $rs_handover[0]->meeting_venue;

	}
	else
	{


	$kfs_representative = set_value('kfs_representative');
	$gbm_representative = set_value('gbm_representative');
	$handover_date = set_value('handover_date');
	$handover_summery = set_value('handover_summery');
	$meeting_venue = set_value('meeting_venue');
	}
	
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-4">
			<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/3" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP NINE : SECOND FOLLOW UP</a>
		</div>
		<div class="col-md-4">
			<h3 class="center-align">STEP TEN : PROJECT HANDOVER</h3>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
</div>
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>
	</header>
	<div class="panel-body">
		
        <?php
		$error = $this->session->userdata('error_message');
		$success = $this->session->userdata('success_message');
		
		if(!empty($success))
		{
			echo '
				<div class="alert alert-success">'.$success.'</div>
			';
			$this->session->unset_userdata('success_message');
		}
		
		if(!empty($error))
		{
			echo '
				<div class="alert alert-danger">'.$error.'</div>
			';
			$this->session->unset_userdata('error_message');
		}
		?>

		<section class="panel">
				
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("update-project-handover/".$project_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-sm-6">
						                <!-- Company Name -->
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Venue</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="meeting_venue" placeholder="Meeting Venue" value="<?php echo $meeting_venue;?>" required>
						                    </div>
						                </div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Date</label>
						                    <div class="col-lg-8">
						                        <div class="input-group">
								                    <span class="input-group-addon">
								                        <i class="fa fa-calendar"></i>
								                    </span>
								                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="handover_date" placeholder="Handover Date" value="<?php echo $handover_date;?>">
								                </div>
						                    </div>
						                </div>
						            </div>
						            
						        	<div class="col-sm-6">
						        		
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">KFS Representative</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="kfs_representative" placeholder="Name" value="<?php echo $kfs_representative;?>" required>
						                    </div>
						                </div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">GBM Representative</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="gbm_representative" placeholder="Name" value="<?php echo $gbm_representative;?>" required>
						                    </div>
						                </div>
						                
						                <!-- Activate checkbox -->
						               
						            </div>
						        </div>
						        <br/>
						        <div class="row">
						        	<div class="col-sm-12">
						        		 <div class="form-group">
						                    <label class="col-lg-4 control-label">Hand over summery</label>
						                    <div class="col-lg-6">
						                        <textarea  class="form-control" name="handover_summery" placeholder="Description" rows="5" ><?php echo $handover_summery;?></textarea>
						                    </div>
						                </div>
						        	</div>
						        </div>
						         <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-primary" type="submit">
						                Add a meeting
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
		<a  class="btn btn-sm btn-success fa fa-folder" id="open_new_community_group_member" onclick="get_new_community_group_member();" > Add meeting attendee</a>
		<a  class="btn btn-sm btn-warning fa fa-folder-open" id="close_new_community_group_member" style="display:none;" onclick="close_new_community_group_member();"> Close new meeting attendee</a>
		<a href="<?php echo site_url();?>meeting/print-attendees/<?php echo $project_id;?>" class="btn btn-sm btn-primary fa fa-print" style="" target="_blank" > Print Trainees</a>

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
            						echo form_open("add-handover-attendee/".$project_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>

                				<div class="col-md-12">
                					<div class="row">
                    					<div class="col-md-4">
                        					<div class="form-group">
									            <label class="col-lg-4 control-label">Member Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="handover_attendee_name" id="handover_attendee_name" placeholder="Name" value="">
									            </div>
									        </div>
									        <div class="form-group">
									            <label class="col-lg-4 control-label">Phone number: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="handover_attendee_phone" id="handover_attendee_phone" placeholder="Phone" value="">
									            </div>
									        </div>
									        
									    </div>
									    <div class="col-md-4">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">Gender: </label>
									            
									            <div class="col-lg-8">
									            	<select class="form-control" name="handover_gender_id">
									            		<option value="1">Male</option>
									            		<option value="2">Female</option>
									            	</select>
									            </div>
									        </div>
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">National id: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="handover_attendee_national_id" id="handover_attendee_national_id" placeholder="National ID" value="">
									            </div>
									        </div>
									    </div>
									    <div class="col-md-4">
									        <div class="form-group" id="attendee_organization_div">
									            <label class="col-lg-4 control-label">Organization Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="handover_attendee_organization" id="handover_attendee_organization" placeholder="Organization Name" value="">
									            </div>
									        </div>
									         
									    </div>
									</div>
								    <div class="row" style="margin-top:10px;">
										<div class="col-md-12">
									        <div class="form-actions center-align">
									            <button class="submit btn btn-primary" type="submit">
									                Add participants
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
	</div>
    
    <div class="panel-foot">
        
		<?php if(isset($links)){echo $links;}?>
    
        <div class="clearfix"></div> 
    
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

  </script>