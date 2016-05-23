 <?php
if(isset($error)){
    echo '<div class="alert alert-danger"> Oh snap! '.$error.' </div>';
}

//the project_area details
$project_area_name = $project_area[0]->project_area_name;
$project_area_status = $project_area[0]->project_area_status;
$project_area_longitude = $project_area[0]->project_area_longitude;
$project_area_latitude = $project_area[0]->project_area_latitude;

$validation_errors = validation_errors();

if(!empty($validation_errors))
{
	$project_area_name = set_value('project_area_name');
	$project_area_status = set_value('project_area_status');
	$project_area_longitude = set_value('project_area_longitude');
	$project_area_latitude = set_value('project_area_latitude');
	
    echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
}

?>

<div class="row">

  <section class="panel">

        <header class="panel-heading">
         <h2 class="panel-title"><?php echo $title;?> <?php echo $project_area_name;?> Details</h2>
       <a href="<?php echo site_url();?>tree-planting/project-areas" class="btn btn-info btn-sm pull-right" style="margin-top:-25px;">Back to project areas</a>
       <a href="<?php echo site_url();?>tree-planting/project-area-detail/<?php echo $project_area_id?>" class="btn btn-success btn-sm pull-right" style="margin-top:-25px; margin-right:3px">Open Project Detail</a>

       
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
                    
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                <?php
                                    $v_data['project_area'] = $project_area;
                                     //echo $this->load->view('edit/about', $v_data, TRUE);?>
                                      <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
								            <div class="row">
								                <div class="col-sm-6">
								                    <div class="form-group">
								                        <label class="col-lg-4 control-label">Project Area Name</label>
								                        <div class="col-lg-4">
								                            <input type="text" class="form-control" name="project_area_name" placeholder="Area name" value="<?php echo $project_area_name;?>" required>
								                        </div>
								                    </div>
								                    <div class="form-group">
								                        <label class="col-lg-4 control-label">Activate project area?</label>
								                        <div class="col-lg-4">
								                            <div class="radio">
								                                <label>
								                                    <?php
								                                    if($project_area_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="project_area_status">';}
								                                    else{echo '<input id="optionsRadios1" type="radio" value="1" name="project_area_status">';}
								                                    ?>
								                                    Yes
								                                </label>
								                            </div>
								                            <div class="radio">
								                                <label>
								                                    <?php
								                                    if($project_area_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="project_area_status">';}
								                                    else{echo '<input id="optionsRadios1" type="radio" value="0" name="project_area_status">';}
								                                    ?>
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
									                        <input type="text" class="form-control" name="project_area_latitude" placeholder="Latitude" value="<?php echo $project_area_latitude;?>" required>
									                    </div>
									                </div>
									                <div class="form-group">
									                    <label class="col-lg-4 control-label">Longitude</label>
									                    <div class="col-lg-6">
									                        <input type="text" class="form-control" name="project_area_longitude" placeholder="Longitude" value="<?php echo $project_area_longitude;?>" required>
									                    </div>
									                </div>
								                </div>
								            </div>
								            <div class="form-actions center-align">
								                <button class="submit btn btn-primary" type="submit">
								                    Edit project area
								                </button>
								            </div>
								            <br />
								            <?php echo form_close();?>
								            <hr>
								            <?php echo form_open_multipart(base_url().'upload-area-documents/'.$project_area_id, array("class" => "form-horizontal", "role" => "form"));?>
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
											                <button class="submit btn btn-primary" type="submit">
											                    Upload Document
											                </button>
											            </div>
								            	
								            </div>
								             <?php echo form_close();?>

                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
     <section class="panel">
        <header class="panel-heading">
         <h2 class="panel-title">Uploads</h2>       
        </header>
        <div class="panel-body">
            
            <div class="row">
                <div class="col-md-12">
                <?php echo $result;?>

                </div>
            </div>
        </div>
    </section>
</div>