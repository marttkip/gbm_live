<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
    <div class="row ">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-lg-4 control-label">Date Given</label>
                <div class="col-lg-7">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="date_given" placeholder="Date Given" value="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Fruit Tree</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="fruit_trees" placeholder="Fruit Trees" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Indegenous Tree</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="indegenous_trees" placeholder="Indegenous Trees" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Exotic Trees</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="exotic_trees" placeholder="Exotic Trees" value="" required>
                </div>
            </div>

            

        </div>
         <div class="col-md-6">
            <div class="form-group">
                <label class="col-lg-4 control-label">Received By</label>
                <div class="col-lg-8">
                    <select id='personnel_id' name='personnel_id' class='form-control custom-select ' required>
                      <option value=''>None - Please Select GBM Personnel</option>
                      <?php echo $personnel_list;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Driver Name</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="driver_name" placeholder="Driver Name" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Driver National ID</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="driver_national_id" placeholder="National ID" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Mobile No.</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="mobile_no" placeholder="Mobile Number" value="" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label">Vehicle Number.</label>
                <div class="col-lg-7">
                    <input type="text" class="form-control" name="vehicle_number_plate" placeholder="Number Plate" value="" required>
                </div>
            </div>

            

            
         </div>
    </div>
     <br />
     <div class="row ">
        <div class="form-actions center-align">
            <button class="submit btn btn-sm btn-primary" type="submit">
                Edit receivable
            </button>
        </div>
    </div>
    <br />
    
    <?php echo form_close();?>
</div> 