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

$order_number = '';
$order_status = '';
$order_instructions = '';
$order_status_name = '';
$created_by = '';
$created = '';
$modified_by = '';
$last_modified = '';
$created = '';

if($order_details->num_rows() > 0)
{
	$row = $order_details->row();
	$order_number = $row->order_number;
	$order_status = $row->order_status_id;
	$order_instructions = $row->order_instructions;
	$created_by = $row->created_by;
	$created = $row->created;
	$modified_by = $row->modified_by;
	$last_modified = $row->last_modified;
	$created = $row->created;
}

$result ='';
if($order_item_query->num_rows() > 0)
{
	$col = '';
	$message = '';
	$invoice_total = 0;
		
	$result .= 
	'
		<table class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Seedling Type Name</th>
					<th>Species Name</th>
					<th>Quantity</th>
					<th>Unit Price (KES)</th>
					<th>Total Price (KES) </th>
				</tr>
			</thead>
			<tbody>
			';
			$count = 0;
			$invoice_total = 0;
			foreach($order_item_query->result() as $res)
			{
				$order_id = $res->order_id;
				$seedling_type_name = $res->seedling_type_name;
				$species_name = $res->species_name;
				$order_item_quantity = $res->order_item_quantity;
				$order_item_id = $res->order_item_id;
				$order_item_price = $res->order_item_price;
				$total_price = $order_item_quantity * $order_item_price;
				$count++;

				$result .= '
						<tr>
							<td>'.$count.'</td>
							<td>'.$seedling_type_name.'</td>
							<td>'.$species_name.'</td>
							<td>'.$order_item_quantity.'</td>
							<td>'.$order_item_price.'</td>
							<td>'.number_format($total_price,2).'</td>
						</tr>';
				$invoice_total = $total_price + $invoice_total;
			}
			
			$result .= ' 
						<tr>
							<td colspan="4"></td>
							<td>TOTAL AMOUNT</td>
							<td>'.number_format($invoice_total,2).'</td>
						</tr>
						';
			
			$result .= '
				</tbody>
			</table>
			';
		}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PRINT LPO</title>
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
                        <th>LOCAL PURCHASE ORDER</th>
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
    		<p class="center-align" style="font-weight:bold;">Order Details</p>
    		<table class="table table-condensed">
            	<tr>
                	<th>L.P.O. NUMBER:</th>
                    <td class="bottom-border"><?php echo $order_number;?></td>
                	<th>DATE:</th>
                    <td class="bottom-border"><?php echo date('jS M Y',strtotime($created));?></td>
                </tr>
            	<tr>
                	<th>CONSTITUENCY:</th>
                    <td class="bottom-border"></td>
                	<th>SUB-LOCATION:</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
        </div>
        
    	<div class="col-md-12 receipt_bottom_border">
    		<p class="center-align" style="font-weight:bold;">Particulars</p>
    		<?php echo $result;?>
        </div>
        
    	<div class="col-md-12">
    		<table class="table table-condensed">
            	<tr>
                	<th>Created By:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Approved By:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
            
    		<p>If you have any questions about this invoice, please contact us through <?php echo $branch_phone;?></p>
        </div>
        
    	<div class="col-md-12">
    		<p class="center-align" style="font-style:italic; font-weight:bold;">Thank you for partnering with us</p>
        </div>
    	
    </body>
</html>