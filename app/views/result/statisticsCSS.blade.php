<style>
	.chat {
	    margin: 0;
	    padding: 0;
	    list-style: none;
	}

	.chat li {
	    margin-bottom: 10px;
	    padding-bottom: 5px;
	    border-bottom: 1px dotted #999;
	}

	.chat li.left .chat-body {
	    margin-left: 60px;
	}

	.chat li.right .chat-body {
	    margin-right: 60px;
	}

	.chat li .chat-body p {
	    margin: 0;
	}

	.panel .slidedown .glyphicon,
	.chat .glyphicon {
	    margin-right: 5px;
	}

	.chat-panel .panel-body {
	    height: 350px;
	    overflow-y: scroll;
	}


</style>


<script type="text/javascript">
	$(function () {
	    $('#device').highcharts({
	        chart: {
	            type: 'pie',
	            options3d: {
	                enabled: true,
	                alpha: 45,
	                beta: 0
	            }
	        },
	        title:{
	            text: ''
	        },
	        credits: {
	            enabled: false
	        },
	        tooltip: {
	            pointFormat: '<b>{point.percentage:.1f}%</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                depth: 35,
	                dataLabels: {
	                    enabled: true,
	                    format: '{point.name}: {point.percentage:.1f}%'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Application',
	            data: [
	                ['Web',   45.0],
	                ['Android',       26.8],
	                ['iPhone',    8.5],
	                ['Blackberry',     6.2],
	                ['Others',   0.7]
	            ]
	        }]
	    });
	});
	$(function () {
	    $('#activity').highcharts({
	        chart: {
	            type: 'pie',
	            options3d: {
	                enabled: true,
	                alpha: 45,
	                beta: 0
	            }
	        },
	        title:{
	            text: ''
	        },
	        credits: {
	            enabled: false
	        },
	        tooltip: {
	            pointFormat: '<b>{point.y:.0f}</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                depth: 35,
	                dataLabels: {
	                    enabled: true,
	                    format: '{point.name}: {point.y:.0f}'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Posts',
	            data: [
	                ['Tweets',   272.0],
	                ['Retweets',       171.0],
	                ['Replies',    43.0],
	            ]
	        }]
	    });
	});
</script>
