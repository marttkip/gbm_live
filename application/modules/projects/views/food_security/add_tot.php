<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
		</div>
		<h2 class="panel-title"><?php echo $title;?></h2>
	</header>
	<div class="panel-body">
		<div class="padd">
		<div class="row" style="margin-bottom:20px;">
			<div class="col-lg-12 col-sm-12 col-md-12">
			
				<?php 
				echo form_open("food-security/add-trainer-of-tranees/".$data_page_id, array("class" => "form-horizontal", "role" => "form"));
					
				?>
					<div class="row">
						<div class="col-sm-6">
							
							<div class="form-group">
								<label class="col-lg-4 control-label">Project</label>
								<div class="col-lg-8">
								
									<select name="project_id" id="project_id" class="form-control">
										<?php
											echo $project_list;
										?>	
									</select>
								</div>
							</div>
							<div class="form-group" >
								<label class="col-lg-4 control-label">TOT Name</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="tot_name" placeholder="Farmer Name" value="<?php echo set_value('tot_name');?>">
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
								<label class="col-lg-4 control-label">AG Species</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="ag_species" placeholder="Species" value="<?php echo set_value('ag_species');?>" required>
								</div>
							</div>
		
						    <div class="form-group">
								<label class="col-lg-4 control-label">Agroforestry Tree Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="agro_tree_type" placeholder="Agroforestry Tree Type" value="<?php echo set_value('agro_tree_type');?>" required>
								</div>
							</div>
						</div>
						
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
		
							<div class="form-group">
								<label class="col-lg-4 control-label">Soil Conservation Type</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="soil_conservation_type" placeholder="Soil Conservation Type" value="<?php echo set_value('soil_conservation_type');?>" required>
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

							<div class="form-group">
								<label class="col-lg-4 control-label">Stoves</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="stoves" placeholder="Manure Type" value="<?php echo set_value('stoves');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Me Types</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="me_types" placeholder="Manure Type" value="<?php echo set_value('me_types');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">Bee Keeping</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="bee_keeping" placeholder="Manure Type" value="<?php echo set_value('bee_keeping');?>" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 control-label">TNE Species</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="tne_species" placeholder="Manure Type" value="<?php echo set_value('tne_species');?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 control-label">TNE Tree No</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="tne_treeno" placeholder="Manure Type" value="<?php echo set_value('tne_treeno');?>" required>
								</div>
							</div>

						</div>
					</div>
					<br>
					<div class="form-actions center-align">
						<button class="submit btn btn-primary" type="submit">
							Add Trainer of Trainees
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