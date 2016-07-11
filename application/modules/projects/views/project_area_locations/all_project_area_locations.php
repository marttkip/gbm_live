<?php
		
		$result = '';
		
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
						<th><a href="'.site_url().'tree-planting/project_areas/project_area_name/'.$order_method.'/'.$page.'">Watershed Name</a></th>
						
						<th><a href="'.site_url().'tree-planting/project_areas/last_modified/'.$order_method.'/'.$page.'">Last modified</a></th>
						<th><a href="'.site_url().'tree-planting/project_areas/project_area_status/'.$order_method.'/'.$page.'">Status</a></th>
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
				$project_area_id = $row->project_area_id;
				$project_area_name = $row->project_area_name;
				$project_area_status = $row->project_area_status;
				$project_area_latitude = $row->project_area_latitude;
				$project_area_longitude = $row->project_area_longitude;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$last_modified = date('jS M Y',strtotime($row->last_modified));
				$created = date('jS M Y',strtotime($row->created));
				
				//create deactivated status display
				if($project_area_status == 0)
				{
					$status = '<span class="label label-default">Deactivated</span>';
					$button = '<a class="btn btn-info btn-sm" href="'.site_url().'tree-planting/activate-area-location/'.$project_id.'/'.$project_area_id.'" onclick="return confirm(\'Do you want to activate '.$project_area_name.'?\');" title="Activate '.$project_area_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($project_area_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default btn-sm" href="'.site_url().'tree-planting/deactivate-area-location/'.$project_id.'/'.$project_area_id.'" onclick="return confirm(\'Do you want to deactivate '.$project_area_name.'?\');" title="Deactivate '.$project_area_name.'"><i class="fa fa-thumbs-down"></i></a>';
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
						
						if($user_id == $modified_by)
						{
							$modified_by = $adm->personnel_fname;
						}
					}
				}
				
				else
				{
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$project_area_name.'</td>
						<td>'.$last_modified.'</td>
						<td>'.$status.'</td>
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
			$result .= "There are no project areas";
		}
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>
<div class="row">
	<div class="col-md-12">
			<div class="col-md-4">
				<a href="<?php echo site_url();?>tree-planting/project-detail/<?php echo $project_id?>" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO PROJECT DETAIL</a>
			</div>
			<div class="col-md-4">
				<h3 class="center-align">STEP ONE : PROJECT WATERSHEDS</h3>
			</div>
			<div class="col-md-4">
				<a href="<?php echo site_url();?>tree-planting/trainings/<?php echo $project_id?>" class="btn btn-info btn-sm pull-right" > GO TO STEP TWO : TRAININGS AND WORKSHOPS <i class="fa fa-arrow-right"></i></a>
			</div>
	</div>
</div>
<section class="panel panel-featured panel-featured-success">
    <header class="panel-heading">
         <h2 class="panel-title pull-left"><?php echo $title;?></h2>
         <div class="widget-icons pull-right">
			
			<a  class="btn btn-sm btn-success pull-right fa fa-folder" id="open_new_community_group_member" onclick="get_new_community_group_member();" > Add Watershed</a>
			<a  class="btn btn-sm btn-warning pull-right  fa fa-folder-open" id="close_new_community_group_member" style="display:none;" onclick="close_new_community_group_member();">Close Watershed</a>
			<a data-toggle="modal" data-target="#upload_watershed" class="btn btn-warning btn-sm pull-right" >Import Watersheds</a>
          </div>

         
          <div class="clearfix"></div>
    </header>
	<div class="panel-body">
		<div class="modal fade" id="upload_watershed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Watershed</h4>
			</div>
			<div class="modal-body">
        
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
		                
		            
		            <?php echo form_open_multipart('import/import-watersheds/'.$project_id, array("class" => "form-horizontal", "role" => "form"));?>
		            
		            <div class="row">
		                <div class="col-md-12">
		                    <ul>
		                        <li>Download the import template <a href="<?php echo site_url().'import/watershed-template';?>" target= "_blank">here.</a></li>
		                        
		                        <li>Save your file as a <strong>CSV (Comma Delimited)</strong> file before importing</li>
		                        <li>After adding your projects to the import template please import them using the button below</li>
		                    </ul>
		                </div>
		            </div>
		            
		            <div class="row">
						<div class="col-md-12" style="margin-top:10px">
							<div class="fileUpload btn btn-primary">
		                        <span>Import Watersheds</span>
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
		<div style="display:none;" class="col-md-12" id="new_community_group_member" >
        	<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Add a new watershed</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("tree-planting/add-area-location/".$project_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-sm-6">
										<div class = "form-group">
											<label class="col-lg-4 control-label">Project Area Name</label>
											<div class="col-lg-6">
						                        <select name="location_id" id="location_id" class="form-control">
													<?php
													if($project_areas->num_rows() > 0)
													{
														$status = $project_areas->result();
														
														foreach($status as $res)
														{
															$project_area_id = $res->project_area_id;
															$project_area_name = $res->project_area_name;
															
															if($res->project_area_id == $project_area_id)
															{
																echo '<option value="'.$project_area_id.'" selected>'.$project_area_name.'</option>';
															}
															
															else
															{
																echo '<option value="'.$project_area_id.'" selected>'.$project_area_name.'</option>';
															}
														}
													}
													?>	
												</select>
						                    </div>
										</div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Activate?</label>
						                    <div class="col-lg-6">
						                        <div class="radio">
						                            <label>
						                                <input id="optionsRadios1" type="radio" checked value="1" name="project_area_status">
						                                Yes
						                            </label>
						                        </div>
						                        <div class="radio">
						                            <label>
						                                <input id="optionsRadios2" type="radio" value="0" name="project_area_status">
						                                No
						                            </label>
						                        </div>
						                    </div>
						                </div>
						            </div>
						            
						        	<div class="col-sm-6">
						        		<div class="form-group">
						                    <label class="col-lg-4 control-label">Latitude</label>
						                    <div class="col-lg-6">
						                        <input type="text" class="form-control" name="project_area_latitude" placeholder="latitude" value="<?php echo set_value('project_area_latitude');?>" required>
						                    </div>
						                </div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Longitude</label>
						                    <div class="col-lg-6">
						                        <input type="text" class="form-control" name="project_area_longitude" placeholder="Longitude" value="<?php echo set_value('project_area_longitude');?>" required>
						                    </div>
						                </div>
						                
						                <!-- Activate checkbox -->
						               
						            </div>
						        </div>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-primary" type="submit">
						                Add Watershed
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