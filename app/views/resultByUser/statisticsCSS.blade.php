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
		Highcharts.setOptions({
		    lang: {
		        thousandsSep: ','
		    }
		});
	    $('#device').highcharts({
	        chart: {
	            type: 'pie',
	            options3d: {
	                enabled: true,
	                alpha: 0,
	                beta: 0
	            }
	        },
	        title:{
	            text: ''
	        },
	        credits: {
	            enabled: false
	        },
	        labels:{
	        	style: {
					left: '100px',
					top: '100px'
				}
	        },
	        tooltip: {
	            pointFormat: '<b>{point.y:,.0f} tweets</b><br><b>({point.percentage:.1f}%)</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                depth: 35,
	                size: '75%',
	                dataLabels: {
	                    enabled: true,
	                    distance: 10,
	                    x: 0,
	                    y: 0,
	                    // format: '{point.name}: {point.percentage:.1f}%'
	                    format: '{point.name}<br>:{point.y:,.0f}'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Application',
	            data: [
	                <?php 
	                	foreach($sourceProportion as $aSource){
	                		echo "['".$aSource['sourceName']."',".$aSource['count']."],";
	                	}
	                ?>
	                // ['Android',       26.8],
	                // ['iPhone',    8.5],
	                // ['Blackberry',     6.2],
	                // ['Others',   0.7]
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
	                alpha: 0,
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
	            pointFormat: '<b>{point.y:,.0f} ({point.percentage:.1f}%)</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                depth: 35,
	                dataLabels: {
	                    enabled: true,
	                    format: '{point.name}: {point.y:,.0f}'
	                }
	            }
	        },
	        series: [{
	            type: 'pie',
	            name: 'Posts',
	            data: [
	                ['Tweets',   {{$countAct['tweet']}}],
	                ['Retweets',       {{$countAct['retweet']}}],
	                ['Replies',    {{$countAct['reply']}}],
	            ]
	        }]
	    });
	});
</script>
