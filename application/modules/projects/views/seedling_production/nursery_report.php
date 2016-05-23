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
if($nursery_info->num_rows()>0)
{
	$nursery = $nursery_info->result();
	foreach($nursery as $nurserys)
	{
		$nursery_name = $nurserys->nursery_name;
	}
}
if($community_group_info->num_rows()>0)
{
	$community_group = $community_group_info->result();
	foreach($community_group as $community_groups)
	{
		$community_group_name = $community_groups->community_group_name;
		$address = $community_groups->address;
		$location = $community_groups->location;
		$sub_location = $community_groups->sub_location;
		$account_number =$community_groups->account_number;
	}
}

$seedlings_rs = $this->seedling_production_model->get_months_seedling_tally($month,$year,$seedling_product_id);
$ready = 0;
$not_ready = 0;
$bags = 0;

$indeginous_not_ready = 0;
$fruits_not_ready = 0;
$exotic_not_ready = 0;
$total_not_ready = 0;
$indeginous_ready = 0;
$fruits_ready = 0;
$exotic_ready = 0;
$total_ready = 0;
$fruits_bags = 0;
$exotic_bags = 0;
$indeginous_bags = 0;
$total_bags = 0;
if($seedlings_rs->num_rows() > 0)
{   

    foreach ($seedlings_rs->result() as $key_value) {
        # code...
        $other_id = $key_value->nursery_tally_id;
        $checked_id = $key_value->seedling_status_id;
        

        if($checked_id == 1)
        {
            $ready = $key_value->quantity;
			$seedling_type_id = $key_value->seedling_type_id;
			 if($seedling_type_id == 2)
            {
                $indeginous_ready = $ready;
            }
            else if($seedling_type_id == 3)
            {
                $exotic_ready = $ready;
            }
            else if($seedling_type_id == 1)
            {
                $fruits_ready = $ready;
            }
            $total_ready = $indeginous_ready+$exotic_ready+$fruits_ready;
        }
        else if($checked_id == 2)
        {
            $not_ready = $key_value->quantity;
            $seedling_type_id = $key_value->seedling_type_id;
            // find the numbers for each seedling type
            if($seedling_type_id == 2)
            {
                $indeginous_not_ready = $not_ready;
            }
            else if($seedling_type_id == 3)
            {
                $exotic_not_ready = $not_ready;
            }
            else if($seedling_type_id == 1)
            {
                $fruits_not_ready = $not_ready;
            }
            $total_not_ready = $indeginous_not_ready+$exotic_not_ready+$fruits_not_ready;
        }

        else
        {
            $bags = $key_value->quantity;
			$seedling_type_id = $key_value->seedling_type_id;
			if($seedling_type_id == 2)
            {
                $indeginous_bags = $bags;
            }
            else if($seedling_type_id == 3)
            {
                $exotic_bags = $bags;
            }
            else if($seedling_type_id == 1)
            {
                $fruits_bags = $bags;
            }
            $total_bags = $indeginous_bags+$exotic_bags+$fruits_bags;

        }



        


    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>NURSERY REPORT</title>
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
                        <th>
                            FORM V(5)<br/>
                            NURSERY REPORT
                        </th>
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
                    <td class="align-left">
                        <strong>ADDRESS: </strong> <?php echo $address;?><br>
                    </td>
                    <td class="align-right">
                        <strong>DATE: </strong> <?php echo date('jS M Y',strtotime(date('Y-m-d')));?>
					</td>
                </tr>
        	</table>
        </div>
        
    	<div class="col-md-12 receipt_bottom_border">
    		<table class="table table-condensed">
                <tr>
                    <th>To The Chair Person</th>
                    <td class="bottom-border"></td>
                </tr>
                <tr>
                    <th>1. Nursery Name</th>
                    <td class="bottom-border"><?php echo $nursery_name;?></td>
                </tr>
                <tr>
                    <th>2. Report For the month of</th>
                    <td class="bottom-border"></td>
                </tr>
        	</table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Sub-location:</th>
                    <td class="bottom-border"><?php echo $sub_location;?></td>
                	<th>Location:</th>
                    <td class="bottom-border"><?php echo $location;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>3. You must keep a record of the seedlings in your nursery.You can be asked to show them at any time. Failure to keep proper records, may cause the work of nursery facilitators and other workers to discontinue or come to a complete halt.Please submit your monthly nursery records for your seedlings at the end of every month using this form(Form V)</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>4. Please arrange the seedlings in the potting-bags according to the different species and provide the following information:</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(i) Number of total potting bags in the nursery:</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(a) Indigenous species:</th>
                    <td class="bottom-border"><?php echo $indeginous_bags;?></td>
                	<th>(b) Fruits:</th>
                    <td class="bottom-border"><?php echo $fruits_bags;?></td>
                </tr>
            	<tr>
                	<th>c) Foreign Species:</th>
                    <td class="bottom-border"><?php echo $exotic_bags;?></td>
                	<th>(d) Total(all inclusive):</th>
                    <td class="bottom-border"><?php echo $total_bags;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(ii) Seedlings ready for planting</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(a) Indigenous species:</th>
                    <td class="bottom-border"><?php echo $indeginous_ready;?></td>
                	<th>(b) Fruits:</th>
                    <td class="bottom-border"><?php echo $fruits_ready;?></td>
                </tr>
            	<tr>
                	<th>c) Foreign Species:</th>
                    <td class="bottom-border"><?php echo $exotic_ready;?></td>
                	<th>(d) Total(all inclusive):</th>
                    <td class="bottom-border"><?php echo $total_ready;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(iii) Seedlings NOT ready for planting</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>(a) Indigenous species:</th>
                    <td class="bottom-border"><?php echo $indeginous_not_ready;?></td>
                	<th>(b) Fruits:</th>
                    <td class="bottom-border"><?php echo $fruits_not_ready;?></td>
                </tr>
            	<tr>
                	<th>c) Foreign Species:</th>
                    <td class="bottom-border"><?php echo $exotic_not_ready;?></td>
                	<th>(d) Total(all inclusive):</th>
                    <td class="bottom-border"><?php echo $total_not_ready;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
                <tr>
                    <th>5. Are there seedlings that are still in the seedling bed?:</th>
                    <td class="bottom-border"></td>
                </tr>
                <tr>
                    <th>If yes, aproximately how many?</th>
                    <td class="bottom-border"></td>
                </tr>
                <tr>
                    <th colspan="2">Please ensure that your seedlings are put in potting bags. Your nursery can get the potting-bags but before they arrive, ensure that the seeedlingsa reput in bags such as milk packets, plastic bottles, etc. Try to use the bags as much as possible by removing the seedlings as carefully as possible to prevent damage.Most do that.</th>
                </tr>
                <tr>
                    <th colspan="2">6. Members of the different community nursery groups should know that the nursery is theirs and:</th>
                </tr>
                <tr>
                    <th colspan="2">a) They should prepare the land for the seedling nursery</th>
                </tr>
                <tr>
                    <th colspan="2">b) They should look for the seeds</th>
                </tr>
                <tr>
                    <th colspan="2">c) They should plant the seeds and put the seedlings in bags</th>
                </tr>
                <tr>
                    <th colspan="2">d) They should prepare the land for the seedling nursery</th>
                </tr>
                <tr>
                    <th colspan="2">e) They should hold monitor the nursery attendants</th>
                </tr>
                <tr>
                    <th colspan="2">f) They should ensure that the those planting the trees look at the holes and follow up on the trees</th>
                </tr>
                <tr>
                    <th colspan="2">g) They should ensure that the nursery attendants assist them and guide them</th>
                </tr>
                <tr>
                    <th colspan="2">h) They should prepare the land for the seedling nursery</th>
                </tr>
                <tr>
                    <th colspan="2">i) They should pay their workers like road workers</th>
                </tr>
                <tr>
                    <th colspan="2">j) The attendants and the members of the group help each other</th>
                </tr>
                <tr>
                    <th colspan="2">7. Have you started a plan to plant trees? If yes, use form VI(6). If you have not recieved the form(VI), make yours by writing the names of those who accepted and those who are willing to dig the holes.</th>
                </tr>
        	</table>
    		<table class="table table-condensed">
            	<tr>
                	<th>8. Have you many holes have been dug and verified for the month of</th>
                    <td class="bottom-border"><?php echo $indeginous_not_ready;?></td>
                	<th>Holes:</th>
                    <td class="bottom-border"><?php echo $fruits_not_ready;?></td>
                </tr>
        	</table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Have you sent the form VIII(8)?</th>
                    <td class="bottom-border"><?php echo $exotic_not_ready;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>9. All the money wll be depoited to your account. Please provide the details below. Account Number:</th>
                    <td class="bottom-border"><?php echo $account_number;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Signatory 1 Name:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Signatory 2 Name:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Signatory 3 Name:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Signatory 4 Name:</th>
                    <td class="bottom-border"></td>
                	<th>Signature:</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>10. How should your cheque be issued?</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>11. How many seedlings have been issued out in the month of</th>
                    <td class="bottom-border"><?php echo $month;?></td>
                	<th>The number of seedlings issued is?</th>
                    <td class="bottom-border"></td>
                </tr>
        	</table>
    		<table class="table table-condensed">
            	<tr>
                	<th>12. What is the name of the facilitator in your area?</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>How many times times have they visited this month?</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Date of First Visit</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Date of Second Visit</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Date of Third Visit</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>Date of Fourth Visit</th>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th colspan="2">13. Write the names of the seedlings in your nursery. Fill in the names you know, the ones you don't are not a must.</th>
                </tr>
            </table>
            <table class="table table-bordered table-condensed">
                <thead>
                     <tr>
                         <th></th>
                         <th>Local Language</th>
                         <th>English Name</th>
                         <th>Kiswahili name</th>
                         <th>Scientific Name</th>
                     </tr>
                 </thead>
                 <tr>
                     <td>(i)</td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                 </tr>
                 <tr>
                     <td>(ii)</td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                 </tr>
                 <tr>
                     <td>(iii)</td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                 </tr>
                 <tr>
                     <td>(iv)</td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                 </tr>
                 <tr>
                     <td>(v)</td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                     <td class="bottom-border"></td>
                 </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>Total number of species:</th>
                    <td class="bottom-border"></td>
                </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>14. Please give us any comments or feedback that you may have.</th>
                </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <td class="bottom-border"></td>
                </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>15. We send you this information from our office.</th>
                </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>16. We thank you for all your wotk in restoring the country to its former state and saving our precious country. May you be blessed for all you hard work. Strive as hard as you can.</th>
                </tr>
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>Yours sincerely</th>
                </tr>
            </table>
        </div>
    </body>
</html>