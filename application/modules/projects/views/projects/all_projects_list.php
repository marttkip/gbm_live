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
		
		$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Project Title</th>
						<th>Created By</th>
						<th>Status</th>
						<th colspan="3">Actions</th>
					</tr>
				</thead>
				
				<tbody>
			';
		
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
						$project_status = $row->project_status;
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
							$button = '<a class="btn btn-sm btn-info" href="'.site_url().'gbm/projects/activate-project/'.$project_id.'" onclick="return confirm(\'Do you want to activate '.$project_title.'?\');" title="Activate '.$project_title.'"><i class="fa fa-thumbs-up mr-xs"></i></a>';
						}
						//create activated status display
						else if($project_status == 1)
						{
							$status = '<span class="label label-success">Active</span>';
							$button = '<a class="btn btn-sm btn-warning" href="'.site_url().'gbm/projects/deactivate-project/'.$project_id.'" onclick="return confirm(\'Do you want to deactivate '.$project_title.'?\');" title="Deactivate '.$project_title.'"><i class="fa fa-thumbs-down mr-xs"></i></a>';
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
								<tr>
									<td>'.$count.'</td>
									<td>'.$project_title.'</td>
									<td>'.$created_by.'</td>
									<td>'.$status.'</td>
									<td><a href="'.site_url().'gbm_administration/project-edit/'.$project_id.'" class="btn btn-sm btn-success" title="Edit '.$project_title.'"><i class="fa fa-pencil"></i></a></td>
									<td>'.$button.'</td>
									<td>
									<a href="'.site_url().'gbm_administration/delete-project/'.$project_id.'" class="btn btn-sm btn-danger"  onclick="return confirm(\'Do you really want to delete '.$project_title.'?\');" title="Delete '.$project_title.'"><i class="fa fa-trash mr-xs"></i> </a>

									</td>
									
								</tr> 
							';
						// }
					}
		
			$result .= 
			'
						  </tbody>
						</table>
			';
	}
	
	else
	{
		$result .= "There are no projects created";
	}
	$result .= '';
	
?>

<div class="row">
<div class="modal fade" id="upload_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Projects</h4>
			</div>
			<div class="modal-body">  

		        <!-- Widget content -->
				<div class="panel-body">
		        <div class="padd">
		            
		        <div class="row">
		        <div class="col-md-12">
				<?php
				$error = $this->session->userdata('error_message');
				$success = $this->session->userdata('success_message');
				
				if(!empty($error))
				{
					echo '<div class="alert alert-danger">'.$error.'</div>';
					$this->session->unset_userdata('error_message');
				}
				
				if(!empty($success))
				{
					echo '<div class="alert alert-success">'.$success.'</div>';
					$this->session->unset_userdata('success_message');
				}
				?>
		            <?php
		                if(isset($import_response))
		                {
		                    if(!empty($import_response))
		                    {
		                        echo $import_response;
		                    }
		                }
		                
		                if(isset($import_response_error))
		                {
		                    if(!empty($import_response_error))
		                    {
		                        echo '<div class="center-align alert alert-danger">'.$import_response_error.'</div>';
		                    }
		                }
		            ?>
		                
		            
		            <?php echo form_open_multipart('import/import-projects', array("class" => "form-horizontal", "role" => "form"));?>
		            
		            <div class="row">
		                <div class="col-md-12">
		                    <ul>
		                        <li>Download the import template <a href="<?php echo site_url().'import/projects-template';?>" target= "_blank">here.</a></li>
		                        
		                        <li>Save your file as a <strong>CSV (Comma Delimited)</strong> file before importing</li>
		                        <li>After adding your projects to the import template please import them using the button below</li>
		                    </ul>
		                </div>
		            </div>
		            
		            <div class="row">
						<div class="col-md-12" style="margin-top:10px">
							<div class="fileUpload btn btn-primary">
		                        <span>Import Projects</span>
		                        <input type="file" class="upload" onChange="this.form.submit();" name="import_csv" />
		                    </div>
						</div>
		            </div>
		                   
		                    
		        </div>
		        </div>
		            <?php echo form_close();?>
				</div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
		</div>
	</div>
</div>
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title"><?php echo $title;?></h2>
			<a href="<?php echo site_url();?>gbm-administration/add-project" class="btn btn-success btn-sm pull-right" style="margin-top:-25px;">Add Project</a>
		 <a data-toggle="modal" data-target="#upload_project" class="btn btn-warning btn-sm pull-right" style="margin-top:-25px; margin-right:5px;">Import Projects</a>
		</header>
		<div class="panel-body">
			<div class="row" style="margin-bottom:20px;">
    			<div class="col-lg-12 col-sm-12 col-md-12">
    				<div class="padd">
					<!-- end add request event -->
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
					
						<?php echo $result;?>
					</div>
				</div>
			</div>

			<div class="panel-foot">
		        
				<?php if(isset($links)){echo $links;}?>
		    
		        <div class="clearfix"></div> 
		    
		    </div>
		</div>
	</section>

</div>