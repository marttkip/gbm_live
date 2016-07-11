<?php
		
		$result = '';
		if($step_id == 0)
		{
			$items = 4;
		}
		else
		{
			$items = 1;
		}
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Year</th>
						<th>Month</th>
						<th>Planted trees</th>
						<th>Surviving trees</th>
					</tr>
				</thead>
				
				<tbody>
			';
			
			//get all administrators
			$administrators = $this->personnel_model->retrieve_personnel();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$site_id = $row->site_id;
				$site_name = $row->site_name;
				$status = $row->status;
				$created_by = $row->created_by;

				$surviving_trees = $row->surviving_trees;
				$planted_trees = $row->planted_trees;
				$created = $row->created;
				$month = $row->month;
				$year = $row->year;
			
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$year.'</td>
						<td>'.$month.'</td>
						<td>'.$planted_trees.'</td>
						<td>'.$surviving_trees.'</td>
						
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
			$result .= "There are no planting sites";
		}

		// if($step_id == 0)
		// {
		// 	$title_header = '<h3 class="center-align">STEP SIX : PLANTING PROCESS</h3>';
		// }
		// else if($step_id == 1)
		// {
		// 	$title_header = '<h3 class="center-align">STEP SEVEN : PLANTING PROCESS</h3>';
		// }
		// else
		// {
		// 	$title_header = '<h3 class="center-align">STEP EIGHT : PLANTING PROCESS</h3>';
		// }
?>
<?php echo $this->load->view('projects/projects/project_header','',true);?>

<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>
		<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>/<?php echo $step_id;?>" class="btn btn-sm btn-warning pull-right fa fa-arrow-left"  style="margin-top:-25px;margin-right: 15px;"> Back to activities</a>
		
		<a  class="btn btn-sm btn-success pull-right" id="open_new_community_group_member" onclick="get_new_community_group_member();" style="margin-top:-25px; margin-right: 15px;">Add follow up data</a>
		<a  class="btn btn-sm btn-warning pull-right" id="close_new_community_group_member" style="display:none; margin-top:-25px;margin-right:5px;" onclick="close_new_community_group_member();">Close add follow up</a>

		
		
	</header>
	<div class="panel-body">
		<div style="display:none;" class="col-md-12" id="new_community_group_member" >
        	<section class="panel">
				
				<div class="panel-body">
					<div class="row" style="margin-bottom:20px;">
            			<div class="col-lg-12 col-sm-12 col-md-12">
            				<div class="row">
            				<?php 
            						echo form_open("planting-site/add-followup-detail/".$project_id."/".$site_id."/".$step_id."", array("class" => "form-horizontal", "role" => "form"));
            					
            				?>
                				<div class="row">
						        	<div class="col-md-6">
                    					<div class="form-group">
								            <label class="col-lg-3 control-label">Month </label>
								            
								            <div class="col-lg-7">
								            	<select name='month_id' class='form-control' required>
								            	<?php
								            	$month_id = date('m');
								            	$month_name = date('M', $month_id);
								            	?>
					                             <option value="01">January</option>
					                             <option value="02">February</option>
					                             <option value="03">March</option>
					                             <option value="04">April</option>
					                             <option value="05">May</option>
					                             <option value="06">June</option>
					                             <option value="07">July</option>
					                             <option value="08">August</option>
					                             <option value="09">September</option>
					                             <option value="10">October</option>
					                             <option value="11">November</option>
					                             <option value="12">December</option>
					                            </select>
								            </div>
								        </div>
						            </div>
						            <div class="col-md-6">
						            	<div class="form-group">
								            <label class="col-lg-3 control-label">Year </label>
								            
								            <div class="col-lg-7">
								            	<select name='year' class='form-control' required>
								            	<?php
								            	$year = date('Y');
								            	?>
								            	<option value="2014">2014</option>
								            	<option value="2016">2015</option>
					                            <option value='<?php echo $year;?>' selected><?php echo $year;?></option>
					                            </select>
								            </div>
								        </div>
						            </div>
						      </div>
						      <br>
						        <div class="row">
						             <div class="col-md-6">
						             	<div class="form-actions">
									            <label class="col-lg-3 control-label">Total Planted </label>
										            
								            <div class="col-lg-7">
								            	<input type="text" id='total_planted' name='total_planted' class='form-control' required>
								            </div>
									      </div>
						             </div>
						              <div class="col-md-6">
						             	<div class="form-actions">
									            <label class="col-lg-3 control-label">Surviving Trees </label>
										            
								            <div class="col-lg-7">
								            	<input type="text" id='surviving_trees' name='surviving_trees' class='form-control' required>
								            </div>
									      </div>
						             </div>
						        </div>
						        <br>
						        <div class="form-actions center-align">
						            <button class="submit btn btn-sm btn-primary" type="submit">
						                Add Site 
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
        </div>
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