<script type="text/javascript">
$(function() {
	var chart1;
	var chart2;
	var chart3;
	var controllingChart;

	var hourOptions = [];
	var dayOptions = [];
	var weekOptions = [];
	var monthOptions = [];

	var hourData = [];
	var dayData = [];
	var weekData = [];
	var monthData = [];

	var defaultTickInterval = 5;
	var currentTickInterval = defaultTickInterval;

	$(document).ready(function() {

		 //compute a reasonable tick interval given the zoom range -
		//have to compute this since we set the tickIntervals in order
		//to get predictable synchronization between 3 charts with
		//different data.
		
		function computeTickInterval(xMin, xMax) {
			var zoomRange = xMax - xMin;
			if (zoomRange <= 2)
				currentTickInterval = 0.5;
			if (zoomRange < 20)
				currentTickInterval = 1;
			else if (zoomRange < 100)
				currentTickInterval = 5;
		}
		//explicitly set the tickInterval for the 3 charts - based on
		//selected range
		function setTickInterval(event) {
			var xMin = event.xAxis[0].min;
			var xMax = event.xAxis[0].max;
			computeTickInterval(xMin, xMax);

			chart1.xAxis[0].options.tickInterval = currentTickInterval;
			chart1.xAxis[0].isDirty = true;
			chart2.xAxis[0].options.tickInterval = currentTickInterval;
			chart2.xAxis[0].isDirty = true;
			chart3.xAxis[0].options.tickInterval = currentTickInterval;
			chart3.xAxis[0].isDirty = true;
		}

		//reset the extremes and the tickInterval to default values
		function unzoom() {
			chart1.xAxis[0].options.tickInterval = defaultTickInterval;
			chart1.xAxis[0].isDirty = true;
			chart2.xAxis[0].options.tickInterval = defaultTickInterval;
			chart2.xAxis[0].isDirty = true;
			chart3.xAxis[0].options.tickInterval = defaultTickInterval;
			chart3.xAxis[0].isDirty = true;

			chart1.xAxis[0].setExtremes(null, null);
			chart2.xAxis[0].setExtremes(null, null);
			chart3.xAxis[0].setExtremes(null, null);
		}

		function createAllactivityOption(dataForSerie, tickIntervalInput){
			var option = {
				chart: {
					renderTo: 'allActivityGraph',
					type: 'area',
					zoomType: 'x',
					isZoomed: false,
					width: 1000,
					height: 550
				},
				credits: {
					enabled : false
				},
				title: {
					text: 'กิจกรรมทั้งหมด'
				},
				scrollbar: {
					enabled: false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					tickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                         
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								chart2.options.chart.isZoomed = true;
								chart3.options.chart.isZoomed = true;
								chart2.xAxis[0].setExtremes(xMin, xMax, true);

								chart3.xAxis[0].setExtremes(xMin, xMax, true);
								chart2.options.chart.isZoomed = false;
								chart3.options.chart.isZoomed = false;
							}
						}
					}
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'จำนวนทวีต'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				tooltip: {
					formatter: function() {
						return '' + this.x + ' km, ' + this.y + ' km';
					}
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1,
					y: 30
					
				},
				plotOptions: {
					scatter: {
						marker: {
							radius: 5,
							states: {
								hover: {
									enabled: true,
									lineColor: 'rgb(100,100,100)'
								}
							}
						},
						states: {
							hover: {
								marker: {
									enabled: false
								}
							}
						}
					}
				},
				series: [{
					name: 'Group 1',
					color: 'rgba(150, 150, 255, 0.5)',
					data: dataForSerie,
					fillColor : {
						linearGradient : {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops : [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
						]
					}
				}]
			}
			return option;
		}

		function createTypeActivityOption(dataForSerie, tickIntervalInput){
			var option = {
				chart: {
					renderTo: 'eachActivityGraph',
					type: 'line',
					zoomType: 'x',
					isZoomed: false,
					width: 1000,
					height: 550
				},
				credits: {
					enabled : false
				},
				title: {
					text: 'ประเภทของการทวีต'
				},
				scrollbar: {
					enabled: false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					tickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                         
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								chart1.options.chart.isZoomed = true;
								chart3.options.chart.isZoomed = true;
								chart1.xAxis[0].setExtremes(xMin, xMax, true);

								chart3.xAxis[0].setExtremes(xMin, xMax, true);
								chart1.options.chart.isZoomed = false;
								chart3.options.chart.isZoomed = false;
							}
						}
					}
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'จำนวนทวีต'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				tooltip: {
					formatter: function() {
						return '' + this.x + ' km, ' + this.y + ' km';
					}
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1,
					y: 30
					
				},
				plotOptions: {
					scatter: {
						marker: {
							radius: 5,
							states: {
								hover: {
									enabled: true,
									lineColor: 'rgb(100,100,100)'
								}
							}
						},
						states: {
							hover: {
								marker: {
									enabled: false
								}
							}
						}
					}
				},
				series: [{
						name: 'Tweet',
						data: dataForSerie[0],
					},
					{
						name: 'Reply',
						data: dataForSerie[1],
					},
					{
						name: 'Retweet',
						data: dataForSerie[2],
					}
				]
			}
			return option;
		}

		function createTypeApplicationOption(dataForSerie, tickIntervalInput){
			var option = {
				chart: {
					renderTo: 'applicationGraph',
					type: 'line',
					zoomType: 'x',
					isZoomed: false,
					width: 1000,
					height: 550
				},
				credits: {
					enabled : false
				},
				title: {
					text: 'ประเภทของแอพพลิเคชั่น'
				},
				scrollbar: {
					enabled: false
				},
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					tickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                         
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								chart1.options.chart.isZoomed = true;
								chart3.options.chart.isZoomed = true;
								chart1.xAxis[0].setExtremes(xMin, xMax, true);

								chart3.xAxis[0].setExtremes(xMin, xMax, true);
								chart1.options.chart.isZoomed = false;
								chart3.options.chart.isZoomed = false;
							}
						}
					}
				},
				yAxis: {
					floor: 0,
					labels: {
						align: 'right',
						x: -3
					},
					title: {
						text: 'จำนวนทวีต'
					},
					
					lineWidth: 2,
					opposite: false,
					offset: 0
					
				},
				tooltip: {
					formatter: function() {
						return '' + this.x + ' km, ' + this.y + ' km';
					}
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1,
					y: 30
					
				},
				plotOptions: {
					scatter: {
						marker: {
							radius: 5,
							states: {
								hover: {
									enabled: true,
									lineColor: 'rgb(100,100,100)'
								}
							}
						},
						states: {
							hover: {
								marker: {
									enabled: false
								}
							}
						}
					}
				},
				series: [{
						name: 'Web',
						data: dataForSerie[0],
					},
					{
						name: 'Mobile',
						data: dataForSerie[1],
					}
				]
			}
			return option;
		}

		function prepareHourData(){

		}

		function prepareDayData(){
			//----------------------------------- All ------------------------------------------------------
			var dayDataForAll = [];
			@foreach($tweetDay[0] as $tweetByDay)
				dayDataForAll.push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			dayData.push(dayDataForAll);
			
			//----------------------------------- ActivityType ------------------------------------------------------
			var dayDataForType = [[],[],[]];
			
			@foreach($tweetDay[1][0] as $tweetByDay)
				dayDataForType[0].push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetDay[1][1] as $tweetByDay)
				dayDataForType[1].push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetDay[1][2] as $tweetByDay)
				dayDataForType[2].push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			dayData.push(dayDataForType);

			//----------------------------------- Application ------------------------------------------------------
			var dayDataForApplication = [[],[]];
			@foreach($tweetDay[2][0] as $tweetByDay)
				dayDataForApplication[0].push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetDay[2][1] as $tweetByDay)
				dayDataForApplication[1].push([Date.UTC({{$tweetByDay["year"]}},{{$tweetByDay["month"]}}-1, {{$tweetByDay["day"]}}), {{$tweetByDay["num_of_activity"]}}]);
			@endforeach
			dayData.push(dayDataForApplication);
		}

		function prepareWeekData(){

		}

		function prepareMonthData(){

		}

		function prepareData(){
			prepareHourData();
			prepareDayData();
			prepareWeekData();
			prepareMonthData();
			dayOptions.push(createAllactivityOption(dayData[0], 1000*3600*24));
			dayOptions.push(createTypeActivityOption(dayData[1], 1000*3600*24));
			dayOptions.push(createTypeApplicationOption(dayData[2], 1000*3600*24));

		}

		$(document).ready(function() {
			var option1;
			var option2;
			var option3;
			prepareData();

			var myPlotLineId = "myPlotLine";
			chart1 = new Highcharts.StockChart(dayOptions[0]);

			chart2 = new Highcharts.StockChart(dayOptions[1]);

			chart3 = new Highcharts.StockChart(dayOptions[2]);
		});
	});
});
</script>


<div id="page-wrapper">
	<div class="container-fluid col-lg-12" style="width:1200px;">
		<br>
		<div class="panel panel-green" style"width:1200px;">
			<div class="panel-heading">
				<h3 class="panel-title thaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> กราฟการแพร่กระจายของข้อมูลทวิตเตอร์</h3>
			</div>
			<div class="panel-body">
				
				<div id="allActivityGraph" style="margin:20px 50px;"></div>
				<div id="eachActivityGraph" style="margin:10px 50px;"></div>
				<div id="applicationGraph" style="margin:10px 50px;"></div>

			</div>
		</div>
	</div>
</div>
