<?php	

		$result = '';
		//if food security exist display them
		if ($food_security->num_rows() > 0)
		{
			$count = 0;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Project Title</th>
						<th>Farmer Name</th>
						<th>Phone Number</th>
						<th>GPS Coordinates</th>
					</tr>
				</thead>
				  <tbody>
			';
			foreach ($food_security->result() as $row)
			{
				$form_id = $row->form_id;
				$farmer_name = $row->name;
				$phone = $row->phone;
				$project_title = $row->project_title;
				$location_id = $row->location_id;
				$gps = $row->gps;
				

				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->project_title.' </td>
						<td>'.$row->name.' </td>
						<td>'.$row->phone.' </td>
						<td>'.$row->gps.' </td>
						<td><a href="'.site_url().'print-food-security/'.$location_id.'" class="btn btn-sm btn-primary fa fa-print" target="_blank" > Print Food Security</a></td>
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
			$result .= "There are no food securities";
		}
		if($data_page_id == 1)
		{
			$back_page = 'gender-livelihoods-&-advocacy';
		}
		else
		{
			$back_page = 'climate-change';
		}
			
?>
<section class="panel panel-featured panel-featured-success">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>
		<a href="<?php echo site_url();?><?php echo $back_page;?>" style="margin-top:-25px;" class="btn btn-sm btn-warning pull-right fa fa-arrow-left" > Back to dashboard</a>
		<a href="<?php echo site_url();?>add-food-security/<?php echo $data_page_id;?>" style="margin-top:-25px;" class="btn btn-sm btn-success pull-right fa fa-plus" > Add Food Security</a>
			
	</header>
	<div class ="panel-body">
		<?php echo $result;
		?>		
	</div>
</section>
		