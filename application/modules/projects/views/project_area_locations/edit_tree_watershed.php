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
    	<?php echo form_open_multipart(''.site_url().'tree-planting/edit-area/'.$project_area_id.'', array("class" => "form-horizontal", "role" => "form"));?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-lg-4 control-label">Project Watershed Name</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="project_area_name" placeholder="Name" value="<?php echo $project_area_name;?>" required>
                    </div>
                </div>
                
            </div>
            
            <div class="col-sm-6">
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
        </div>
        <div class="form-actions center-align">
            <button class="submit btn btn-primary" type="submit">
                Edit Watershed
            </button>
        </div>
       
    </section>
</div>