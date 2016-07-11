<?php
$order_approval_status = $this->orders_model->get_order_approval_status($order_id);

if($order_approval_status == 0)
{
?>	
	<section class="panel">
	    <header class="panel-heading">
	        <h2 class="panel-title pull-left">Add Order Item</h2>
	        <div class="widget-icons pull-right">
	            	<a href="<?php echo base_url();?>tree-planting/orders/<?php echo $project_id;?>/<?php echo $nursery_id;?>/<?php echo $ctn_id;?>" class="btn btn-success btn-sm">Back to Orders</a>
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
			
				    	<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
				        <div class="row ">
			                <div class="col-md-6">
			                    <div class="form-group">
			                        <label class="col-lg-4 control-label">Seedling Type</label>
			                        <div class="col-lg-8">
			                            <select id='seedling_type_id' name='seedling_type_id' class='form-control custom-select ' required>
			                              <option value=''>None - Please Select a seedling Type</option>
			                              <?php echo $seedling_type_list;?>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group center-align">
			                        <label class="col-lg-4 control-label">Order Quantity</label>
			                        <div class="col-lg-7">
			                            <input type="text" class="form-control" name="quantity" placeholder="Quantity" value="" required>
			                        </div>
			                    </div>

			                </div>
			                 <div class="col-md-6">
								<div class="form-group">
			                        <label class="col-lg-4 control-label">Seedling Species</label>
			                        <div class="col-lg-8">
			                            <select id='species_id' name='species_id' class='form-control custom-select ' required>
			                              <option value=''>None - Please Select a species</option>
			                              <?php echo $species_list;?>
			                            </select>
			                        </div>
			                    </div>
			                    <div class="form-group center-align">
			                        <label class="col-lg-4 control-label">Price</label>
			                        <div class="col-lg-7">
			                            <input type="text" class="form-control" name="price" placeholder="Price per unit" value="" required>
			                        </div>
			                    </div>
			                 </div>
			            </div>
			             <br />
			             <div class="row ">
				            <div class="form-actions center-align">
				                <button class="submit btn btn-sm btn-primary" type="submit">
				                    Add Order Item
				                </button>
				            </div>
			            </div>
				        
				        <?php echo form_close();?>
				    
	  	</div>
	</section>
<?php
} 

else if($order_approval_status == 2 || $order_approval_status == 3)
{
	if($order_approval_status == 2)
	{
	?>	
		<section class="panel">
		    <header class="panel-heading">
		        <h2 class="panel-title pull-left">Request for Quotation</h2>
		        <div class="widget-icons pull-right">
		            	<!-- <a href="<?php echo base_url();?>inventory/request-for-quotation/<?php echo $order_id?>" class="btn btn-warning btn-sm fa fa-print"> Print order Details</a> -->
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
				
		    	<?php echo form_open('inventory/submit-supplier/'.$order_id, array("class" => "form-horizontal", "role" => "form"));?>
		        <div class="row">
		        	<div class="col-md-12 center-align">
		                <div class="form-group">
		                	<label class="col-lg-2 control-label">Supplier Name</label>
		                    <div class="col-lg-8">
		                    	<select class="form-control" name="supplier_id">
		                    		<option>SELECT A SUPPLIER</option>
		                    		<?php
		                    		if($suppliers_query->num_rows() > 0)
		                    		{
		                    			foreach ($suppliers_query->result() as $key_supplier_items ) {
		                    				# code...
		                    				$supplier_id = $key_supplier_items->supplier_id;
		                    				$supplier_name = $key_supplier_items->supplier_name;

		                    				echo '<option value="'.$supplier_id.'">'.$supplier_name.'</option>';
		                    			}
		                    		}
		                    		?>

		                    	</select>
		                       
		                    </div>
		                </div>
		              </div>
		            </div>
		            <br>
		            <div class="row">
			              <div class="center-align">
			            	<button class="btn btn-primary btn-sm" type="submit">Request Supplier for quotation</button>
			            </div>
		        	</div>
		        
		        <?php echo form_close();?>
					    
		  	</div>
		</section>
	<?php
	}
	?>
		<section class="panel">
		    <header class="panel-heading">
		        <h2 class="panel-title pull-left">Order Suppliers</h2>
		        <div class="widget-icons pull-right">
		            	<a href="<?php echo base_url();?>inventory/request-for-quotation/<?php echo $order_id?>" class="btn btn-warning btn-sm fa fa-print"> Print order Details</a>
		          </div>
		          <div class="clearfix"></div>
		    </header>
		    <div class="panel-body">
		    	<?php
		    	$result_suppliers = '';

        		if($order_suppliers->num_rows() > 0)
        		{
        			
        			$result_suppliers .= 
        				'<div class="row">
								<div class="col-md-12">
									<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
									  <thead>
										<tr>
										  <th class="table-sortable:default table-sortable" title="Click to sort">#</th>
										  <th class="table-sortable:default table-sortable" title="Click to sort">Supplier Name</th>
										  <th class="table-sortable:default table-sortable" title="Click to sort">Contact Person</th>
										  <th class="table-sortable:default table-sortable" title="Click to sort">Supplier Phone</th>
										  <th>Supplier Status</th>
										  <th colspan="2">Actions</th>
										 
										</tr>
									  </thead>
									  <tbody>';
									$counter = 0;

				        			foreach ($order_suppliers->result() as $key_supplier) {
				        				# code...
				        				$supplier_id = $key_supplier->supplier_id;
				        				$supplier_order_id = $key_supplier->supplier_order_id;
				        				$supplier_name = $key_supplier->supplier_name;
				        				$supplier_phone = $key_supplier->supplier_phone;
				        				$supplier_contact_person = $key_supplier->supplier_contact_person;
				        				$supplier_order_status = $key_supplier->supplier_order_status;

				        				if($supplier_order_status == 0)
				        				{
				        					$status = '<span class="label label-info">On Review</span>';
				        				}
				        				else if($supplier_order_status == 1)
				        				{
				        					$status = '<span class="label label-success">Awarded</span>';
				        				}
				        				else
				        				{
				        					$status = '<span class="label label-info">On Review</span>';
				        				}
				        				$counter++;
				        				$result_suppliers .='<tr >
				        										<td>'.$counter.'</td>
				        										<td>'.$supplier_name.'</td>
				        										<td>'.$supplier_contact_person.'</td>
				        										<td>'.$supplier_phone.'</td>
				        										<td>'.$status.'</td>
				        										<td>
																	<a  class="btn btn-sm btn-primary fa fa-folder" id="open_visit'.$supplier_order_id.'" onclick="get_visit_trail('.$supplier_order_id.');"> Open Details</a>
																	<a  class="btn btn-sm btn-info fa fa-folder" id="close_visit'.$supplier_order_id.'" style="display:none;" onclick="close_visit_trail('.$supplier_order_id.');"> Close Detail</a></td>
																</td>
				        										<td><a href=""  class="btn btn-danger btn-sm">Remove Supplier</a></td>

				        									</tr>';
				        				$v_data['order_id'] = $order_id;
				        				$v_data['supplier_order_id'] = $supplier_order_id;
				        				$v_data['supplier_id'] = $supplier_id;
				        				$result_suppliers .='
				        								<tr id="visit_trail'.$supplier_order_id.'" style="display:none;">
				        									<td colspan="7">'.$this->load->view("views/order_supplier", $v_data, TRUE).'</td>
				        								</tr>';
				        				
				        			}

				        			$result_suppliers .= '
				        								</tbody>
				        							</table>
				        						</div>
				        					</div>';

        			echo $result_suppliers;
        		}


        		?>
		    </div>
		 </section>
	<?php
 }

?>
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title pull-left">Order Items</h2>
         
          <div class="clearfix"></div>
    </header>
    <div class="panel-body">

    	<div class="row">
			<div class="col-md-12">
				<div class="center-align">
					<?php
					$order_approval_status = $this->orders_model->get_order_approval_status($order_id);
					$rank = 2;
					$next_order_status = $order_approval_status+1;
						
					// check if assgned the next level 
					$check_level_approval = $this->orders_model->check_assigned_next_approval($order_approval_status);

					if($order_approval_status == 0)
					{
						?>
							<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to send order for next approval?');">Send Order for approval</a>
						<?php
					}

					else if($order_approval_status == 1 AND $check_level_approval == TRUE )
					{
						?>
							<a class="btn btn-warning btn-sm" href="<?php echo base_url();?>inventory/send-for-correction/<?php echo $order_id;?>" onClick="return confirm('Do you want to send order for review / correction?');">Send order for correction</a>
		            		<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to send order for next approval?');">Send Order for next approval</a>
						<?php
					}
					else if($order_approval_status == 2 AND $check_level_approval == TRUE )
					{
						?>
							<a class="btn btn-warning btn-sm" href="<?php echo base_url();?>inventory/send-for-correction/<?php echo $order_id;?>" onClick="return confirm('Do you want to send order for review / correction?');">Send order for correction</a>
		            		<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to send order for next approval?');">Send Order for approval</a>
						<?php
					}
					
					else if(($order_approval_status == 3 AND $check_level_approval == TRUE ))
					{
						?>
							<a class="btn btn-warning btn-sm" href="<?php echo base_url();?>inventory/send-for-correction/<?php echo $order_id;?>" onClick="return confirm('Do you want to send order for review / correction?');">Send order for correction</a>
		            		<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to send order for next approval?');">Send Order for approval</a>
						<?php
					}
					else if($order_approval_status == 4 AND $check_level_approval == TRUE )
					{
						?>
							<a class="btn btn-warning btn-sm fa fa-print" href="<?php echo base_url();?>inventory/print-supplier-quotation/<?php echo $order_id;?>" onClick="return confirm('Do you want to print supplier qoutation?');"> Print Supplier Qoutation</a>
							<a class="btn btn-primary btn-sm fa fa-print" href="<?php echo base_url();?>inventory/generate-lpo/<?php echo $order_id;?>" onClick="return confirm('Do you want to view the LPO?');"> View LPO </a>
		            		<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to send order for next approval?');">Send Order for approval</a>
						<?php
					}
					else if($order_approval_status == 5 AND $check_level_approval == TRUE )
					{
						?>
							<a class="btn btn-warning btn-sm fa fa-print" href="<?php echo base_url();?>inventory/generate-lpo/<?php echo $order_id;?>" target="_blank"> View Qoutation </a>
							<a class="btn btn-primary btn-sm fa fa-print" href="<?php echo base_url();?>inventory/generate-lpo/<?php echo $order_id;?>" target="_blank"> View LPO </a>
		            		<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onClick="return confirm('Do you want to approve the LPO?');">Approve LPO</a>
						<?php
					}
					else if($order_approval_status == 6 AND $check_level_approval == TRUE )
					{
						?>
							<a class="btn btn-primary btn-sm fa fa-print" href="<?php echo base_url();?>inventory/generate-lpo/<?php echo $order_id;?>" target="_blank" > Generate LPO </a>
		            		<!-- <a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>/<?php echo $next_order_status;?>" onclick="return confirm('Do you want to send order for next approval?');">Send Order for approval</a> -->
						<?php
					}

					else
					{
						echo '<div class="alert alert-info">Your Order is waiting for the next approval</div>';
					}
				
					?>
	            	
	            </div>
			</div>
		</div>
		<br>
    	<?php
    		$result ='';
			if($order_item_query->num_rows() > 0)
			{
				$col = '';
				$message = '';
				
				if($order_approval_status == 0)
				{
					$col = '
							<th>Unit Price (KES)</th>
							<th>Total Price (KES) </th>
							<th colspan="2">Actions</th>';

				}
				else if($order_approval_status == 4)
				{
					$col .= '
							<th>Unit Price (KES)</th>
							<th>Total Price (KES) </th>
							<th colspan="1">Actions</th>';

				}
				else if($order_approval_status == 5 OR $order_approval_status == 6)
				{
					$col .= '
							<th>Unit Price (KES)</th>
							<th>Total Price (KES) </th>';

				}

				else
				{
					$col = '';
				}
					
				$result .= 
				'
				<div class="row">
					<div class="col-md-12">
						<table class="example table-autosort:0 table-stripeclass:alternate table table-hover table-bordered " id="TABLE_2">
						  <thead>
							<tr>
							  <th class="table-sortable:default table-sortable" title="Click to sort">#</th>
							  <th class="table-sortable:default table-sortable" title="Click to sort">Seedling Type Name</th>
							  <th class="table-sortable:default table-sortable" title="Click to sort">Species Name</th>
							  <th class="table-sortable:default table-sortable" title="Click to sort">Quantity</th>

							  '.$col.'
							</tr>
						  </thead>
						  <tbody>
						';
						$count = 0;
						$invoice_total = 0;
						foreach($order_item_query->result() as $res)
						{
							$order_id = $res->order_id;
							$seedling_type_name = $res->seedling_type_name;
							$species_name = $res->species_name;
							$order_item_quantity = $res->order_item_quantity;
							$order_item_id = $res->order_item_id;
							$order_item_price = $res->order_item_price;



							?>


		                    <?php
		                    $count++;

							

								if($order_approval_status == 0)
								{
									$total_price = $order_item_price * $order_item_quantity;
				                    $result .= ' '.form_open('inventory/update-order-item/'.$order_id.'/'.$order_item_id).'
												<tr>
													<td>'.$count.'</td>
													<td>'.$seedling_type_name.'</td>
													<td>'.$species_name.'</td>
													<td><input type="text" class="form-control" name="quantity" value="'.$order_item_quantity.'"></td>
													<td><input type="text" class="form-control" name="unit_price" value="'.$order_item_price.'"></td>
													<td>'.number_format($total_price,2).'</td>
													<td><button class="btn btn-success btn-sm" type="submit"><i class="fa fa-pencil"></i> Edit Order</button></td>
													<td><a href="'.site_url("inventory/delete-order-item/".$order_item_id).'" onclick="return confirm("Do you want to delete '.$seedling_type_name.'?")" title="Delete '.$seedling_type_name.' class="btn btn-danger btn-sm">Delete</a></td>
												</tr>
												'.form_close().'
												';
								}
								else if($order_approval_status == 4)
								{
									 $total_price = $order_item_price * $order_item_quantity;
									 $result .= ' '.form_open('inventory/update-supplier-prices/'.$order_id.'/'.$order_item_id).'
												<tr>
													<td>'.$count.'</td>
													<td>'.$product_name.'</td>
													<td><input type="text" class="form-control" name="quantity" value="'.$order_item_quantity.'" readonly></td>
													<td><input type="text" class="form-control" name="unit_price" value="'.$order_item_price.'"></td>
													<td>'.number_format($total_price,2).'</td>
													<td><button class="btn btn-warning btn-sm" type="submit"><i class="fa fa-pencil"></i> Update Price</button></td>
												</tr>
												'.form_close().'
												';
								}
								else if($order_approval_status == 5 OR $order_approval_status == 6)
								{
									 $total_price = $order_item_price * $order_item_quantity;

									 
									 $result .= ' 
												<tr>
													<td>'.$count.'</td>
													<td>'.$product_name.'</td>
													<td><input type="text" class="form-control" name="quantity" value="'.$order_item_quantity.'" readonly></td>
													<td><input type="text" class="form-control" name="unit_price" value="'.$order_item_price.'" readonly></td>
													<td>'.number_format($total_price,2).'</td>
												</tr>
												';
									
								}
								else
								{
									 $result .= '
												<tr>
													<td>'.$count.'</td>
													<td>'.$product_name.'</td>
													<td><input type="text" class="form-control" name="quantity" value="'.$order_item_quantity.'" readonly></td>
												</tr>
												';
								}
								$invoice_total = $total_price + $invoice_total;
		                    ?>
		                    <?php
						}
						
							$result .= ' 
												<tr>
													<td colspan="4"></td>
													<td>TOTAL AMOUNT</td>
													<td>'.number_format($invoice_total,2).'</td>
												</tr>
												';
						
						
						$result .= '
							</tbody>
						</table>
						';

						echo $result;
					}
				?>

				<div class="row">
					<div class="col-md-12">
						<div class="center-align">
						<?php
			            	$order_approval_status = $this->orders_model->get_order_approval_status($order_id);

							if($order_approval_status > 0)
							{
								echo '
									<div class="alert alert-info">Your Order is being processed</div>
								';
							}
							else
							{
								?>
								<a class="btn btn-success btn-sm" href="<?php echo base_url();?>inventory/send-for-approval/<?php echo $order_id;?>">Send Order for approval</a>
								<?php
							}
							?>
			            </div>
					</div>
				</div>
    </div>
</section>


<script type="text/javascript">
$(function() {
    $("#seedling_type_id").customselect();
    $("#species_id").customselect();
    $("#personnel_id").customselect();
});
$(document).ready(function(){
	$(function() {
		$("#seedling_type_id").customselect();
		$("#species_id").customselect();
		$("#personnel_id").customselect();
	});
});

function get_visit_trail(visit_id){

	var myTarget2 = document.getElementById("visit_trail"+visit_id);
	var button = document.getElementById("open_visit"+visit_id);
	var button2 = document.getElementById("close_visit"+visit_id);

	myTarget2.style.display = '';
	button.style.display = 'none';
	button2.style.display = '';
}
function close_visit_trail(visit_id){

	var myTarget2 = document.getElementById("visit_trail"+visit_id);
	var button = document.getElementById("open_visit"+visit_id);
	var button2 = document.getElementById("close_visit"+visit_id);

	myTarget2.style.display = 'none';
	button.style.display = '';
	button2.style.display = 'none';
}

function order_items(order_id){
       
        var XMLHttpRequestObject = false;
            
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        var url = "<?php echo site_url();?>tree-planting/get-order-items/"+order_id;
       
         if(XMLHttpRequestObject) {
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                    document.getElementById("order_items").innerHTML=XMLHttpRequestObject.responseText;
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }

    }
</script>