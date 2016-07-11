<section class="panel">
	<?php echo $this->load->view('projects/projects/project_header','',true);?>
</section>
<section class="panel">
	<div class="panel-body">
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

				<?php
				$meeting_type_where = 'project_id = '.$project_id;
				$meeting_type_table = 'meeting';
				$meeting_type_select = '*';
				$item_select  = $this->projects_model->get_project_content($meeting_type_table, $meeting_type_where,$meeting_type_select);

				if($item_select->num_rows() > 0)
				{
					$parameters2 = '';
					foreach ($item_select->result() as $key ) {
						# code...
						$meeting_id = $key->meeting_id;
						$meeting_type_id = $key->meeting_type_id;
						if($meeting_type_id == 1)
						{
							$activity_title = 'CEE';
						}
						else if($meeting_type_id == 2)
						{
							$activity_title = 'Stakeholders';
						}
						else
						{
							$activity_title = $key->activity_title;
						}

						//  get population per the meetings
						// $meeting_where = 'attendees.attendee_id = meeting_attendees.attendee_id AND attendees.gender_id = 1 AND meeting_attendees.meeting_id  = '.$meeting_id;
						// $meeting_table = 'attendees,meeting_attendees';
						// $meeting_select = 'SUM(order_receivables.quantity_given) AS number';
						// $male_pop  = $this->users_model->count_items_where($meeting_table, $meeting_where,$meeting_select);


						$meeting_gender_where = 'attendees.attendee_id = meeting_attendees.attendee_id AND meeting_attendees.meeting_id  = '.$meeting_id;
						$meeting_gender_table = 'attendees,meeting_attendees';
						// $meeting_gender_select = '*';
						$total_pop  = $this->users_model->count_items_where($meeting_gender_table, $meeting_gender_where);

						$parameters2 .= "['$activity_title',$total_pop],";

					}
				}

				

				?>
			    <script type="text/javascript">
			      google.charts.load('current', {'packages':['corechart']});
			      google.charts.setOnLoadCallback(drawChart);
			      function drawChart() {

			        var data = google.visualization.arrayToDataTable([
			          ['MEETING TYPE', 'TOTAL POPULATION'],
			          <?php echo $parameters2;?>
			        ]);

			        var options = {
			          title: 'MEETING TYPE AND POPULATION ',
			          is3D: true,

			        };

			        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

			        chart.draw(data, options);
			      }
			    </script>
			    <div id="piechart" style="width: 100%;"></div>
			    <div class="pull-right"><a href="#"></a></div>
			</div>
			<div class="col-md-6">
				<?php
			
					$parameters3 = '';
					//  get population per the meetings
					$meeting_where = 'attendees.attendee_id = meeting_attendees.attendee_id AND attendees.gender_id = 1 AND meeting_attendees.meeting_id  = meeting.meeting_id AND meeting.project_id = '.$project_id;
					$meeting_table = 'attendees,meeting_attendees,meeting';
					$male_pop  = $this->users_model->count_items_where($meeting_table, $meeting_where);


					$meeting_gender_where = 'attendees.attendee_id = meeting_attendees.attendee_id AND attendees.gender_id = 2  AND meeting_attendees.meeting_id = meeting.meeting_id AND meeting.project_id = '.$project_id;
					$meeting_gender_table = 'attendees,meeting_attendees,meeting';
					// $meeting_gender_select = '*';
					$total_pop  = $this->users_model->count_items_where($meeting_gender_table, $meeting_gender_where);

					$parameters3 .= "['MALE',$male_pop],";
					$parameters3 .= "['FEMALE',$total_pop],";


				

				?>
				<script type="text/javascript">

			      google.charts.setOnLoadCallback(drawChart2);
			      function drawChart2() {

			        var data2 = google.visualization.arrayToDataTable([
			          ['GENDER', 'POPULATION'],
			          <?php echo $parameters3;?>
			        ]);

			        var options2 = {
			          title: 'CUMMULATIVE RATIO OF MALE TO FEMALE ',
			          is3D: true,

			        };

			        var chart2 = new google.visualization.PieChart(document.getElementById('piechart_div'));

			        chart2.draw(data2, options2);
			      }
			    </script>
			    <div id="piechart_div" style="width: 100%;"></div>
			    <div class="pull-right"><a href="<?php echo base_url();?>meeting-report/<?php echo $project_id;?>">explore</a></div>
			</div>
			
		</div>	
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<?php
			
					$parameters4 = '';
					//  get population per the meetings
					$community_where = 'community_group_member.community_group_id = community_group.community_group_id AND community_group_member.gender_id = 1 AND community_group.project_id = '.$project_id;
					$community_table = 'community_group_member,community_group';
					$com_male_pop  = $this->users_model->count_items_where($community_table, $community_where);


					$community_where = 'community_group_member.community_group_id = community_group.community_group_id AND community_group_member.gender_id = 2 AND community_group.project_id = '.$project_id;
					$community_table = 'community_group_member,community_group';
					// $community_gender_select = '*';
					$com_total_pop  = $this->users_model->count_items_where($community_table, $community_where);

					$parameters4 .= "['MALE',$com_male_pop],";
					$parameters4 .= "['FEMALE',$com_total_pop],";


				

				?>
				<script type="text/javascript">
			      google.charts.setOnLoadCallback(drawChart2);
			      function drawChart2() {

			        var data2 = google.visualization.arrayToDataTable([
			           ['GENDER', 'POPULATION'],
			         	<?php echo $parameters4;?>
			        ]);

			        var options2 = {
			          title: 'CUMMULATIVE COMMUNITIES MALE TO FEMALE RATIO ',
			          is3D: true,

			        };

			        var chart2 = new google.visualization.PieChart(document.getElementById('piechart_div_add'));

			        chart2.draw(data2, options2);
			      }
			    </script>
			    <div id="piechart_div_add" style="width: 100%;"></div>
			    <div class="pull-right"><a href="<?php echo base_url();?>meeting-report/<?php echo $project_id;?>">explore</a></div>
			</div>
			<div class="col-md-6">
				<script type="text/javascript">
			      google.charts.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Task', 'Hours per Day'],
			          ['Work',     11],
			          ['Eat',      2],
			          ['Commute',  2],
			          ['Watch TV', 2],
			          ['Sleep',    7]
			        ]);

			        var options = {
			          title: 'SEEDLINGS TALLY',
			          pieHole: 0.4,
			          
			        };

			        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
			        chart.draw(data, options);
			      }
			    </script>

			    <div id="donutchart" style="width: 100%;"></div>
			    <div class="pull-right"><a href="<?php echo base_url();?>meeting-report/<?php echo $project_id;?>">explore</a></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
			<script type="text/javascript">
			      google.charts.setOnLoadCallback(drawChart);
			      function drawChart() {
			        var data = google.visualization.arrayToDataTable([
			          ['Year', 'Sales', 'Expenses'],
			          ['2013',  1000,      400],
			          ['2014',  1170,      460],
			          ['2015',  660,       1120],
			          ['2016',  1030,      540]
			        ]);

			        var options = {
			          title: 'Company Performance',
			          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
			          vAxis: {minValue: 0}
			        };

			        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
			        chart.draw(data, options);
			      }
			    </script>
			    <div id="chart_div" style="width: 100%;"></div>

			</div>
		</div>
	</div>
	</div>
</section>