<?php echo $this->load->view('projects/projects/project_header','',true);?>


<?php	

		$result = '';

		$items = '';

		
		//if community_group_members exist display them
		if ($query->num_rows() > 0)
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
			foreach ($query->result() as $row)
			{
				$cpm_id = $row->cpm_id;
				$cpm_name = $row->cpm_name;
				//create deactivated status display
				if($row->cpm_status == 0)
				{
					$status = '<span class="label label-warning">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'tree-planting/activate-group-member/'.$cpm_id.'/'.$cp_id.'" onclick="return confirm(\'Do you want to activate '.$cpm_name.'?\');" title="Activate '.$cpm_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($row->cpm_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'tree-planting/deactivate-group-member/'.$cpm_id.'/'.$cp_id.'" onclick="return confirm(\'Do you want to deactivate '.$cpm_name.'?\');" title="Deactivate '.$cpm_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}
				

				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->cpm_name.' </td>
						<td>'.$row->cpm_national_id.' </td>
						<td>'.$row->cpm_phone.' </td>
						<td>'.$status.'</td>						
						<td><a href="'.site_url().'tree-planting/edit-group-member/'.$cpm_id.'/'.$cp_id.'" class="btn btn-sm btn-success"title="Edit '.$cpm_name.'"><i class="fa fa-pencil"></i></a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'tree-planting/delete-group-member/'.$cpm_id.'/'.$cp_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$cpm_name.'?\');" title="Delete '.$cpm_name.'"><i class="fa fa-trash"></i></a></td>
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

			$link = '';
			$link = '<a href="'.site_url().'planting-site/activities/'.$project_id.'/'.$cp_id.'" class="btn btn-sm btn-default pull-right" style="margin-left:5px;margin-top:-25px;" >Back to planting sites</a>';

?>
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?> </h2>
		<?php echo $link;?>
		<a href="<?php echo site_url();?>print-activity-participants/<?php echo $project_id;?>/<?php echo $cp_id?>" class="btn btn-sm btn-warning pull-right" style="margin-right:5px;margin-top:-25px;" target="_blank" >Print Trainees</a>
		<a  class="btn btn-sm btn-success pull-right" id="open_new_community_group_member" onclick="get_new_community_group_member();" style="margin-right:5px;margin-top:-25px;">Add Casual Laborer </a>
        
		<a  class="btn btn-sm btn-warning pull-right" id="close_new_community_group_member" onclick="close_new_community_group_member();" style="display:none;margin-right:5px;margin-top:-25px;">Close casual</a>
	</header>
	<div class="panel-body">
    	<div style="display:none;" class="col-md-12" style="margin-bottom:20px;" id="new_community_group_member">
        	<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Add a new activity members</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("add-activity-members/".$project_id."/".$cp_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>

                				<div class="col-md-12">
                					<div class="row">
                    					<div class="col-md-3">
                        					<div class="form-group">
									            <label class="col-lg-4 control-label">Member Name: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="cpm_name" id="cpm_name" placeholder="Name" value="">
									            </div>
									        </div>
									        
									        
									    </div>
									    <div class="col-md-3">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">National id: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="cpm_national_id" id="cpm_national_id" placeholder="National ID" value="">
									            </div>
									        </div>
									        
									    </div>
									    <div class="col-md-3">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">Phone number: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="cpm_phone" id="cpm_phone" placeholder="Phone" value="">
									            </div>
									        </div>
									         
									    </div>
									    <div class="col-md-3">
									    	<div class="form-group">
									            <label class="col-lg-4 control-label">Amount: </label>
									            
									            <div class="col-lg-8">
									            	<input type="text" class="form-control" name="cpm_amount" id="cpm_amount" placeholder="Amount" value="">
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
	    $("#cpm_id").customselect();
	});
	$(document).ready(function(){
		$(function() {
			$("#cpm_id").customselect();
		});
	});
	function get_new_community_group_member(){
		
		var myTarget2 = document.getElementById("new_community_group_member");
		var myTarget3 = document.getElementById("new_community_group_member_allocation");
		var button = document.getElementById("open_new_community_group_member");
		var button2 = document.getElementById("close_new_community_group_member");

		myTarget2.style.display = '';
		button.style.display = 'none';
		myTarget3.style.display = 'none';
		button2.style.display = 'block';
	}
	function close_new_community_group_member(){

		var myTarget2 = document.getElementById("new_community_group_member");
		var button = document.getElementById("open_new_community_group_member");
		var button2 = document.getElementById("close_new_community_group_member");
		var myTarget3 = document.getElementById("new_community_group_member_allocation");

		myTarget2.style.display = 'none';
		button.style.display = '';
		myTarget3.style.display = 'none';
		button2.style.display = 'none';
	}



  </script>