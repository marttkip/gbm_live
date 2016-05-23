<?php 
	$v_data['order_status_query'] = $order_status_query;
	//echo $this->load->view('inventory/search/search_orders', '' , TRUE); 
?>
<section class="panel panel-featured panel-featured-info">
    <header class="panel-heading">
         <h2 class="panel-title pull-left"><?php echo $title;?></h2>
         <div class="widget-icons pull-right">
         		<a  class="btn btn-sm btn-info pull-right" href="<?php echo site_url();?>tree-planting/ctn-detail/<?php echo $project_id;?>" style="margin-left:5px;"><i class="fa fa-arrow-left"></i> Back to CTN Detail </a>
            	<a  class="btn btn-sm btn-success pull-right" id="open_new_community_group_member" onclick="get_new_community_group_member();"  >Add order</a>
            	<a  class="btn btn-sm btn-warning pull-right" id="close_new_community_group_member" style="display:none;" onclick="close_new_community_group_member();">Close new order</a>
          </div>
          <div class="clearfix"></div>
    </header>
    <div class="panel-body">
	    <div style="display:none;" class="col-md-12" style="margin-bottom:20px;" id="new_community_group_member">
	        	<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
						</div>
						<h2 class="panel-title">Add a new order</h2>
					</header>
					<div class="panel-body">
						<div class="row" style="margin-bottom:20px;">
	            			<div class="col-lg-12 col-sm-12 col-md-12">
	            				<div class="row">
	            				<?php 
	            						echo form_open("tree-planting/add-order/".$project_id."/".$nursery_id."/".$ctn_id."", array("class" => "form-horizontal", "role" => "form"));
	            					
	            				?>
	            				<input type="hidden" name="nursery_id" value="<?php echo $nursery_id?>">
	            				<input type="hidden" name="ctn_id" value="<?php echo $ctn_id?>">

	                				<div class="col-md-12">

	                					<div class="row">
	                    					<div class="col-md-12">
	                        					<div class="form-group center-align">
										            <label class="col-lg-4 control-label">Order Instructions: </label>
										            
										            <div class="col-lg-6">
										            	<textarea name="order_instructions" class="form-control"></textarea>
										            </div>
										        </div>
										    </div>
										</div>
									    <div class="row" style="margin-top:10px;">
											<div class="col-md-12">
										        <div class="form-actions center-align">
										            <button class="submit btn btn-primary" type="submit">
										                Add Orders
										            </button>
										        </div>
										    </div>
										</div>
	                				</div>
	                				<?php echo form_close();?>
	                				<!-- end of form -->
	                			</div>

	            				
	            			</div>
	            			
	            		</div>
					</div>
				</section>
	        </div>
			<?php echo $this->load->view('views/low_level', '' , TRUE); ?>
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