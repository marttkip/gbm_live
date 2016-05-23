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

$result ='';
if($query->num_rows() > 0)
{
	$col = '';
	$message = '';
	$invoice_total = 0;
		
	$result .= 
	'
		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th >#</th>
					<th>Date Given</th>
					<th>Staff Received</th>
					<th>Total Trees</th>
					<th>Fruit Trees</th>
					<th>Indigenous Trees</th>
					<th>Exotic Trees</th>
				</tr>
			</thead>
			<tbody>
			';
	$count = 0;
	$invoice_total = 0;
	foreach($query->result() as $row)
	{
		$receivable_id = $row->receivable_id;
		$quantity_given = $row->quantity_given;
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

		//creators & editors
		if($admins->num_rows() > 0)
		{
			foreach($admins->result() as $adm)
			{
				$user_id = $adm->personnel_id;
				
				if($user_id == $personnel_id)
				{
					$received_by = $adm->personnel_fname;
				}
				
			}
		}
		
		else
		{
				$received_by = '';
		}
		
		$count++;
		$result .= 
		'
			<tr>
				<td>'.$count.'</td>
				<td>'.date('jS M Y',strtotime($date_given)).'</td>
				<td>'.$received_by.'</td>
				<td>'.number_format($quantity_given, 0).'</td>
				<td>'.number_format($fruit_trees, 0).'</td>
				<td>'.number_format($indegenous_trees, 0).'</td>
				<td>'.number_format($exotic_trees, 0).'</td>
			</tr> 
		';
	}
	
	$result .= '
		</tbody>
	</table>
	';
}

$community_group_address = '';
$community_group_name = '';

if($community_group_query->num_rows() > 0)
{
	$row = $community_group_query->row();
	$community_group_address = $row->address.' '.$row->location;
	$community_group_name = $row->community_group_name;
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
        </style>
    </head>
    <body class="receipt_spacing" onLoad="window.print();return false;">
    	<div class="col-md-12 receipt_bottom_border">
    		<table class="table table-condensed">
            	<thead>
                    <tr>
                        <th>FORM IX (9)<br/>TREES ISSUED FORM</th>
                        <th class="align-right">
                            <?php echo $branch_name;?><br/>
                            <?php echo $branch_address;?> <?php echo $branch_post_code;?> <?php echo $branch_city;?><br/>
                            E-mail: <?php echo $branch_email;?><br/>
                            Tel : <?php echo $branch_phone;?><br/>
                            <?php echo $branch_location;?><br/>
                            Tel : <?php echo $branch_phone;?>
                        </th>
                        <th>
                            <img src="<?php echo base_url().'assets/logo/'.$branch_image_name;?>" alt="<?php echo $branch_name;?>" class="img-responsive logo"/>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        
    	<div class="col-md-12 receipt_bottom_border">
    		<table class="table table-condensed">
            	<tr>
                	<th>Your Address:</th>
                    <td class="bottom-border"><?php echo $community_group_address?></td>
                	<th>Date:</th>
                    <td class="bottom-border"><?php echo date('jS M Y',strtotime(date('Y-m-d')));?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Name of seedling nursery bed:</th>
                    <td class="bottom-border"><?php echo $community_group_name?></td>
                </tr>
            </table>
            
    		<p class="center-align" style="font-weight:bold;">Particulars</p>
    		<?php echo $result;?>
        </div>
        
    	<div class="col-md-12">
    		<table class="table table-condensed">
            	<tr>
                	<td>
                    	<p>This form was filled and verified by</p>
                        <table class="table table-condensed">
                        	<tr>
                                <th>Chairman:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Secretary:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Treasurer:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Caretaker:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        </table>
                    </td>
                	<td>
                    	<p>Meeting date when form was filled and verified</p>
                        <table class="table table-condensed">
                        	<tr>
                                <th>First Meeting:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Second Meeting:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Third Meeting:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        	<tr>
                                <th>Fourth Meeting:</th>
                                <td class="bottom-border"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        
    	<div class="col-md-12">
    		<p class="center-align" style="font-style:italic; font-weight:bold;">Thank you for partnering with us</p>
        </div>
    	
    </body>
</html>