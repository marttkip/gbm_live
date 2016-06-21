<?php
//personnel data
$row = $project->row();

// var_dump($row) or die();
$project_id = $row->project_id;
$project_number = $row->project_number;
$project_title = $row->project_title;
$project_grant_value = $row->project_grant_value;
$project_location = $row->project_location;
$project_status = $row->project_status;
$project_donor = $row->project_donor;
$county_name = $row->county_name;
$project_status = $row->project_status_id;
$project_instructions = $row->project_instructions;
$project_status_name = $row->project_status_name;
$created_by = $row->created_by;
$created = $row->created;
$modified_by = $row->modified_by;
$last_modified = $row->last_modified;
$project_approval_status = $row->project_approval_status;
$project_start_date = $row->project_start_date;
$project_end_date = $row->project_end_date;


$diff = abs(strtotime($project_start_date) - strtotime($project_end_date));

$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

//echo $gender_id;
//repopulate data if validation errors occur
$validation_error = validation_errors();
				
if(!empty($validation_error))
{

	$project_number = set_value('project_number');
	$project_title = set_value('project_title');
	$project_grant_value = set_value('project_grant_value');
	$project_location = set_value('project_location');
	$project_status = set_value('project_status');
	$project_donor = set_value('project_donor');
	$county_name = set_value('county_name');
	$project_status = set_value('project_status_id');
	$project_instructions = set_value('project_instructions');
	$project_status_name = set_value('project_status_name');
	$created_by = set_value('created_by');
	$created = set_value('created');
	$modified_by = set_value('modified_by');
	$last_modified = set_value('last_modified');
	$project_approval_status = set_value('project_approval_status');
	$project_start_date = set_value('project_start_date');
	$project_end_date = set_value('project_end_date');
}
?>
<?php
		
		$result = '';
     
		
		//if users exist display them
		if ($query_uploads->num_rows() > 0)
		{
			$result .= 
			'
				<table class="table table-hover table-bordered table-responsive">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Document Name</th>
					  <th>Date of Upload</th>
					  <th>Status</th>
					  <th colspan="1">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$count =0;
			
			foreach ($query_uploads->result() as $row)
			{
				$document_id = $row->document_id;
				$document_name = $row->document_name;
				$document_status = $row->document_status;
				$file_name = $row->file_name;
				$created_by = $row->created_by;
				
				//status
				if($document_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($document_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'activate-post/'.$document_id.'" onclick="return confirm(\'Do you want to activate '.$document_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($document_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'deactivate-post/'.$document_id.'" onclick="return confirm(\'Do you want to deactivate '.$document_name.'?\');">Deactivate</a>';
				}
				
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$document_name.'</td>
						<td>'.date('jS M Y',strtotime($row->created)).'</td>
						<td>'.$status.'</td>
						<td><a href="'.base_url()."assets/documents/projects/".$file_name.'" target="_blank" class="btn btn-xs btn-warning">View</a></td>
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
			$result .= "There are no uploads";
		}
		
?>
      	<div class="row">
        
          <section class="panel">

                <header class="panel-heading">
                	<div class="row">
	                	<div class="col-md-6">
		                    <h2 class="panel-title"><?php echo $project_title.' '.$project_number;?> Details</h2>
		                    <i class="fa fa-calendar"/></i>
		                    <span id="mobile_phone"><?php echo $project_start_date;?></span>
		                    <i class="fa fa-calendar"/></i>
		                    <span id="work_email"><?php echo $project_end_date;?></span>
		                </div>
		                <div class="col-md-6">
		                		<a href="<?php echo site_url();?>tree-planting/projects" class="btn btn-sm btn-info pull-right"><i class="fa fa-arrow-left"></i> Back to projects</a>
		                </div>
	                </div>
                </header>
                <div class="panel-body">
                    
                    <div class="row">
                    	<div class="col-md-12">
                        	<?php
                            	$success = $this->session->userdata('success_message');
                            	$error = $this->session->userdata('error_message');
								
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
                        	<div class="tabs">
								<ul class="nav nav-tabs nav-justified">
									<li class="active">
										<a class="text-center" data-toggle="tab" href="#general"><i class="fa fa-user"></i> General details</a>
									</li>
									<li>
										<a class="text-center" data-toggle="tab" href="#watersheds"><i class="fa fa-user"></i> Project Watersheds</a>
									</li>
									<li>
										<a class="text-center" data-toggle="tab" href="#uploads"><i class="fa fa-user"></i> Project Uploads</a>
									</li>
							
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="general">
											<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
										 	<div class="row">
							                 <div class="col-md-6">
							                     <div class="form-group">
							                            <label class="col-lg-4 control-label">Project Title</label>
							                            <div class="col-lg-8">
							                                <input type="text" class="form-control" name="project_title" value="<?php echo $project_title;?>" required/>
							                            </div>
							                    </div>
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Donor</label>
							                        <div class="col-lg-8">
							                            <input type="text" class="form-control" name="project_donor" value="<?php echo $project_donor;?>" required/>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Location</label>
							                        <div class="col-lg-8">
							                            <input type="text" class="form-control" name="project_location" value="<?php echo $project_location;?>" required/>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Grant Value</label>
							                        <div class="col-lg-8">
							                            <input type="text" class="form-control" name="project_grant_value" value="<?php echo $project_grant_value;?>" required/>
							                        </div>
							                    </div>
							                    
							                </div>
							                 <div class="col-md-6">
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Grant County</label>
							                        <div class="col-lg-8">
							                            <select name="project_grant_county" class="form-control" >
							                                <?php echo $county_list;?>
							                            </select>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Project Start Date</label>
							                        <div class="col-lg-8">
							                           <div class="input-group">
							                                <span class="input-group-addon">
							                                    <i class="fa fa-calendar"></i>
							                                </span>
							                                <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_start_date" placeholder="Project Start Date" value="<?php echo $project_start_date;?>" required>
							                            </div>
							                        </div>
							                    </div>
							                 <!-- brand Name -->
							                    <div class="form-group">
							                        <label class="col-lg-4 control-label">Project End Date</label>
							                        <div class="col-lg-8">
							                            <div class="input-group">
							                                <span class="input-group-addon">
							                                    <i class="fa fa-calendar"></i>
							                                </span>
							                                <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_end_date" placeholder="Project End Date" value="<?php echo $project_end_date;?>" required>
							                            </div>
							                        </div>
							                    </div>
							                    <div class="form-group">
							                            <label class="col-lg-4 control-label">Goal</label>
							                            <div class="col-lg-8">
							                                <textarea class="form-control" name="project_instructions"><?php echo $project_instructions;?></textarea>
							                            </div>
							                        </div>
							                </div>
							            </div>
							            <br />
							     		<div class="row">
								            <div class="form-actions center-align">
								                <button class="submit btn btn-primary btn-sm" type="submit">
								                    Edit New Project
								                </button>
								            </div>
								         </div>
							            <br />
						           
								    <?php echo form_close();?>
						           
									</div>
									<div class="tab-pane" id="watersheds">
									</div>
									<div class="tab-pane" id="uploads">
										<div class="row">
							                 <div class="col-md-12">
												 <?php echo form_open_multipart(base_url().'upload-project-documents/'.$project_id.'/'.$project_number, array("class" => "form-horizontal", "role" => "form"));?>

											            <div class="row">
											                <div class="col-sm-6">
											                    <div class="form-group">
											                        <label class="col-lg-4 control-label">Document Name</label>
											                        <div class="col-lg-8">
											                            <input type="text" class="form-control" name="attachement_name" placeholder="Attachment Name" value="" required>
											                        </div>
											                    </div>
											                </div>
											                <div class="col-md-6"> 
												                <div class="form-group">
													                <label class="col-lg-4 control-label">Post Image</label>
													                <div class="col-lg-8">
													                    <input type="file" name="post_image"></span>
													                </div>
													            </div>
											                </div>
											            </div>
											            <br/>
											            <div class="row">
											             <div class="form-actions center-align">
											                <button class="submit btn btn-primary btn-sm" type="submit">
											                    Upload Document
											                </button>
											            </div>
											            	
											            </div>
											       	<?php echo form_close();?>
												     <hr>
												     <div class="row">
												     	<?php echo $result;?>
												     </div>
												</div>
											</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        