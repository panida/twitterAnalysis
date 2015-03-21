<div id="page-wrapper">
	<div class="container-fluid col-lg-12" style="width:1200px;">
		<br>
		<div class="panel panel-green" style"width:1200px;">
			<div class="panel-heading">
				<h3 class="panel-title onlythaibold" style="font-size:20px;"><i class="fa fa-long-arrow-right"></i> กราฟการแพร่กระจายของข้อมูลทวิตเตอร์</h3>
			</div>
			<div class="panel-body">
				<!-- <div><label for="start">Start date:</label><input id="start" style="width: 200px" value="10/10/2011" /><label for="end">End date:</label><input id="end" style="width: 200px" value="10/10/2012"/></div> -->
				
				<div>
					<div class="row" style="height:40px"><div class="graphName"><h4>กิจกรรมทั้งหมด</h4></div></div>
					<div class="row">
						<div style="margin-left: 117px;display: inline">Scale</div>
						<div style="display: inline">
							<button type="button" class="btn btn-default btn-xs MonthScale" >Month</button>
							<button type="button" class="btn btn-default btn-xs WeekScale" >Week</button>
							<button type="button" class="btn btn-default btn-xs DayScale" >Day</button>
							<button type="button" class="btn btn-default btn-xs HourScale">Hour</button>
						</div>
					</div>
					<div id="allActivityGraph" style="margin: 0px 50px 20px 50px;"></div>
					<input type="text" class = "datepickerGraphStartdate" 
	                		style = 'left:778px; top:-560px; position:relative; float:left;  width: 95px; height:22px; font-size:12px; font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
	                <input type="text" class = "datepickerGraphEnddate" 
	                		style = 'left:811px; top:-560px; position:relative; float:left;  width: 95px; height:22px; font-size:12px; font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
				</div>
				<div>
					<div class="row" style="height:40px"><div class="graphName"><h4>ประเภทของการทวีต</h4></div></div>
					<div class="row">
						<div style="margin-left: 117px;display: inline">Scale</div>
						<div style="display: inline">
							<button type="button" class="btn btn-default btn-xs MonthScale" >Month</button>
							<button type="button" class="btn btn-default btn-xs WeekScale" >Week</button>
							<button type="button" class="btn btn-default btn-xs DayScale" >Day</button>
							<button type="button" class="btn btn-default btn-xs HourScale">Hour</button>
						</div>
					</div>
					<div id="eachActivityGraph" style="margin:0px 50px 10px 50px;"></div>
					<input type="text" class = "datepickerGraphStartdate" 
	                		style = 'left:778px; top:-550px; position:relative; float:left;  width: 95px; height:22px; font-size:12px;font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
	                <input type="text" class = "datepickerGraphEnddate" 
	                		style = 'left:811px; top:-550px; position:relative; float:left;  width: 95px; height:22px; font-size:12px; font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
	                </div>
				<div>
					 <div class="row" style="height:40px"><div class="graphName"><h4>ประเภทของแอพพลิเคชั่น</h4></div></div>
					<div class="row">
						<div style="margin-left: 117px;display: inline">Scale</div>
						<div style="display: inline">
							<button type="button" class="btn btn-default btn-xs MonthScale" >Month</button>
							<button type="button" class="btn btn-default btn-xs WeekScale" >Week</button>
							<button type="button" class="btn btn-default btn-xs DayScale" >Day</button>
							<button type="button" class="btn btn-default btn-xs HourScale">Hour</button>
						</div>
					</div>
					<div id="applicationGraph" style="margin:0px 50px 10px 50px;"></div>
					<input type="text" class = "datepickerGraphStartdate" 
                			style = 'left:778px; top:-550px; position:relative; float:left;  width: 95px; height:22px; font-size:12px;font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
                	<input type="text" class = "datepickerGraphEnddate" 
                			style = 'left:811px; top:-550px; position:relative; float:left;  width: 95px; height:22px; font-size:12px; font-family:"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;'/>
                </div>
			</div>
		</div>
	</div>
</div>
