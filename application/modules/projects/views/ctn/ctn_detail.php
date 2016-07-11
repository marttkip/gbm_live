<?php echo $this->load->view('projects/projects/project_header','',true);?>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-4">
			<a href="<?php echo site_url();?>tree-planting/seedling-production/<?php echo $project_id?>" class="btn btn-info btn-sm pull-left" ><i class="fa fa-arrow-left"></i> GO TO STEP FOUR : SEEDLINGS PRODUCTION</a>
		</div>
		<div class="col-md-4">
			<h3 class="center-align">STEP FIVE : GBM CENTRAL TREE NURSERY</h3>
		</div>
		<div class="col-md-4">
			<a href="<?php echo site_url();?>tree-planting/planting-sites/<?php echo $project_id?>" class="btn btn-info btn-sm pull-right" > GO TO STEP SIX : PLANTING PROCESS <i class="fa fa-arrow-right"></i></a>
		</div>
	</div>
</div>
<?php
$result = '';
if($ctn_query->num_rows() == 1)
{
	$result .= 
	'
	<table class="table table-bordered mb-none">
		<thead>
			<tr>
				<th>#</th>
				<th>CTN Name</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th>Modified by</th>
			</tr>
		</thead>
		
		<tbody>
	';
	$administrators = $this->personnel_model->retrieve_personnel();
	if ($administrators->num_rows() > 0)
	{
		$admins = $administrators->result();
	}
	
	else
	{
		$admins = NULL;
	}
	foreach ($ctn_query->result() as $key) {
		# code...
		$ctn_id = $key->community_group_id;
		$ctn_name = $key->community_group_name;
		$modified_by = $key->modified_by;
		$created_by = $key->created_by;

		//creators & editors
		if($admins != NULL)
		{
			foreach($admins as $adm)
			{
				$user_id = $adm->personnel_id;
				
				if($user_id == $created_by)
				{
					$created_by = $adm->personnel_fname;
				}
				
				if($user_id == $modified_by)
				{
					$modified_by = $adm->personnel_fname;
				}
			}
		}
		
		else
		{
		}

		$result .= 
		'
			<tr>
				<td>1</td>
				<td>'.$ctn_name.'</td>
				<td>-</td>
				<td>-</td>
				<td>'.$modified_by.'</td>
			</tr>
		';


	}
	$result .= 
			'
						  </tbody>
						</table>
			';
	?>


	

		<div class="row">
		<section class="panel">
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
				<div class="row">
					<div class="col-md-12">
				 		<div class="table-responsive">
							<?php echo $result;?>	
						</div>
				 	</div>
				</div>

				 <div class="row">
				 	
				 	<div class="col-md-12">
				 		<section class="panel">
							<header class="panel-heading">
								<div class="pull-right">
								</div>
				
								<h2 class="panel-title">Transfers from Area Nurseries to CTN</h2>
							</header>
							<div class="panel-body">
								<div class="table-responsive">
									
											<?php 
											$results = '<table class="table table-striped mb-none">
															<thead>
																<tr>
																	<th>#</th>
																	<th>Nursery Name</th>
																	<th>T. Request Seedlings</th>
																	<th>T. Delivered Seedlings</th>
																	<th>Modified By</th>
																	<th colspan="5">Actions</th>
																</tr>
															</thead>
															<tbody>';
											if($orders_query->num_rows() > 0)
											{
												$q = 0;
												foreach ($orders_query->result() as $order_values) {
													# code...
													$nursery_name  = $order_values->community_group_name;
													$nursery_id  = $order_values->community_group_id;
													
													$table = 'orders,order_item';
													$where = 'orders.order_id = order_item.order_id AND orders.nursery_id = '.$nursery_id.'';
													$select = 'SUM(order_item.order_item_quantity) AS quantity';
													$total_ordered_seedlings = $this->seedling_production_model->get_counter_amount_ctn($table, $where, $select);
													// var_dump($total_ordered_seedlings); die();
													$table = 'order_receivables';
													$where = 'order_receivables.nursery_id = '.$nursery_id.'';
													$select = 'SUM(quantity_given) AS quantity';
													$total_received_seedlings = $this->seedling_production_model->get_counter_amount_ctn($table, $where, $select);


													$q++;
													
													$results .= 
																'
																	<tr>
																		<td>'.$q.'</td>
																		<td>'.$nursery_name.'</td>
																		<td>'.$total_ordered_seedlings.'</td>
																		<td>'.$total_received_seedlings.'</td>
																		<td>'.$modified_by.'</td>
																		<td>
																			<a href="'.site_url().'tree-planting/orders/'.$project_id.'/'.$nursery_id.'/'.$ctn_id.'" class="btn btn-sm btn-info" id="open_tenant_info'.$nursery_id.'" ><i class="fa fa-arrow-up"></i> Orders</a>
																			
																		</td>
																		<td>
																			<a href="'.site_url().'tree-planting/receivables/'.$project_id.'/'.$nursery_id.'/'.$ctn_id.'" class="btn btn-sm btn-success" id="open_tenant_info'.$nursery_id.'" ><i class="fa fa-arrow-down"></i> Receivables</a>
																		</td>
																		
																		<td><a href="'.site_url().'tree-planting/delete-area-location/'.$nursery_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$nursery_name.'?\');" title="Delete '.$nursery_name.'"><i class="fa fa-trash"></i></a></td>
																	</tr>
																';
													
												}
											}
											else
											{
												$results = 'No Groups added yet';
											}
											
											$results .= '
															</tbody>
														</table>
														';
											echo $results;
											?>
										
								</div>
							</div>
						</section>
				 	</div>
				 </div>
			</div>
		</section>
		
	</div>

	
	<?php
}
else
{
	// create a ctn
	?>
		<section class="panel">
			  <header class="panel-heading">
		         <h2 class="panel-title pull-left"><?php echo $title;?></h2>
		         <div class="widget-icons pull-right">
		          </div>
		          <div class="clearfix"></div>
		    </header>
			
			<div class="panel-body">
				<div class="row">
					<?php echo form_open("tree-planting/add-ctn/".$project_id."", array("class" => "form-horizontal", "role" => "form"));?>
			            <div class="row">
			            	<div class="col-sm-11">
				                <div class="col-sm-12">
				                    <div class="form-group center-align">
				                        <label class="col-lg-4 control-label">CTN Name</label>
				                        <div class="col-lg-8">
				                            <input type="text" class="form-control" name="ctn_name" placeholder="Area name" value="" required>
				                        </div>
				                    </div>

				                </div>
				            </div>
			            </div>
			             <br />
			            <div class="form-actions center-align">
			                <button class="submit btn bn-sm btn-primary" type="submit">
			                    Create CTN
			                </button>
			            </div>
			           
			        <?php echo form_close();?>
				</div>
				
			</div>
			
		</section>

	<?php
}
?>
<script type="text/javascript">
	$(function() {
	    $("#nursery_id").customselect();
	});
	$(document).ready(function(){
		$(function() {
			$("#nursery_id").customselect();
		});
	});
</script>