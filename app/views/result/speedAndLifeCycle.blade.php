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

		function prepareHourData(){

		}

		function prepareDayData(){

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
		}

		$(document).ready(function() {
			prepareData();

			var myPlotLineId = "myPlotLine";
			chart1 = new Highcharts.StockChart(
				{
					chart: {
						renderTo: 'allActivityGraph',
						type: 'line',
						zoomType: 'x',
						isZoomed: false,
						width: 1000 ,
						height: 500 

					},
					credits: {
						enabled : false
					},
					title: {
						text: 'Height Versus Weight'
					},
					subtitle: {
						text: 'Source: Notional Test Data'
					},
					xAxis: {
						type: 'datetime',
							dateTimeLabelFormats: { // don't display the dummy year
							month: '%e. %b',
							year: '%b'
						},
						title: {
							text: 'Date'
						},
						
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true,
						events:{

							afterSetExtremes:function(){

								if (!this.chart.options.chart.isZoomed)
								{                                         
									var xMin = this.chart.xAxis[0].min;
									var xMax = this.chart.xAxis[0].max;

									var zmRange = computeTickInterval(xMin, xMax);
									chart1.xAxis[0].options.tickInterval =zmRange;
									chart1.xAxis[0].isDirty = true;
									chart2.xAxis[0].options.tickInterval = zmRange;
									chart2.xAxis[0].isDirty = true;
									chart3.xAxis[0].options.tickInterval = zmRange;
									chart3.xAxis[0].isDirty = true;

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
						title: {
							text: 'Weight (kg)'
						}
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
						verticalAlign: "bottom"
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
						color: 'rgba(223, 83, 83, .5)',
						data: [[Date.UTC(1970,  9, 27), 0   ],
						[Date.UTC(1970, 10, 10), 0.6 ],
						[Date.UTC(1970, 10, 18), 0.7 ],
						[Date.UTC(1970, 11,  2), 0.8 ],
						[Date.UTC(1970, 11,  9), 0.6 ],
						[Date.UTC(1970, 11, 16), 0.6 ],
						[Date.UTC(1970, 11, 28), 0.67],
						[Date.UTC(1971,  0,  1), 0.81],
						[Date.UTC(1971,  0,  8), 0.78],
						[Date.UTC(1971,  0, 12), 0.98],
						[Date.UTC(1971,  0, 27), 1.84],
						[Date.UTC(1971,  1, 10), 1.80],
						[Date.UTC(1971,  1, 18), 1.80],
						[Date.UTC(1971,  1, 24), 1.92],
						[Date.UTC(1971,  2,  4), 2.49],
						[Date.UTC(1971,  2, 11), 2.79],
						[Date.UTC(1971,  2, 15), 2.73],
						[Date.UTC(1971,  2, 25), 2.61],
						[Date.UTC(1971,  3,  2), 2.76],
						[Date.UTC(1971,  3,  6), 2.82],
						[Date.UTC(1971,  3, 13), 2.8 ],
						[Date.UTC(1971,  4,  3), 2.1 ],
						[Date.UTC(1971,  4, 26), 1.1 ],
						[Date.UTC(1971,  5,  9), 0.25],
						[Date.UTC(1971,  5, 12), 0   ]]

					}]

				}
				
			);

			chart2 = new Highcharts.StockChart(
				{
					chart: {
						renderTo: 'eachActivityGraph',
						type: 'line',
						zoomType: 'x',
							//x axis only
						isZoomed:false,
						width: 1000 ,
						height: 500 
							/*events: {
								selection: function(event) { //this function should zoom chart1, chart2, chart3 according to selected range
									controllingChart = "chart2";
									setTickInterval(event);
								}
							}*/
					},
					credits: {
						enabled : false
					},
					title: {
						text: 'Height Versus Weight'
					},
					subtitle: {
						text: 'Source: Notional Test Data'
					},
					xAxis: {
						type: 'datetime',
							dateTimeLabelFormats: { // don't display the dummy year
							month: '%e. %b',
							year: '%b'
						},
						title: {
							text: 'Date'
						},
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true,
						events: {
							afterSetExtremes: function() {
								if (!this.chart.options.chart.isZoomed) 
								{
									var xMin = this.chart.xAxis[0].min;
									var xMax = this.chart.xAxis[0].max;
									var zmRange = computeTickInterval(xMin, xMax);
									chart1.xAxis[0].options.tickInterval =zmRange;
									chart1.xAxis[0].isDirty = true;
									chart2.xAxis[0].options.tickInterval = zmRange;
									chart2.xAxis[0].isDirty = true;
									chart3.xAxis[0].options.tickInterval = zmRange;
									chart3.xAxis[0].isDirty = true;


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
						title: {
							text: 'Weight (kg)'
						}
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
						verticalAlign: "bottom"
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
					series: [
					{
						name: 'Group 2',
						color: 'rgba(119, 152, 191, .5)',
						data: [[Date.UTC(1970,  9, 27), 0],
						[Date.UTC(1970, 10, 10), 0.6 ],
						[Date.UTC(1970, 10, 18), 0.7 ],
						[Date.UTC(1970, 11,  2), 0.8 ],
						[Date.UTC(1970, 11,  9), 0.6 ],
						[Date.UTC(1970, 11, 16), 0.6 ],
						[Date.UTC(1970, 11, 28), 0.67],
						[Date.UTC(1971,  0,  1), 0.81],
						[Date.UTC(1971,  0,  8), 0.78],
						[Date.UTC(1971,  0, 12), 0.98],
						[Date.UTC(1971,  0, 27), 1.84],
						[Date.UTC(1971,  1, 10), 1.80],
						[Date.UTC(1971,  1, 18), 1.80],
						[Date.UTC(1971,  1, 24), 1.92],
						[Date.UTC(1971,  2,  4), 2.49],
						[Date.UTC(1971,  2, 11), 2.79],
						[Date.UTC(1971,  2, 15), 2.73],
						[Date.UTC(1971,  2, 25), 2.61],
						[Date.UTC(1971,  3,  2), 2.76],
						[Date.UTC(1971,  3,  6), 2.82],
						[Date.UTC(1971,  3, 13), 2.8 ],
						[Date.UTC(1971,  4,  3), 2.1 ],
						[Date.UTC(1971,  4, 26), 1.1 ],
						[Date.UTC(1971,  5,  9), 0.25],
						[Date.UTC(1971,  5, 12), 0   ]]
					}]
				}
				
			);

			chart3 = new Highcharts.StockChart(
				{
					chart: {
						renderTo: 'applicationGraph',
						type: 'line',
						zoomType: 'x',
						isZoomed:false,
						width: 1000 ,
						height: 500 
						/*events: {
							selection: function(event) { //this function should zoom chart1, chart2, chart3
								controllingChart = "chart3";
								setTickInterval(event);
							}
						}*/
					},
					credits: {
						enabled : false
					},
					title: {
						text: 'Height Versus Weight'
					},
					subtitle: {
						text: 'Source: Notional Test Data'
					},
					xAxis: {
						type: 'datetime',
							dateTimeLabelFormats: { // don't display the dummy year
							month: '%e. %b',
							year: '%b'
						},
						title: {
							text: 'Date'
						},
						
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true,
						events: {
							afterSetExtremes: function() {
								if (!this.chart.options.chart.isZoomed) {
									var xMin = this.chart.xAxis[0].min;
									var xMax = this.chart.xAxis[0].max;
									var zmRange = computeTickInterval(xMin, xMax);
									chart1.xAxis[0].options.tickInterval =zmRange;
									chart1.xAxis[0].isDirty = true;
									chart2.xAxis[0].options.tickInterval = zmRange;
									chart2.xAxis[0].isDirty = true;
									chart3.xAxis[0].options.tickInterval = zmRange;
									chart3.xAxis[0].isDirty = true; 

									chart1.options.chart.isZoomed = true;
									chart2.options.chart.isZoomed = true;
									chart1.xAxis[0].setExtremes(xMin, xMax, true);

									chart2.xAxis[0].setExtremes(xMin, xMax, true);
									chart1.options.chart.isZoomed = false;
									chart2.options.chart.isZoomed = false;

								}
							}
						}
					},
					yAxis: {
						title: {
							text: 'Weight (kg)'
						}
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
						verticalAlign: "bottom"
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
						name: 'Group 3',
						color: 'rgba(119, 152, 191, .5)',
						data: [[Date.UTC(1970,  9, 27), 0   ],
						[Date.UTC(1970, 10, 10), 0.6 ],
						[Date.UTC(1970, 10, 18), 0.7 ],
						[Date.UTC(1970, 11,  2), 0.8 ],
						[Date.UTC(1970, 11,  9), 0.6 ],
						[Date.UTC(1970, 11, 16), 0.6 ],
						[Date.UTC(1970, 11, 28), 0.67],
						[Date.UTC(1971,  0,  1), 0.81],
						[Date.UTC(1971,  0,  8), 0.78],
						[Date.UTC(1971,  0, 12), 0.98],
						[Date.UTC(1971,  0, 27), 1.84],
						[Date.UTC(1971,  1, 10), 1.80],
						[Date.UTC(1971,  1, 18), 1.80],
						[Date.UTC(1971,  1, 24), 1.92],
						[Date.UTC(1971,  2,  4), 2.49],
						[Date.UTC(1971,  2, 11), 2.79],
						[Date.UTC(1971,  2, 15), 2.73],
						[Date.UTC(1971,  2, 25), 2.61],
						[Date.UTC(1971,  3,  2), 2.76],
						[Date.UTC(1971,  3,  6), 2.82],
						[Date.UTC(1971,  3, 13), 2.8 ],
						[Date.UTC(1971,  4,  3), 2.1 ],
						[Date.UTC(1971,  4, 26), 1.1 ],
						[Date.UTC(1971,  5,  9), 0.25],
						[Date.UTC(1971,  5, 12), 0   ]]
					}]
				}
				
			);
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
				
				<div id="allActivityGraph" style="margin:10px 50px;"></div>
				<div id="eachActivityGraph" style="margin:10px 50px;"></div>
				<div id="applicationGraph" style="margin:10px 50px;"></div>

			</div>
		</div>
	</div>
</div>
