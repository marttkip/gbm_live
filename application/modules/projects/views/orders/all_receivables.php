<?php
$result = '<div class="padd">';		
	//if users exist display them
	if ($query->num_rows() > 0)
	{
		$count = $page;
		
		$result .= 
		'
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th >#</th>
					  <th>Date Given</th>
					  <th>Staff Received</th>
					  <th>Total Trees</th>
					  <th>Fruit Trees</th>
					  <th>Indigenous Trees</th>
					   <th>Exotic Trees</th>
					  <th>Date Created</th>
					  <th colspan="3">Actions</th>
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
						$receivable_id = $row->receivable_id;
						$quantity_given = $row->quantity_given;
						$created_by = $row->created_by;
						$personnel_id = $row->personnel_id;
						$created = $row->created;
						$driver_name = $row->driver_name;
						$driver_national_id = $row->driver_national_id;
						$mobile_no = $row->mobile_no;
						$date_given = $row->date_given;
						$fruit_trees = $row->fruit_trees;
						$indegenous_trees = $row->indegenous_trees;
						$exotic_trees = $row->exotic_trees;


						//creators & editors
						if($admins != NULL)
						{
							foreach($admins as $adm)
							{
								$user_id = $adm->personnel_id;
								
								if($user_id == $personnel_id)
								{
									$received_by = $adm->personnel_fname;
								}
								
							}
						}
						
						else
						{
								$received_by = '';
						}
						
						$count++;
						$result .= 
						'
							<tr>
								<td>'.$count.'</td>
								<td>'.date('jS M Y',strtotime($date_given)).'</td>
								<td>'.$received_by.'</td>
								<td>'.$quantity_given.'</td>
								<td>'.$fruit_trees.'</td>
								<td>'.$indegenous_trees.'</td>
								<td>'.$exotic_trees.'</td>
								<td>'.date('jS M Y',strtotime($created)).'</td>								
								<td><a href="'.site_url().'tree-planting/print-receivable/'.$receivable_id.'" class="btn btn-warning  btn-sm fa fa-print" target="_blank"></a></td>
								<td><a href="#" class="btn btn-danger  btn-sm fa fa-trash"></a></td>
								
							</tr> 
						';
					}
		
			$result .= 
			'
					  </tbody>
					</table>
				</div>
			</div>
			';
	}
	
	else
	{
		$result .= "There are no receivables created";
	}
	$result .= '</div>';

?>
<section class="panel">
	    <header class="panel-heading">
	        <h2 class="panel-title pull-left"><?php echo $title;?></h2>
	        <div class="widget-icons pull-right">
            		<a  class="btn btn-sm btn-primary" id="open_new_community_group_member" onclick="get_new_community_group_member();"  >Add receivable</a>
            		<a  class="btn btn-sm btn-danger" id="close_new_community_group_member" style="display:none;" onclick="close_new_community_group_member();">Close new receivable</a>
	        		<a href="<?php echo site_url();?>tree-planting/generate-form9/<?php echo $project_id?>/<?php echo $nursery_id?>/<?php echo $ctn_id?>" class="btn btn-warning btn-sm " target="_blank"> <i class="fa fa-print"></i> Generate Form 9</a>
	            	<a href="<?php echo base_url();?>tree-planting/ctn-detail/<?php echo $project_id;?>" class="btn btn-success btn-sm "><i class="fa fa-arrow-left"></i> Back to CTN Details</a>

	            	
	          </div>
	          <div class="clearfix"></div>
	    </header>
	    <div class="panel-body">
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
			<div style="display:none;" class="col-md-12" style="margin-bottom:20px;" id="new_community_group_member">
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
				                    Create a receivable
				                </button>
				            </div>
			            </div>
			            <br />
				        
				        <?php echo form_close();?>
				   </div> 
				   <?php echo $result;?>
	  	</div>
	</section>


	<script type="text/javascript">
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

</script>