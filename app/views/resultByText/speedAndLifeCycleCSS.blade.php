<style>
	.graphName{
		position: absolute;
		left: 530px;

	}
</style>
<script type="text/javascript">
$(function() {
	var chart1 = null;
	var chart2 = null;
	var chart3 = null;
	var controllingChart;

	var hourData = [];
	var dayData = [];
	var weekData = [];
	var monthData = [];

	var defaultTickInterval = 5;
	var currentTickInterval = defaultTickInterval;


	$(document).ready(function() {

		$('.MonthScale').click(function(e) {  
      		changeScale("MonthScale");
    	});
    	$('.WeekScale').click(function(e) {  
      		changeScale("WeekScale");
    	});
    	$('.DayScale').click(function(e) {  
      		changeScale("DayScale");
    	});
    	$('.HourScale').click(function(e) {  
      		changeScale("HourScale");
    	});


		function changeScale(id)
		{
		    
		    var isFirst = true;
		    if(chart1 !=null){
		    	xMin = chart1.xAxis[0].min;
				xMax = chart1.xAxis[0].max;
				isFirst = false;
		    }
		    

		    if (id == "MonthScale"){
		    	$('.MonthScale').attr('class','btn btn-primary btn-xs MonthScale');
	      		$('.WeekScale').attr('class','btn btn-default btn-xs WeekScale');
	      		$('.DayScale').attr('class','btn btn-default btn-xs DayScale');
	      		$('.HourScale').attr('class','btn btn-default btn-xs HourScale');
		    	chart1 = new Highcharts.StockChart(createAllactivityOption(monthData[0], 1000*3600*24*30));
				chart2 = new Highcharts.StockChart(createTypeActivityOption(monthData[1], 1000*3600*24*30));
				chart3 = new Highcharts.StockChart(createTypeApplicationOption(monthData[2], 1000*3600*24*30));
		    }
		    else if(id == "WeekScale"){
	      		$('.MonthScale').attr('class','btn btn-default btn-xs MonthScale');
	      		$('.WeekScale').attr('class','btn btn-primary btn-xs WeekScale');
	      		$('.DayScale').attr('class','btn btn-default btn-xs DayScale');
	      		$('.HourScale').attr('class','btn btn-default btn-xs HourScale');
		    	chart3 = new Highcharts.StockChart(createAllactivityOption(weekData[0], 1000*3600*24*7));
				chart2 = new Highcharts.StockChart(createTypeActivityOption(weekData[1], 1000*3600*24*7));
				chart1 = new Highcharts.StockChart(createTypeApplicationOption(weekData[2], 1000*3600*24*7));
		    }
		    else if(id == "DayScale"){
		    	$('.MonthScale').attr('class','btn btn-default btn-xs MonthScale');
	      		$('.WeekScale').attr('class','btn btn-default btn-xs WeekScale');
	      		$('.DayScale').attr('class','btn btn-primary btn-xs DayScale');
	      		$('.HourScale').attr('class','btn btn-default btn-xs HourScale');
		    	chart1 = new Highcharts.StockChart(createAllactivityOption(dayData[0], 1000*3600*24));
				chart2 = new Highcharts.StockChart(createTypeActivityOption(dayData[1], 1000*3600*24));
				chart3 = new Highcharts.StockChart(createTypeApplicationOption(dayData[2], 1000*3600*24));
		    }
		    else if(id == "HourScale"){
	      		$('.MonthScale').attr('class','btn btn-default btn-xs MonthScale');
	      		$('.WeekScale').attr('class','btn btn-default btn-xs WeekScale');
	      		$('.DayScale').attr('class','btn btn-default btn-xs DayScale');
	      		$('.HourScale').attr('class','btn btn-primary btn-xs HourScale');
		    	chart1 = new Highcharts.StockChart(createAllactivityOption(hourData[0], 1000*3600));
				chart2 = new Highcharts.StockChart(createTypeActivityOption(hourData[1], 1000*3600));
				chart3 = new Highcharts.StockChart(createTypeApplicationOption(hourData[2], 1000*3600));
		    }

		    if(!isFirst){
		    	console.log(xMin);
				chart1.options.chart.isZoomed = true;
				chart2.options.chart.isZoomed = true;
				chart3.options.chart.isZoomed = true;
				chart1.xAxis[0].setExtremes(xMin, xMax, true);
				chart2.xAxis[0].setExtremes(xMin, xMax, true);
				chart3.xAxis[0].setExtremes(xMin, xMax, true);
				chart1.options.chart.isZoomed = false;
				chart2.options.chart.isZoomed = false;
				chart3.options.chart.isZoomed = false;
			}
			xMin = chart1.xAxis[0].min;
			xMax = chart1.xAxis[0].max;
			$(".datepickerGraphStartdate").datepicker('setDate', new Date(xMin));
			$(".datepickerGraphEnddate").datepicker('setDate', new Date(xMax));
		}

		function setAllGraphRange(xMin,xMax){
			chart1.options.chart.isZoomed = true;
			chart2.options.chart.isZoomed = true;
			chart3.options.chart.isZoomed = true;
			chart1.xAxis[0].setExtremes(xMin, xMax, true);
			chart2.xAxis[0].setExtremes(xMin, xMax, true);
			chart3.xAxis[0].setExtremes(xMin, xMax, true);
			chart1.options.chart.isZoomed = false;
			chart2.options.chart.isZoomed = false;
			chart3.options.chart.isZoomed = false;
			$(".datepickerGraphStartdate").datepicker('setDate', new Date(xMin));
			$(".datepickerGraphEnddate").datepicker('setDate', new Date(xMax));
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
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					minTickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                        
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								setAllGraphRange(xMin, xMax);
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
				rangeSelector:{
					buttons : [{
						type : 'all',
						text : 'All'
					}],
					selected : 0,
					inputEnabled : true,
					inputEditDateFormat: '%Y-%m-%d'
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1,
					
				},
				plotOptions: {
					area: {
						marker: {
							radius: 3,
							//enabled: true
						}
					}
				},
				series: [{
					name: 'All',
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
				navigator: {
		            margin: 10
		        },
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					minTickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                         
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								setAllGraphRange(xMin, xMax);
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
				rangeSelector:{
					buttons : [{
						type : 'all',
						count : 1,
						text : 'All'
					}],
					selected : 0,
					inputEnabled : true,
					inputEditDateFormat: '%Y-%m-%d'
				},
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 3,
							//enabled: true
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
				navigator: {
		            margin: 10
		        },
		        rangeSelector:{
					buttons : [{
						type : 'all',
						text : 'All'
					}],
					selected : 0,
					inputDateFormat:"%Y-%m-%d",
					inputEditDateFormat:"%Y-%m-%d"
				},
				xAxis: {
					type: 'datetime',
					title: {
						text: 'วัน-เวลา'
					},
					minTickInterval: tickIntervalInput,
					
					startOnTick: true,
					endOnTick: true,
					showLastLabel: true,
					events:{
						afterSetExtremes:function(){

							if (!this.chart.options.chart.isZoomed)
							{                                         
								var xMin = this.chart.xAxis[0].min;
								var xMax = this.chart.xAxis[0].max;

								setAllGraphRange(xMin, xMax);
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
				legend: {
					enabled: true,
					floating:true,
					align: 'center',
					layout: "horizontal",
					verticalAlign: "top",
					borderWidth: 1
					
				},
				plotOptions: {
					line: {
						marker: {
							radius: 3,
							//enabled: true
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
			//----------------------------------- All ------------------------------------------------------
			var hourDataForAll = [];
			@foreach($tweetHour[0] as $tweetByHour)
				hourDataForAll.push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			hourData.push(hourDataForAll);
			
			//----------------------------------- ActivityType ------------------------------------------------------
			var hourDataForType = [[],[],[]];
			
			@foreach($tweetHour[1][0] as $tweetByHour)
				hourDataForType[0].push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetHour[1][1] as $tweetByHour)
				hourDataForType[1].push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetHour[1][2] as $tweetByHour)
				hourDataForType[2].push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			hourData.push(hourDataForType);

			//----------------------------------- Application ------------------------------------------------------
			var hourDataForApplication = [[],[]];
			@foreach($tweetHour[2][0] as $tweetByHour)
				hourDataForApplication[0].push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetHour[2][1] as $tweetByHour)
				hourDataForApplication[1].push([Date.UTC({{$tweetByHour["year"]}},{{$tweetByHour["month"]}}-1, {{$tweetByHour["day"]}}, {{$tweetByHour["hour"]}}), {{$tweetByHour["num_of_activity"]}}]);
			@endforeach
			hourData.push(hourDataForApplication);
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
			//----------------------------------- All ------------------------------------------------------
			var weekDataForAll = [];
			@foreach($tweetWeek[0] as $tweetByWeek)
				weekDataForAll.push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			weekData.push(weekDataForAll);
			
			//----------------------------------- ActivityType ------------------------------------------------------
			var weekDataForType = [[],[],[]];
			
			@foreach($tweetWeek[1][0] as $tweetByWeek)
				weekDataForType[0].push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetWeek[1][1] as $tweetByWeek)
				weekDataForType[1].push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetWeek[1][2] as $tweetByWeek)
				weekDataForType[2].push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			weekData.push(weekDataForType);

			//----------------------------------- Application ------------------------------------------------------
			var weekDataForApplication = [[],[]];
			@foreach($tweetWeek[2][0] as $tweetByWeek)
				weekDataForApplication[0].push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetWeek[2][1] as $tweetByWeek)
				weekDataForApplication[1].push([Date.UTC({{$tweetByWeek["year"]}},{{$tweetByWeek["month"]}}-1, {{$tweetByWeek["startDay"]}}), {{$tweetByWeek["num_of_activity"]}}]);
			@endforeach
			weekData.push(weekDataForApplication);
		}

		function prepareMonthData(){
			//----------------------------------- All ------------------------------------------------------
			var monthDataForAll = [];
			@foreach($tweetMonth[0] as $tweetByMonth)
				monthDataForAll.push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			monthData.push(monthDataForAll);
			
			//----------------------------------- ActivityType ------------------------------------------------------
			var monthDataForType = [[],[],[]];
			
			@foreach($tweetMonth[1][0] as $tweetByMonth)
				monthDataForType[0].push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetMonth[1][1] as $tweetByMonth)
				monthDataForType[1].push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetMonth[1][2] as $tweetByMonth)
				monthDataForType[2].push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			monthData.push(monthDataForType);

			//----------------------------------- Application ------------------------------------------------------
			var monthDataForApplication = [[],[]];
			@foreach($tweetMonth[2][0] as $tweetByMonth)
				monthDataForApplication[0].push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			@foreach($tweetMonth[2][1] as $tweetByMonth)
				monthDataForApplication[1].push([Date.UTC({{$tweetByMonth["year"]}},{{$tweetByMonth["month"]}}-1), {{$tweetByMonth["num_of_activity"]}}]);
			@endforeach
			monthData.push(monthDataForApplication);
		}

		function prepareData(){
			prepareHourData();
			prepareDayData();
			prepareWeekData();
			prepareMonthData();
		}

		$(document).ready(function() {
			var option1;
			var option2;
			var option3;
			prepareData();

			var myPlotLineId = "myPlotLine";
			changeScale("DayScale");
		});

		//datepicker

		$(".datepickerGraphStartdate").datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: "+1d",
            dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ],
            onSelect: function(selected,evnt) {
				var xMax = chart1.xAxis[0].max;
				setAllGraphRange((new Date(selected)).valueOf(),xMax);
		    }
        });
        
        $(".datepickerGraphEnddate").datepicker({
            dateFormat: "yy-mm-dd",
            // minDate: "+1d",
            dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
            monthNames: ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" ],
        	onSelect: function(selected,evnt) {
		        var xMin = chart1.xAxis[0].min;
		        setAllGraphRange(xMin, (new Date(selected)).valueOf());
		    }
        });
	});
});
</script>