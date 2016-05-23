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

$community_group_address = $community_group_address = $community_group_name = $registration_date = $sub_location = $quantity_given = $created_by = $personnel_id = $created = $driver_name = $driver_national_id = $mobile_no = $date_given = $fruit_trees = $indegenous_trees = $exotic_trees = $community_group_id = $chief = $sub_chief = $driver_name = $driver_national_id = $mobile_no = $vehicle_number_plate = $personnel_fname = $project_donor = $chair_name = $chair_national_id = $chair_phone = $secretary_name = $secretary_national_id = $secretary_phone = $treasurer_name = $treasurer_national_id = $treasurer_phone = '';

if($query->num_rows() > 0)
{
	$row = $query->row();
	$community_group_address = $row->address.' '.$row->location;
	$community_group_name = $row->community_group_name;
	$registration_date = $row->created;
	$sub_location = $quantity_given = $row->quantity_given;
	$created_by = $row->created_by;
	$personnel_id = $row->personnel_id;
	$created = $row->created;
	$driver_name = $row->driver_name;
	$driver_national_id = $row->driver_national_id;
	$mobile_no = $row->mobile_no;
	$date_given = $row->date_given;
	$fruit_trees = $row->fruit_trees;
	$indegenous_trees = $row->indegenous_trees;
	$exotic_trees = $row->exotic_trees;
	$community_group_id = $row->community_group_id;
	$chief = $row->chief;
	$sub_chief = $row->sub_chief;
	$driver_name = $row->driver_name;
	$driver_national_id = $row->driver_national_id;
	$mobile_no = $row->mobile_no;
	$vehicle_number_plate = $row->vehicle_number_plate;
	$personnel_fname = $row->personnel_fname.' '.$row->personnel_onames;
	$project_donor = $row->project_donor;
	
	if(empty($chief))
	{
		$chief = $sub_chief;
	}
	$chief = $row->chief;
	
	if($community_group_id > 0)
	{
		$member_query = $this->orders_model->get_community_group_members($community_group_id);
		
		if($member_query->num_rows() > 0)
		{
			$community_group_member_name = $row->community_group_member_name;
			$community_group_member_national_id = $row->community_group_member_national_id;
			$community_group_member_phone_number = $row->community_group_member_phone_number;
			$member_type_id = $row->member_type_id;
			
			if($member_type_id == 1)
			{
				$chair_name = $community_group_member_name;
				$chair_national_id = $community_group_member_national_id;
				$chair_phone = $community_group_member_phone_number;
			}
			
			else if($member_type_id == 2)
			{
				$secretary_name = $community_group_member_name;
				$secretary_national_id = $community_group_member_national_id;
				$secretary_phone = $community_group_member_phone_number;
			}
			
			else if($member_type_id == 3)
			{
				$treasurer_name = $community_group_member_name;
				$treasurer_national_id = $community_group_member_national_id;
				$treasurer_phone = $community_group_member_phone_number;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PRINT FORM 9</title>
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
			td.bottom-border{border-bottom:1px solid #d8d8d8;}
			.table > tbody > tr > th{width:25%;}
			.table > thead > tr > th {vertical-align: top;}
			.empty{color:#ffffff; min-height:20px;}
			.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td{padding: 2px 5px;}
        </style>
    </head>
    <body class="receipt_spacing" onLoad="window.print();return false;">
    	<div class="col-md-12 receipt_bottom_border">
    		<table class="table table-condensed">
            	<thead>
                    <tr>
                        <th>TNG - SEEDLING COLLECTION FORM</th>
                        <th class="align-right">
                            <?php echo $branch_name;?><br/>
                            <?php echo $branch_address;?> <?php echo $branch_post_code;?> <?php echo $branch_city;?><br/>
                            E-mail: <?php echo $branch_email;?><br/>
                            Tel : <?php echo $branch_phone;?><br/>
                            <?php echo $branch_location;?><br/>
                        </th>
                        <th>
                            <img src="<?php echo base_url().'assets/logo/'.$branch_image_name;?>" alt="<?php echo $branch_name;?>" class="img-responsive logo"/>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        
    	<div class="col-md-12">
    		<table class="table table-condensed">
            	<tr>
                	<th>TNG Name:</th>
                    <td class="bottom-border"><?php echo $community_group_name;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<td>
                    	<table class="table table-condensed">
                        	<tr>
                            	<th>Reg. No.:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Date Registered:</th>
                                <td class="bottom-border"><?php echo date('jS M Y',strtotime($registration_date));?></td>
                            </tr>
                        </table>
                    </td>
                    
                	<td>
                    	<table class="table table-condensed">
                        	<tr>
                                <th>Certificate No.:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Sub-Location:</th>
                                <td class="bottom-border"><?php echo $sub_location;?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
    		<table class="table table-condensed table-bordered">
            	<tr>
                	<td>
                        <table class="table table-condensed">
                        	<tr>
                                <th colspan="3" class="center-align">TNG SEEDLING DETAILS</th>
                            </tr>
                        	<tr>
                                <th>Date of Collection:</th>
                                <td colspan="2"><?php echo date('jS M Y',strtotime($date_given));?></td>
                            </tr>
                        	<tr>
                                <th colspan="3">NUMBER OF SEEDLINGS:</th>
                            </tr>
                        	<tr>
                                <th>INDIG:</th>
                                <th>EXT:</th>
                                <th>FRUITS:</th>
                            </tr>
                        	<tr>
                                <td><?php echo $indegenous_trees;?></td>
                                <td><?php echo $exotic_trees;?></td>
                                <td><?php echo $fruit_trees;?></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">TNG CHAIR DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $chair_name;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"><?php echo $chair_national_id;?></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"><?php echo $chair_phone;?></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">TNG SECRETARY DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $secretary_name;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"><?php echo $secretary_national_id;?></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"><?php echo $secretary_phone;?></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">TNG TREASURER DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $treasurer_name;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"><?php echo $treasurer_national_id;?></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"><?php echo $treasurer_phone;?></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        </table>
                    </td>
                	<td>
                        <table class="table table-condensed">
                        	<tr>
                                <th colspan="3" class="center-align">AREA CHIEF'S/ ASST. CHIEF'S DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $chief;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"></td>
                            </tr>
                        	<tr>
                                <th colspan="3">NUMBER OF SEEDLINGS RECEIVED:</th>
                            </tr>
                        	<tr>
                                <th>INDIG:</th>
                                <th>EXT:</th>
                                <th>FRUITS:</th>
                            </tr>
                        	<tr>
                                <td><?php echo $indegenous_trees;?></td>
                                <td><?php echo $exotic_trees;?></td>
                                <td><?php echo $fruit_trees;?></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">TRANSPORTER DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $driver_name;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"><?php echo $driver_national_id;?></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"><?php echo $mobile_no;?></td>
                            </tr>
                        	<tr>
                                <th>Vehicle Reg. No.:</th>
                                <td colspan="2"><?php echo $vehicle_number_plate;?></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">EXTENSION/ PROJECT OFFICER DETAILS</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"><?php echo $personnel_fname;?></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"><?php echo $project_donor;?></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        	<tr>
                                <th colspan="3" class="center-align">SENIOR PROJECT OFFICER APPROVAL</th>
                            </tr>
                        	<tr>
                                <th>NAME:</th>
                                <td colspan="2"></td>
                            </tr>
                        	<tr>
                                <th>NATIONAL ID:</th>
                                <td colspan="2"></td>
                            </tr>
                        	<tr>
                                <th>MOBILE NO.:</th>
                                <td colspan="2"></td>
                            </tr>
                        	<tr>
                                <th>DATE:</th>
                                <th colspan="2">SIGNATURE:</th>
                            </tr>
                        	<tr>
                                <td class="empty"><br/></td>
                                <td class="empty" colspan="2"><br/></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    	
    </body>
</html>