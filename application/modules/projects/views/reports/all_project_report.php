<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$email2 = $contacts['email'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
		
		if(!empty($facebook))
		{
			$facebook = '<li class="facebook"><a href="'.$facebook.'" target="_blank" title="Facebook">Facebook</a></li>';
		}
		
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
		$google = '';
	}
?>
<?php $v_data['project_status_query'] = $project_status_query; ?>
<?php
	$error = $this->session->userdata('error_message');
	$success = $this->session->userdata('success_message');
	$search_result ='';
	$search_result2  ='';
	if(!empty($error))
	{
		$search_result2 = '<div class="alert alert-danger">'.$error.'</div>';
		$this->session->unset_userdata('error_message');
	}
	
	if(!empty($success))
	{
		$search_result2 ='<div class="alert alert-success">'.$success.'</div>';
		$this->session->unset_userdata('success_message');
	}
			
	$search = $this->session->userdata('projects_search');
	
	if(!empty($search))
	{
		$search_result = '<a href="'.site_url().'inventory/close-orders-search" class="btn btn-danger">Close Search</a>';
	}


	$result = '';
	
	//if users exist display them
	if ($query->num_rows() > 0)
	{
		$count = $page;
		
		$result .='';
		
					//get all administrators
					// $personnel_query = $this->personnel_model->get_all_personnel();
					// var_dump($query->num_rows()); die();
					foreach ($query->result() as $row)
					{
						$project_id = $row->project_id;
						$project_number = $row->project_number;
						$project_title = $row->project_title;
						$project_grant_value = $row->project_grant_value;
						$project_location = $row->project_location;
						$project_status = $row->project_status;
						$project_donor = $row->project_donor;
						$county_name = $row->county_name;
						$project_status = $row->project_status_id;
						$project_instructions = $row->project_instructions;
						$project_status_name = $row->project_status_name;
						$created_by = $row->created_by;
						$created = $row->created;
						$modified_by = $row->modified_by;
						$last_modified = $row->last_modified;
						$project_approval_status = $row->project_approval_status;
						$project_start_date = $row->project_start_date;
						$project_end_date = $row->project_end_date;

						$total_price = 0;
						$total_items = 0;
						$created_by = '-';
						if($project_status == 0)
						{
							$status = '<span class="label label-default">Deactivated</span>';
							$button = '<a  href="'.site_url().'tree-planting/activate-project-area/'.$project_id.'" onclick="return confirm(\'Do you want to activate '.$project_title.'?\');" title="Activate '.$project_title.'"><i class="fa fa-thumbs-up mr-xs"></i> Activate</a>';
						}
						//create activated status display
						else if($project_status == 1)
						{
							$status = '<span class="label label-success">Active</span>';
							$button = '<a  href="'.site_url().'tree-planting/deactivate-project-area/'.$project_id.'" onclick="return confirm(\'Do you want to deactivate '.$project_title.'?\');" title="Deactivate '.$project_title.'"><i class="fa fa-thumbs-down mr-xs"></i> Deactivate</a>';
						}
				
					
						$diff = abs(strtotime($project_start_date) - strtotime($project_end_date));

						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						// $button = '';

						$total_seedlings = 0;
						$total_communities = 0;
						
							$status = '<span class="label label-info"> Active </span>';
							$count++;
							$result .= 
							'
								<div class="col-md-4">
									<section class="panel ">
										<div class="panel-body panel-body-nopadding ">
											<div class="owl-carousel owl-theme mb-md owl-loaded owl-drag owl-carousel-init" data-plugin-carousel="" data-plugin-options="{ &quot;dots&quot;: true, &quot;items&quot;: 1 }">
											<div class="panel-heading-picture center-align">
												<img src="'.base_url().'assets/logo/'.$logo.'">
											</div>
											<div class="p-md">

												<h4 class="text-weight-semibold mt-none center-align" style="margin-bottom:7px;">'.$project_title.'</h4>
												<div class="col-md-12">
													<div class="col-md-6">
														<p>Donor <span class="pull-right label label-default" style="margin-top:4px;">'.$project_donor.'</span></p>
													</div>
													
												</div>
												<div class="col-md-12">
													<div class="col-md-12">
														<p> Grant County <span class="pull-right label label-default" style="margin-top:4px;">'.$county_name.'</span></p>
													</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-12">
														<p>Project Duration 
														<span class="pull-right label label-warning" style="margin-top:4px;">'.$years.' Years, '.$months.' Months '.$days.' Days</span></p>
													</div>
												</div>
												<hr>
												<div class="col-md-12">
													<div class="col-md-6">
														<p>Nurseries <span class="pull-right label label-default" style="margin-top:4px;">'.$total_communities.'</span></p>
													</div>
													<div class="col-md-6">
														<p> Areas Covered <span class="pull-right label label-default" style="margin-top:4px;">'.$total_communities.'</span></p>
													</div>
												</div>
												<div class="col-md-12">
													<div class="col-md-6">
														<p>CTN Seedlings<span class="pull-right label label-default" style="margin-top:4px;">'.$total_seedlings.'</span></p>
													</div>
													<div class="col-md-6">
														<p> Surviving Trees<span class="pull-right label label-default" style="margin-top:4px;">0/0</span></p>
													</div>
												</div>

												
												<div class="col-md-12" style="margin-bottom:7px;">
												<p>
													<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
														20% 
													</div>
												</p>
												</div>

												
											</div>
										</div>
										<div class="panel-footer panel-footer-btn-group" >
											<a href="'.site_url().'project-reports/'.$project_id.'" title="View '.$project_title.'" style="text-align:center;"><i class="fa fa-folder-open mr-xs"></i> View Report</a>
											

										</div>
									</section>
								</div>
							';
						// }
					}
		
			$result .= 
			'
			';
	}
	
	else
	{
		$result .= "There are no projects created";
	}
	$result .= '';
	
?>
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title"><?php echo $title;?></h2>
	</header>
	<?php echo $this->load->view('projects/dashboard_header','',true)?>
</section>
<div class="row">
	
	<?php echo $result;?>

	<div class="panel-foot">
        
		<?php if(isset($links)){echo $links;}?>
    
        <div class="clearfix"></div> 
    
    </div>

</div>

	