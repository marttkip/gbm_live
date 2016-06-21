<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>
<section class="panel panel-featured panel-featured-info">
    <header class="panel-heading">
         <h2 class="panel-title pull-left"><?php echo $title;?></h2>
         <div class="widget-icons pull-right">
            	<a href="<?php echo base_url();?>tree-planting/projects" class="btn btn-success btn-sm">Back to projects</a>
          </div>
          <div class="clearfix"></div>
    </header>
    <div class="panel-body">
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            
            <div class="row">

                 <div class="col-md-6">
                     <div class="form-group">
                            <label class="col-lg-4 control-label">Project Title</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="project_title" value="<?php echo set_value('project_title');?>" required/>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Donor</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="project_donor" value="<?php echo set_value('project_donor');?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Location</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="project_location" value="<?php echo set_value('project_location');?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label">Grant Value</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="project_grant_value" value="<?php echo set_value('project_grant_value');?>" required/>
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
                                <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_start_date" placeholder="Project Start Date" required>
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
                                <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="project_end_date" placeholder="Project End Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="col-lg-4 control-label">Goal</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" name="project_instructions"><?php echo set_value('project_instructions');?></textarea>
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
	                    Create New Project
	                </button>
	            </div>
	         </div>
            <br />
            <?php echo form_close();?>
    </div>
</section>
<script type="text/javascript">
    $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 4
    });
</script>