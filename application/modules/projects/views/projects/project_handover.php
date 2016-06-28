<?php
		
		$result = '';
		
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-4">
			<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/3" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP NINE : SECOND FOLLOW UP</a>
		</div>
		<div class="col-md-4">
			<h3 class="center-align">STEP TEN : PROJECT HANDOVER</h3>
		</div>
		<div class="col-md-4">
			
		</div>
	</div>
</div>
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>
	</header>
	<div class="panel-body">
		
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

		<section class="panel">
				
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("planting-site/update-project-handover/".$project_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-sm-6">
						                <!-- Company Name -->
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Venue</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="meeting_venue" placeholder="Meeting Venue" value="<?php echo set_value('meeting_venue');?>" required>
						                    </div>
						                </div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">Meeting Date</label>
						                    <div class="col-lg-8">
						                        <div class="input-group">
								                    <span class="input-group-addon">
								                        <i class="fa fa-calendar"></i>
								                    </span>
								                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="meeting_date" placeholder="Meeting Date" value="<?php echo set_value('meeting_date');?>">
								                </div>
						                    </div>
						                </div>
						            </div>
						            
						        	<div class="col-sm-6">
						        		
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">KFS Representative</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="kfs_rpresentative" placeholder="Name" value="<?php echo set_value('kfs_rpresentative');?>" required>
						                    </div>
						                </div>
						                <div class="form-group">
						                    <label class="col-lg-4 control-label">GBM Representative</label>
						                    <div class="col-lg-8">
						                    	<input type="text" class="form-control" name="gbm_representative" placeholder="Name" value="<?php echo set_value('gbm_representative');?>" required>
						                    </div>
						                </div>
						                
						                <!-- Activate checkbox -->
						               
						            </div>
						        </div>
						        <br/>
						        <div class="row">
						        	<div class="col-sm-12">
						        		 <div class="form-group">
						                    <label class="col-lg-4 control-label">Hand over summery</label>
						                    <div class="col-lg-6">
						                        <textarea  class="form-control" name="meeting_description" placeholder="Description" rows="5" ></textarea>
						                    </div>
						                </div>
						        	</div>
						        </div>
						         <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-primary" type="submit">
						                Add a meeting
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