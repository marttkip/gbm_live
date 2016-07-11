<?php
		
		$result = '';
		if($step_id == 0)
		{
			$items = 4;
		}
		else
		{
			$items = 1;
		}
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="'.site_url().'tree-planting/planting_sites/site_name/'.$order_method.'/'.$page.'">Site Name</a></th>
						<th><a href="'.site_url().'tree-planting/planting_sites/last_modified/'.$order_method.'/'.$page.'">Created By</a></th>
						<th><a href="'.site_url().'tree-planting/planting_sites/status/'.$order_method.'/'.$page.'">Status</a></th>
						<th colspan="'.$items.'">Actions</th>
					</tr>
				</thead>
				
				<tbody>
			';
			
			//get all administrators
			$administrators = $this->personnel_model->retrieve_personnel();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$site_id = $row->site_id;
				$site_name = $row->site_name;
				$status = $row->status;
				$created_by = $row->created_by;
				
				//create deactivated status display
				if($status == 0)
				{
					$status_bar = '<span class="label label-default">Deactivated</span>';
					$button = '<a class="btn btn-info btn-sm" href="'.site_url().'tree-planting/activate-planting-site/'.$project_id.'/'.$site_id.'" onclick="return confirm(\'Do you want to activate '.$site_name.'?\');" title="Activate '.$site_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($status == 1)
				{
					$status_bar = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default btn-sm" href="'.site_url().'tree-planting/deactivate-planting-site/'.$project_id.'/'.$site_id.'" onclick="return confirm(\'Do you want to deactivate '.$site_name.'?\');" title="Deactivate '.$site_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}
				
				//creators & editors
				if($admins != NULL)
				{
					foreach($admins as $adm)
					{
						$user_id = $adm->personnel_id;
						
						if($user_id == $created_by)
						{
							$created_by = $adm->personnel_fname;
						}
						
					}
				}
				
				else
				{
				}

				if($step_id == 0)
				{
					$changes = '
								<td><a href="'.site_url().'tree-planting/edit-area/'.$site_id.'" class="btn btn-sm btn-success" title="Edit '.$site_name.'"><i class="fa fa-pencil"></i></a></td>
								<td>'.$button.'</td>
								<td><a href="'.site_url().'tree-planting/delete-planting-site/'.$site_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$site_name.'?\');" title="Delete '.$site_name.'"><i class="fa fa-trash"></i></a></td>
								';
				}
				else
				{
					$changes = '';
				}
				if($step_id ==  2 || $step_id ==  3)
				{
					$activity_button = '<a href="'.site_url().'planting-site/follow-up/'.$project_id.'/'.$site_id.'/'.$step_id.'" class="btn btn-sm btn-success" title="Open '.$site_name.'"><i class="fa fa-folder"></i> Follow Up</a>';
				}
				else
				{
					$activity_button = '<a href="'.site_url().'planting-site/activities/'.$project_id.'/'.$site_id.'/'.$step_id.'" class="btn btn-sm btn-warning" title="Open '.$site_name.'"><i class="fa fa-folder"></i> Activities</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$site_name.'</td>
						<td>'.$created_by.'</td>
						<td>'.$status_bar.'</td>
						<td>'.$activity_button.'</td>
						
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
			$result .= "There are no planting sites";
		}

		// if($step_id == 0)
		// {
		// 	$title_header = '<h3 class="center-align">STEP SIX : PLANTING PROCESS</h3>';
		// }
		// else if($step_id == 1)
		// {
		// 	$title_header = '<h3 class="center-align">STEP SEVEN : PLANTING PROCESS</h3>';
		// }
		// else
		// {
		// 	$title_header = '<h3 class="center-align">STEP EIGHT : PLANTING PROCESS</h3>';
		// }
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>
<div class="row">
		<?php
			if($step_id == 0)
			{
				?>
				<div class="col-md-12">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/ctn-detail/<?php echo $project_id?>" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP FIVE : GBM CENTRAL TREE NURSERY</a>
					</div>
					<div class="col-md-4">
						<h3 class="center-align">STEP SIX : PLANTING PROCESS</h3>
					</div>
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/1" class="btn btn-info btn-sm pull-right" > GO TO STEP SEVEN : TREE PLANTING <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
				<?php

			}
			else if($step_id == 1)
			{
				?>
				<div class="col-md-12">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/0" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP SIX : SITE PREPARATION</a>
					</div>
					<div class="col-md-4">
						<h3 class="center-align">STEP SEVEN : TREE PLANTING</h3>
					</div>
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/2" class="btn btn-info btn-sm pull-right" > GO TO STEP EIGHT : FIRST FOLLOW UP <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
				<?php
			}
			else if($step_id == 2)
			{
				?>
				<div class="col-md-12">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/1" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP SEVEN : TREE PLANTING</a>
					</div>
					<div class="col-md-4">
						<h3 class="center-align">STEP EIGHT : FIRST FOLLOW UP</h3>
					</div>
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/3" class="btn btn-info btn-sm pull-right" > GO TO STEP NINE : SECOND FOLLOW UP <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
				<?php
			}
			else
			{	
				?>
				<div class="col-md-12">
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id;?>/2" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP EIGHT : FIRST FOLLOWUP</a>
					</div>
					<div class="col-md-4">
						<h3 class="center-align">STEP NINE : SECOND FOLLOW UP</h3>
					</div>
					<div class="col-md-4">
						<a href="<?php echo site_url();?>tree-planting/project-handover/<?php echo $project_id?>" class="btn btn-info btn-sm pull-right" > GO TO STEP TEN : PROJECT HANDOVER <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
				<?php

			}
		?>
	
</div>
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>

		<?php
		if($step_id == 0)
		{
			?>
				<a  class="btn btn-sm btn-success pull-right" id="open_new_community_group_member" onclick="get_new_community_group_member();" style="margin-top:-25px; margin-right: 15px;">Add planting site</a>
				<a  class="btn btn-sm btn-warning pull-right" id="close_new_community_group_member" style="display:none; margin-top:-25px;margin-right:5px;" onclick="close_new_community_group_member();">Close planting site</a>
			<?php
		}
		?>
		
		
	</header>
	<div class="panel-body">
		<div style="display:none;" class="col-md-12" id="new_community_group_member" >
        	<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Add a new planting site</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("tree-planting/add-planting-site/".$project_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-sm-12">
						                <!-- Company Name -->
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Site Name</label>
						                    <div class="col-lg-6">
						                        <input type="text" class="form-control" name="site_name" placeholder="Name" value="<?php echo set_value('site_name');?>" required>
						                    </div>
						                </div>
						            </div>
						        </div>
						        <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-sm btn-primary" type="submit">
						                Add Site 
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
		<div class="table-responsive">
        	
			<?php echo $result;?>
	
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