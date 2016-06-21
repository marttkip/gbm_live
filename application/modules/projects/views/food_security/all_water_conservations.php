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
						<th><a>Farmer Name</a></th>
						<th><a>Phone Number</a></th>
						<th><a>GPS Coordinates</a></th>
					</tr>
				</thead>
				  <tbody>
			';
			foreach ($food_security->result() as $row)
			{
				$form_id = $row->form_id;
				$farmer_name = $row->name;
				$phone = $row->phone;
				$gps = $row->gps;
				

				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$row->name.' </td>
						<td>'.$row->phone.' </td>
						<td>'.$row->gps.' </td>
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
			$result .= "There are no water conservations";
		}

			
?>
<section class="panel panel-featured panel-featured-success">
	<header class="panel-heading">
		<h2 class="panel-title pull-left"><?php echo $title;?></h2>
		
		<div class="widget-icons pull-right">
			<a href="<?php echo site_url();?>add-water-conservation" class="btn btn-sm btn-info fa fa-arrow-left" > Add Conservation</a>
			
			<a href="<?php echo site_url();?>print-water-conservation" class="btn btn-sm btn-info fa fa-print" target="_blank" > Print Conservation</a>

		</div>
	</header>
	<div class ="panel-body">
		<?php echo $result;
		?>		
	</div>
</section>
		