<?php
if($branch_data->num_rows()>0)
{
	$branch_details = $branch_data->result();
	foreach($branch_details as $rows)
	{
		$branch_name = $rows->branch_name;
		$branch_address = $rows->branch_address;
		$branch_post_code = $rows->branch_post_code;
		$branch_city = $rows->branch_city;
		$branch_email = $rows->branch_email;
		$branch_phone = $rows->branch_phone;
		$branch_location = $rows->branch_location;
		$branch_image_name = $rows->branch_image_name;
	}
}

$result = '';

//if community_group_members exist display them
if ($query->num_rows() > 0)
{
	$count = 0;
	
	$result .= 
	'
	<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
                <th>Gender</th>
				<th>National Id</th>
				<th>Phone Number</th>
                <th>Amount Paid</th>
			</tr>
		</thead>
		  <tbody>
	';
	foreach ($query->result() as $row)
	{
		$cpm_id = $row->cpm_id;
		$cpm_name = $row->cpm_name;
        $project_id = $row->project_id;
         $cp_activitytitle = $row->cp_activitytitle;
         $county_name = $row->county_name;
         $project_donor = $row->project_donor;
         $payment_date = $row->cp_payment_date;
         $project_description = $row->cp_reason;
         $cpm_gender = $row->cpm_gender;
         if($cpm_gender == 1)
         {
            $gender = 'Male';
         }
         else
         {
            $gender = 'Female';
         }
		//create deactivated status display
        // $project_details = $this->planting_sites_model->get_project_details($project_id);
        // $rs_project = $project_details->result();
        // $project_donor = $rs_project[0]->project_donor;

		$count++;
		$result .= 
		'
			<tr>
				<td>'.$count.'</td>
				<td>'.$row->cpm_name.' </td>
                <td>'.$gender.'</td>
				<td>'.$row->cpm_national_id.' </td>
				<td>'.$row->cpm_phone.' </td>
                <td>'.$row->cpm_amount.' </td>
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
	$result .= "There are no participants";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Attendees</title>
        <!-- For mobile content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- IE Support -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/stylesheets/theme-custom.css">
		<style type="text/css">
            .receipt_spacing{letter-spacing:0px; font-size: 12px;}
            .center-align{margin:0 auto; text-align:center;}
            
            .receipt_bottom_border{border-bottom: #888888 medium solid; margin-bottom:20px;}
            .row .col-md-12 table {
                border:solid #000 !important;
                border-width:1px 0 0 1px !important;
                font-size:10px;
            }
            .row .col-md-12 th, .row .col-md-12 td {
                border:solid #000 !important;
                border-width:0 1px 1px 0 !important;
            }
            
            .row .col-md-12 .title-item{float:left;width: 130px; font-weight:bold; text-align:right; padding-right: 20px;}
            .title-img{float:left; padding-left:30px;}
            img.logo{max-height:70px; margin:0 auto;}
            .align-right{text-align: right !important;}
            .align-left{text-align: left !important;}
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{border-top:none;}
			td.bottom-border{border-bottom:1px solid #d8d8d8; width:70%;}
        </style>
    </head>
    <body class="receipt_spacing" onLoad="window.print();return false;">
    	<div class="col-md-12 center-align receipt_bottom_border">
    		<table class="table table-condensed">
                <tr>
                    <th>CASUAL PAYMENT FORM</th>
                    <th class="align-right">
						<?php echo $branch_name;?><br/>
                        <?php echo $branch_address;?> <?php echo $branch_post_code;?> <?php echo $branch_city;?><br/>
                        E-mail: <?php echo $branch_email;?><br/>
                        Tel : <?php echo $branch_phone;?><br/>
                        <?php echo $branch_location;?>
                    </th>
                    <th>
                        <img src="<?php echo base_url().'assets/logo/'.$branch_image_name;?>" alt="<?php echo $branch_name;?>" class="img-responsive logo"/>
                    </th>
                </tr>
            </table>
        </div>
        
    	<div class="col-md-12 receipt_bottom_border">
    		<table class="table table-condensed">
                <tr>
                    <td class="align-left">
                        <strong>Grant Name: </strong> <?php echo $project_donor;?><br>
                        <strong>Activity Title: </strong> <?php echo $cp_activitytitle;?><br>
                        <strong>Grant County: </strong> <?php echo $county_name;?><br>
                    </td>
                    <td class="align-right">
                        <strong>Payment Date: </strong> <?php echo date('jS M Y',strtotime(date($payment_date)));?><br>
                        <strong>Reason for paying: </strong> <?php echo $project_description;?><br>
					</td>
                </tr>
        	</table>
        </div>
       	<div class="col-md-12 receipt_bottom_border">
			<?php echo $result;?>
        </div>
        
        <div class="col-md-12">
        	<table class="table table-condensed">
            	<tr>
                	<th class="align-right">Staff Name</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th class="align-right">Date</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th class="align-right">Signature</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
        </div>
    </body>
</html>