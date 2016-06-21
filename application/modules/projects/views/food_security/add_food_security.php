<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
		</div>
		<h2 class="panel-title">Add Food Security</h2>
	</header>
	<div class="panel-body">
		<div class="row" style="margin-bottom:20px;">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="row">
				<?php 
				echo form_open("food-security/add-food-security", array("class" => "form-horizontal", "role" => "form"));
					
				?>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-lg-4 control-label">Location</label>
								<div class="col-lg-8">
									<select name="location_id" id="location_id" class="form-control">
										<?php
										if($location_details->num_rows() > 0)
										{
											$status = $location_details->result();
											
											foreach($status as $res)
											{
												$location_id = $res->location_id;
												$constituency = $res->constituency_name;
												$catchment = $res->catchment;
												$ward_name = $res->ward_name;
												
												if($res->location_id == $location_id)
												{
													echo '<option value="'.$location_id.'" selected>'.$constituency.'-'.$ward_name.'-' .$catchment.'</option>';
												}
												
												else
												{
													echo '<option value="'.$personnel_type_id.'">'.$personnel_type_name.'</option>';
												}
											}
										}
										?>	
									</select>
								</div>
							</div>
							<div class="form-group" id="activity_title_div" style="display:none">
								<label class="col-lg-4 control-label">Farmer Name</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="farmer_name" placeholder="Farmer Name" value="<?php echo set_value('name');?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 control-label">Phone Numbers</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="phone_number" placeholder="Phone" value="<?php echo set_value('phone_number');?>" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 control-label">GPS Coordinates</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="gps" placeholder="GPS" value="<?php echo set_value('gps');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Eastings</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="eastings" placeholder="Eastings" value="<?php echo set_value('eastings');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Northings</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="nothings" placeholder="Northings" value="<?php echo set_value('northings');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Water Harvesting Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="harvesting_type" placeholder="Water Harvesting Type" value="<?php echo set_value('harvesting_type');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Water Harvesting Capacity</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="harvesting_capacity" placeholder="Water Harvesting Capacity" value="<?php echo set_value('harvesting_capacity');?>" required>
								</div>
							</div>
						    <div class="form-group">
								<label class="col-lg-4 control-label">Agroforestry Tree Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="agro_tree_type" placeholder="Agroforestry Tree Type" value="<?php echo set_value('agro_tree_type');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Agroforestry Tree Spacing</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="agro_tree_spacing" placeholder="Agroforestry Tree Spacing" value="<?php echo set_value('agro_tree_spacing');?>" required>
								</div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-lg-4 control-label">Agroforestry Tree Quantity</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="agro_tree_qty" placeholder="Agroforestry Tree Quantity" value="<?php echo set_value('agro_tree_qty');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Soil Conservation Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="soil_conservation_type" placeholder="Soil Conservation Type" value="<?php echo set_value('soil_conservation_type');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Soil Conservation Benches</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="soil_conservation_bench" placeholder="Soil Conservation Benches" value="<?php echo set_value('soil_conservation_bench');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Soil Conservation Quantity</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="soil_conservation_qty" placeholder="Soil Conservation Qty" value="<?php echo set_value('soil_conservation_qty');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Kitchen Gardening Name</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="kitchen_gardening_name" placeholder="Kitchen Gardening Name" value="<?php echo set_value('kitchen_gardening_name');?>" required>
								</div>
							</div>
						    <div class="form-group">
								<label class="col-lg-4 control-label">Kitchen Gardening Variety</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="kitchen_gardening_variety" placeholder="Kitchen Gardening Variety" value="<?php echo set_value('kitchen_gardening_variety');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Trench Arrow Roots Qty</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="trench_arrow_root_qty" placeholder="Trench Arrow Roots Qty" value="<?php echo set_value('trench_arrow_root_qty');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Trench Arrow Roots Trench Length</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="trench_length" placeholder="Trench Length" value="<?php echo set_value('trench_length');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Compost Manure Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="manure_type" placeholder="Manure Type" value="<?php echo set_value('manure_type');?>" required>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="form-actions center-align">
						<button class="submit btn btn-primary" type="submit">
							Add Food Security
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