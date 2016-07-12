<?php
$row = $meeting_details->row();

// var_dump($row) or die();
$meeting_id = $row->meeting_id;
$grant_name = $row->grant_name;
$grant_county = $row->grant_county;
$meeting_start_date = $row->meeting_start_date;
$meeting_end_date = $row->meeting_end_date;
$activity_title = $row->activity_title;
$meeting_description = $row->meeting_description;
$meeting_type_id = $row->meeting_type_id;
$meeting_venue = $row->meeting_venue;

$validation_errors = validation_errors();

if(!empty($validation_errors))
{
	$project_start_date = set_value('project_start_date');
	$meeting_id = set_value('meeting_id');
	$grant_name = set_value('grant_name');
	$grant_county = set_value('grant_county');
	$meeting_start_date = set_value('meeting_start_date');
	$meeting_end_date = set_value('meeting_end_date');
	$activity_title = set_value('activity_title');
	$meeting_description = set_value('meeting_description');
	$meeting_type_id = set_value('meeting_type_id');
	$meeting_venue = set_value('meeting_venue');
    echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
}
?>
<section class="panel">
				<header class="panel-heading">
					<div class="panel-actions">
					</div>
					<h2 class="panel-title">Edit meeting</h2>
				</header>
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            				echo form_open('tree-planting/edit-training/'.$project_id.'/'.$meeting_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-sm-6">
						                <!-- Company Name -->

						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Type</label>
						                    <div class="col-lg-8">
						                    	<select name="meeting_type_id" id="meeting_type_id" class="form-control" onchange="meetingChange()" value="<?php echo $meeting_type_id;?>">
						                    		<option value="0">Select a meeting type</option>
						                    		<option value="1">CEE</option>
						                    		<option value="2">Stakeholders</option>
						                    		<option value="3">Others</option>
						                    	</select>
						                    </div>
						                </div>
						                <div class="form-group" id="activity_title_div" style="display:none">
						                    <label class="col-lg-4 control-label">Activity Title</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="activity_title" placeholder="Activity Title" value="<?php echo $activity_title;?>">
						                    </div>
						                </div>

						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Venue</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="meeting_venue" placeholder="Meeting Venue" value="<?php echo $meeting_venue;?>" required>
						                    </div>
						                </div>

						                        

						               
						            </div>
						            
						        	<div class="col-sm-6">
						        		<div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Start Date</label>
						                    <div class="col-lg-8">
						                        <div class="input-group">
								                    <span class="input-group-addon">
								                        <i class="fa fa-calendar"></i>
								                    </span>
								                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="meeting_start_date" placeholder="Meeting Start Date" value="<?php echo $meeting_start_date;?>">
								                </div>
						                    </div>
						                </div>
						                 <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting End Date</label>
						                    <div class="col-lg-8">
						                        <div class="input-group">
								                    <span class="input-group-addon">
								                        <i class="fa fa-calendar"></i>
								                    </span>
								                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="meeting_end_date" placeholder="Meeting End Date" value="<?php echo $meeting_end_date;?>">
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
						                    <label class="col-lg-4 control-label">Meeting Description</label>
						                    <div class="col-lg-6">
						                        <textarea  class="form-control" name="meeting_description" value="<?php echo $meeting_description;?>"></textarea>
						                    </div>
						                </div>
						        	</div>
						        </div>
						        <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-primary" type="submit">
						                Edit meeting
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