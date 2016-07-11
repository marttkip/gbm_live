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


$count = 0;
$result = 
	'<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th colspan="6"></th>
				<th colspan="2">WATER HARVESTING</th>
				<th colspan="3">AGROFORESTRY TREES</th>
				<th colspan="3">SOIL CONSERVATION</th>
				<th colspan="2">KITCHEN GARDENING</th>
				<th colspan="2">TRENCH ARROW ROOTS</th>
				<th colspan="1">COMPOST MANURE</th>
			</tr>
			<tr>
				<th>#</th>
				<th>Farmer Name</th>
				<th>Phone</th>
				<th>GPS CODE</th>

				<th>Eastings</th>
				<th>Northings</th>
				<th>Type</th>

				<th>Capacity</th>
				<th>Type</th>
				<th>Spacing</th>

				<th>Quantity</th>
				<th>Type</th>
				<th>Benches</th>

				<th>Quantity</th>
				<th>Name</th>
				<th>Variety</th>

				<th>Quantity</th>
				<th>Trench Length</th>
				<th>Type</th>

			</tr>
				';
				if($food_security_query->num_rows()>0)
				{
					$row = $food_security_query->result();
					foreach($row as $key)
					{

						$farmer_name = $key->name;
						$phone = $key->phone;
						$gps = $key->gps;
						$eastings = $key->eastings;
						$northings = $key->northings;
						
						$r_type = $key->r_type;
						$r_distance = $key->r_dist;
						$r_quantity = $key->r_quantity;

						$ag_type = $key->ag_type;
						$ag_spacing = $key->ag_spacing;
						$ag_quantity = $key->ag_quantity;

						$sc_type = $key->sc_type;
						$sc_spacing = $key->sc_spacing;
						$sc_quantity = $key->sc_quantity;
						$sc_rows = $key->sc_row;
						
						$c_quantity = $key->c_quantity;
						
						$g_quantity = $key->g_quantity;
						$g_rows = $key->g_rows;
						$g_spacing = $key->g_spacing;
						
						$cm_type = $key->cm_type;

						$cc_type = $key->cm_type;
						$cc_quantity = $key->cc_quantity;
						$cc_rows = $key->cc_rows;
						$cc_spacing = $key->cc_spacing;
						$wh_type = $key->wh_type;


						$wh_capacity = $key->wh_capacity;
						$kg_name = $key->kg_name;
						$kg_variety = $key->kg_variety;
						$cm_type = $key->cm_type;
						$ta_quantity = $key->ta_quantity;
						$ta_length = $key->ta_length;
						$sc_bench = $key->sc_bench;

						$count++;
						$result .=
								'<tr>
									<td>'.$count.'</td>
									<td>'.$farmer_name.'</td>
									<td>'.$phone.'</td>
									<td>'.$gps.'</td>

									<td>'.$eastings.'</td>
									<td>'.$northings.'</td>
									<td>'.$wh_type.'</td>
									<td>'.$wh_capacity.'</td>

									<td>'.$ag_type.'</td>
									<td>'.$ag_spacing.'</td>
									<td>'.$ag_quantity.'</td>

									<td>'.$sc_type.'</td>
									<td>'.$sc_bench.'</td>
									<td>'.$sc_quantity.'</td>

									<td>'.$kg_name.'</td>
									<td>'.$kg_variety.'</td>
									<td>'.$cm_type.'</td>
									<td>'.$ta_quantity.'</td>
									<td>'.$ta_length.'</td>
								</tr>
								';
					}
					
					
				}
$result .= 
	'
	</table>
	';
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
                    <th>GBM FOOD SECURITY INITIATIVES FORM</th>
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
                    <td class="center-align">
                        <strong>Constituency Name: </strong> Kibera Constituency
                        <strong>Ward: </strong> Upper Kibera
                        <strong>Catchment: </strong> Kibera River
                    </td>
                </tr>
        	</table>
        </div>
       	<div class="col-md-12 receipt_bottom_border">
			<?php echo $result;?>
        </div>
        
        <table class="table table-condensed">
        	<tr>
        		<td>
		        	<table class="table table-condensed">
		            	<tr>
		                	<th class="align-right">MAPPED BY</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            	<tr>
		                	<th class="align-right">DATE</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            	<tr>
		                	<th class="align-right">SIGNATURE</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            </table>
		        </td>
		        <td>
		        	<table class="table table-condensed">
		            	<tr>
		                	<th class="align-right">RECEIVED BY</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            	<tr>
		                	<th class="align-right">DATE</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            	<tr>
		                	<th class="align-right">SIGNATURE</th>
		                    <td class="bottom-border"></td>
		                </tr>
		            </table>
		         </td>
		        </tr>
        </table>
    </body>
</html>