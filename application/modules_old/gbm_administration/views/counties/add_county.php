          
          <section class="panel">
                <header class="panel-heading">
                              
                    <h2 class="panel-title"><?php echo $title;?></h2>
                     <a href="<?php echo site_url();?>gbm-administration/counties" class="btn btn-info btn-sm pull-right" style="margin-top:-25px;">Back to counties</a>
                </header>
                <div class="panel-body">
              
                    <!-- Adding Errors -->
                    <?php
                    if(isset($error)){
                        echo '<div class="alert alert-danger"> Oh snap! '.$error.'. </div>';
                    }
                    
                    $validation_errors = validation_errors();
                    
                    if(!empty($validation_errors))
                    {
                        echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
                    }
                    ?>
                    
                    <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
                    <div class="row">
                    	<div class="col-sm-6">
                            <!-- Company Name -->
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Name</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="county_name" placeholder="Name" value="<?php echo set_value('county_name');?>" required>
                                </div>
                            </div>
                        </div>
                        
                    	<div class="col-sm-6">
                            <!-- Activate checkbox -->
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Activate?</label>
                                <div class="col-lg-6">
                                    <div class="radio">
                                        <label>
                                            <input id="optionsRadios1" type="radio" checked value="1" name="county_status">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input id="optionsRadios2" type="radio" value="0" name="county_status">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions center-align">
                        <button class="submit btn btn-primary" type="submit">
                            Add county
                        </button>
                    </div>
                    <br />
                    <?php echo form_close();?>
                </div>
            </section>