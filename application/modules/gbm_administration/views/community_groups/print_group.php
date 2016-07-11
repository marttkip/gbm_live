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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Community Group Details</title>
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
                        <th>COMMUNITY GROUP REGISTRATION FORM</th>
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
                	<th>{1} Group Name:</th>
                    <td class="bottom-border" colspan="3"><?php echo $community_group_name;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>{2} Address:</th>
                    <td class="bottom-border"><?php echo $address;?></td>
                	<th>Phone/Fax:</th>
                    <td class="bottom-border"><?php echo $community_group_contact_person_phone1;?></td>
                </tr>
            	<tr>
                	<th>Sub-location:</th>
                    <td class="bottom-border"><?php echo $sub_location;?></td>
                	<th>Location:</th>
                    <td class="bottom-border"><?php echo $location;?></td>
                </tr>
                <tr>
                    <th>Division:</th>
                    <td class="bottom-border"><?php echo $division;?></td>
                    <th>District:</th>
                    <td class="bottom-border"><?php echo $district;?></td>
                </tr>
            	
                
            </table>
            <table class="table table-condensed">
                <tr>
                    <th>Market :</th>
                    <td class="bottom-border"><?php echo $market;?></td>
                </tr>
            </table>
             <table class="table table-condensed">
                <tr>
                    <th>Sub-Chief Name:</th>
                    <td class="bottom-border"><?php echo $sub_chief;?></td>
                    <th>Chief Name:</th>
                    <td class="bottom-border"><?php echo $chief;?></td>
                </tr>
             </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Your MP is:</th>
                    <td class="bottom-border"><?php echo $mp;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>{3} Name of Nearby GBM group:</th>
                </tr>
                <tr>
                    <td class="bottom-border"><?php echo $community_group_name;?></td>
                </tr>
            	<tr>
                	<th>{4} Group Contact Person:</th>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Contact Pesron Name:</th>
                    <td class="bottom-border"><?php echo $community_group_contact_person_name;?></td>
                	<th>Position:</th>
                    <td class="bottom-border"><?php echo $contact_person_position;?></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>{5} Current Activities the group is currently participating in:</th>
                </tr>
                <tr>
                    <td class="bottom-border"><?php echo $now_activities;?></td>
                </tr>
            	<tr>
                	<th>{6} Reasons for joining GBM:</th>
                </tr>
                <tr>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>{7} Explain some of the activities that the group will be facilitating:</th>
                </tr>
                <tr>
                    <td class="bottom-border"><?php echo $later_activities;?></td>
                </tr>
            	<tr>
                	<th>Where will the activities listed above be carried out?:</th>
                </tr>
                <tr>
                    <td class="bottom-border"></td>
                </tr>
            	<tr>
                	<th>{8} Any suggestions or recommendations you'd like to give to Green Belt Movement:</th>
                </tr>
                <tr>
                    <td class="bottom-border"></td>
                </tr>
            </table>
    		<table class="table table-condensed">
            	<tr>
                	<th>Account Number:</th>
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
        </div>
        
    	<div class="col-md-12">
            <p class="center-align">
                <strong>
                    After completing the phone,please return it to our GBM offices.
                     NB   Write all the names of the members in the group and ensure that all of them append their signatures against their names.
                </strong>
            </p>
            
    		<table class="table table-condensed">
            	<tr>
                	<th>E-mail:</th>
                    <td class="bottom-border"><?php echo $branch_email;?></td>
                	<th>Tel:</th>
                    <td class="bottom-border"><?php echo $branch_phone;?></td>
                </tr>
            </table>
        </div>

    </body>
</html>