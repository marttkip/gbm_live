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


if($meeting_details->num_rows() > 0)
{
    $row = $meeting_details->result();
    

    $meeting_id = $row[0]->meeting_id;
    $meeting_number = $row[0]->meeting_number;
    $created_by = $row[0]->created_by;
    $created = $row[0]->created;
    $modified_by = $row[0]->modified_by;
    $last_modified = $row[0]->last_modified;
    $meeting_start_date = $row[0]->meeting_start_date;
    $meeting_end_date = $row[0]->meeting_end_date;
    $meeting_venue = $row[0]->meeting_venue;
    $meeting_status = $row[0]->meeting_status;
    $project_donor = $row[0]->project_donor;
    $county_name = $row[0]->county_name;
    $meeting_type_id = $row[0]->meeting_type_id;
    $project_grant_county = $row[0]->project_grant_county;

    if($meeting_type_id == 1)
    {
        $activity_title = 'CEE';
    }
    else if($meeting_type_id = 2)
    {
        $activity_title = 'Stakeholders';
    }
    else
    {
        $activity_title = $row->activity_title; 
    }
}
$count = 0;
$result = 
	'<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Names</th>
				<th>ID Number</th>
				<th>Telephone Number</th>
				';
if($meeting_attendee->num_rows()>0)
{
	$row = $meeting_attendee->result();
	foreach($row as $key)
	{
		$name = $key->attendee_name;
		$id_number = $key->attendee_national_id;
		$phone_no = $key->attendee_number;
		$count++;
		$result .=
				'<tr>
					<td>'.$count.'</td>
					<td>'.$name.'</td>
					<td>'.$id_number.'</td>
					<td>'.$phone_no.'</td>
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
	<style type="text/css">
		.receipt_spacing{letter-spacing:0px; font-size: 12px;}
		.center-align{margin:0 auto; text-align:center;}
		
		.receipt_bottom_border{border-bottom: #888888 medium solid;}
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
	</style>
    <head>
        <title>Attendees</title>
        <!-- For mobile content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- IE Support -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/vendor/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/stylesheets/theme-custom.css">
    </head>
    <body class="receipt_spacing">
    <div class="row" >
        	<img src="<?php echo base_url().'assets/logo/'.$branch_image_name;?>" alt="<?php echo $branch_name;?>" class="img-responsive logo"/>
        	<div class="col-md-12 center-align receipt_bottom_border">
            	<strong>
                	<?php echo $branch_name;?><br/>
                    <?php echo $branch_address;?> <?php echo $branch_post_code;?> <?php echo $branch_city;?><br/>
                    E-mail: <?php echo $branch_email;?>. Tel : <?php echo $branch_phone;?><br/>
                    <?php echo $branch_location;?><br/>
                </strong>
            </div>
    </div>
    <div class="col-md-12 center-align">
    <strong>GREENBELT MOVEMENT FIELD MEETING PARTICIPANTS FORM</strong>
    </div> 
    
        <div class="col-md-6">
        	<div class="row" >
            	<div class="col-md-12">
                	<strong>
                        Grant Name: <?php echo $project_donor;?>
                    </strong>
                </div>
            </div>
            <div class="row" >
            	<div class="col-md-12">
                	<strong>
                       Activity Title: <?php echo $activity_title;?>
                    </strong>
                </div>
            </div>
            <div class="row" >
            	<div class="col-md-12">
                	<strong>
                        Grant County: <?php echo $county_name;?>
                    </strong>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          	<div class="row" >
            	<div class="col-md-6">
                	<strong>
                        Meeting Start Date: <?php echo date('jS M Y',strtotime(date($meeting_start_date)));?>
                    </strong>
                    <br/>
                    <strong>
                        Meeting End Date: <?php echo date('jS M Y',strtotime(date($meeting_end_date)));?>
                    </strong>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <?php echo $result;?>
            </div>
        </div>
		<div class="row" >
        	<div class="col-md-12 pull-left">
            	<strong>
                    Staff Recipient's name:
                </strong>
            </div>
        </div>
        <div class="row" >
        	<div class="col-md-6 pull-left">
            	<strong>Date:
                </strong>
             </div>
             <div class="col-md-6 pull-left">
            	<strong>Signature:
                </strong>
             </div>
       </div>

    </body>
</html>