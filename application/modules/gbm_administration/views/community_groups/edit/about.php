<?php
 $row = $company_array;
 //the company details
    $community_group_id = $row->community_group_id;
    $community_group_name = $row->community_group_name;
    $community_group_contact_person_name = $row->community_group_contact_person_name;
    $community_group_contact_person_phone1 = $row->community_group_contact_person_phone1;
    $community_group_contact_person_phone2 = $row->community_group_contact_person_phone2;
    $community_group_contact_person_email1 = $row->community_group_contact_person_email1;
    $community_group_contact_person_email2 = $row->community_group_contact_person_email2;
    $community_group_description = $row->community_group_description;
    $community_group_status = $row->community_group_status;
	$address =$row->address;
	$location= $row->location;
	$gbm_group = $row->gbm_group;
	$now_activities =$row->now_activities;
	$later_activities = $row->later_activities;
	$account_number = $row->account_number;
	$account_name = $row->account_name;
	$sub_location = $row->sub_location; 
	$county = $row->county;
	$district = $row->district;
	$division = $row->division;
	$chief = $row->chief;
	$market = $row->market;
	$mp = $row->mp; 
	$sub_chief = $row->sub_chief;
	

    $validation_errors = validation_errors();

    if(!empty($validation_errors))
    {
        $community_group_id = set_value('community_group_id');
        $community_group_name = set_value('community_group_name');
        $community_group_contact_person_name = set_value('community_group_contact_person_name');
        $community_group_contact_person_phone1 = set_value('community_group_contact_person_phone1');
        $community_group_contact_person_phone2 = set_value('community_group_contact_person_phone2');
        $community_group_contact_person_email1 = set_value('community_group_contact_person_email1');
        $community_group_contact_person_email2 = set_value('community_group_contact_person_email2');
        $community_group_description = set_value('community_group_description');
        $community_group_status = set_value('community_group_status');
		$address = set_value('address');
		$location= set_value('location');
		$gbm_group = set_value('gbm_group');
		$now_activities = set_value('now_activities');
		$later_activities = set_value('later_activities');
		$account_number = set_value('account_number');
		$account_name = set_value('account_name');
		$sub_location = set_value('sub_location');
		$county = set_value('county');
		$district = set_value('district');
		$division = set_value('division');
		$chief = set_value('chief');
		$market = set_value('market');
		$mp = set_value('mp');
		$sub_chief = set_value('sub_chief');
        
        echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
    }
?>
<?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
    <div class="row">
    	<div class="col-sm-6">
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Community group Name</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_name" placeholder="Community Name" value="<?php echo $community_group_name;?>">
                </div>
            </div>
            
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Concact Person Name</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_contact_person_name" placeholder="Concact Person Name" value="<?php echo $community_group_contact_person_name;?>">
                </div>
            </div>
            
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Contact Person Phone 1</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_contact_person_phone1" placeholder="Contact Person Phone 1" value="<?php echo $community_group_contact_person_phone1;?>">
                </div>
            </div>
            
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Contact Person Phone 2</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_contact_person_phone2" placeholder="Contact Person Phone 2" value="<?php echo $community_group_contact_person_phone2;?>">
                </div>
            </div>
                       
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Contact Person email 1</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_contact_person_email1" placeholder="Contact Person email 1" value="<?php echo $community_group_contact_person_email1;?>">
                </div>
            </div>
            
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Contact Person email 2</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="community_group_contact_person_email2" placeholder="Contact Person email 2" value="<?php echo $community_group_contact_person_email2;?>">
                </div>
            </div>
            <!-- Company Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Insurance Company Description</label>
                <div class="col-lg-8">
                	<textarea name="community_group_description" class="form-control" rows="5" placeholder="Insurance Company Description"><?php echo $community_group_description;?></textarea>
                </div>
            </div>
             <div class="form-group">
                <label class="col-lg-4 control-label">Address</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $address;?>" required>
                </div>
            </div>
        </div>
        
    	<div class="col-sm-6">
            <div class="form-group">
                <label class="col-lg-4 control-label"> Location</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="location" placeholder="Location" value="<?php echo $location;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Sub Location</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="sub_location" placeholder="sub_location" value="<?php echo $sub_location;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> District</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="district" placeholder="district" value="<?php echo $district;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Division</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="division" placeholder="division" value="<?php echo $division;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> County</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="county" placeholder="county" value="<?php echo $county;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Chief's Name</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="chief_name" placeholder="Chief's name" value="<?php echo $chief;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Sub Chief's Name</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="sub_chief" placeholder="Sub Chief" value="<?php echo $sub_chief;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Member of Parliament</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="mp" placeholder="MP" value="<?php echo $mp;?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label"> Market (Close to your area)</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="market" placeholder="market" value="<?php echo $market;?>" required>
                </div>
            </div>
        </div>    
    </div>
    <br/>
    <div class="form-actions center-align">
        <button class="submit btn btn-sm btn-primary" type="submit">
            Edit community group
        </button>
    </div>
    <br/>
<?php echo form_close();?>