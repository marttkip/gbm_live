<?php
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

$validation_errors = validation_errors();

if(!empty($validation_errors))
{
	$project_area_name = set_value('project_area_name');
	$project_id = set_value('project_id');
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
		
    echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
}
?>

<div class="row">
<section class="panel">
	<div class = "row">
    <?php echo form_open_multipart(''.site_url().'gbm_administration/project-edit/'.$project_id.'', array("class" => "form-horizontal", "role" => "form"));?>
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
                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_start_date" value="<?php echo $project_start_date;?>" required>
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
                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_end_date" value="<?php echo $project_end_date;?>"  required>
                </div>
            </div>
        </div>
        <div class="form-group">
                <label class="col-lg-4 control-label">Goal</label>
                <div class="col-lg-8">
                    <textarea class="form-control" name="project_instructions"><?php echo $project_instructions;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Watersheds</label>
                <div class="col-lg-8">
                    <select class="form-control selectpicker" name="watersheds[]" multiple>
                      <?php echo $water_sheds;?>
                    </select>

                </div>
            </div>
    </div>
</div>
<br />
<div class="row">
    <div class="form-actions center-align">
        <button class="submit btn btn-primary btn-sm" type="submit">
            Edit Project
        </button>
    </div>
 </div>
<br />
            <?php echo form_close();?>
    </div>