<div id="page-wrapper">
	<div class="container-fluid top-buffer socialGraph">
		<div class = 'manageLinks'>
			<button id='EnableAllLinks'>
		        Enable all links
		    </button>
		    <button id='DisableAllLinks'>
		        Disable all links
		    </button>
		</div>
		
		<script src="{{URL::asset('js/d3/d3.min.js')}}"></script>
		<script src="{{URL::asset('js/d3.slider.js')}}"></script>

		<script>

			Date.prototype.addHours= function(h){
				this.setHours(this.getHours()+h);
				return this;
			}
			//---------------------------Date Time--------------------------------
			function addHours(date, h){
				date1 = new Date();
				date1.setTime(date.getTime() + (h*60*60*1000)); 
				return date1;  
			}

			var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

			var startDateForSocialGraph = new Date({{substr($startDate,0,4)}}, {{substr($startDate,5,2)}}-1, {{substr($startDate,8,2)}}, 0, 0);
			//---------------------------Social graph--------------------------------

			var width = 800,     // svg width
				height = 500,     // svg height
				dr = 6,      // default point radius
				off = 15,    // cluster hull offset
				expand = {}, // expanded clusters
				data, net, force, hullg, hull, linkg, link, nodeg, node;

			var curve = d3.svg.line()
						.interpolate("cardinal-closed")
						.tension(.85);

			var stroke = d3.scale.category10();

			var body = d3.select("body");

			var panel = body.select('.socialGraph')
							.append("div")
							.attr("class", "socialGraphPanel"); 
			
			var timePanel = panel.append("div")
								.attr("class", "timePanel");
			var showDate = timePanel.append("h1").attr("class", "showDateTime showDate");
			showDate.text(""+startDateForSocialGraph.getDate()+" "+monthNames[startDateForSocialGraph.getMonth()]+" "+startDateForSocialGraph.getFullYear());
			var showTime = timePanel.append("h1").attr("class", "showDateTime showTime");
			showTime.text(""+((startDateForSocialGraph.getHours()<10)?("0"+startDateForSocialGraph.getHours()):startDateForSocialGraph.getHours())+" : 00");
			
			var infoPanel = panel.append("div")
								.attr("class", "infoPanel"); 
			infoPanel.append("p").text("คลิกที่จุดเพื่อแสดงรายละเอียด");
			
			var vis = body.select('.socialGraph').append("svg")
							.attr("width", width)
							.attr("height", height)
							.attr("class", "socialGraphSvg");

			var tran = body.select('.socialGraph').append("svg")
							.attr("width", 1100)
							.attr("height", 50)
							.attr("class", "slidebarSvg");

			var playButtonBlackground = tran.append( "rect" )
											.attr("class", "playButtonBlackground");

			var playButtonImg = tran.append( "image" )
									.attr("class", "playButtonBlackground")
									.attr("xlink:href","https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-play-128.png")
									.attr("width", "50px")
									.attr("height", "50px")
									.attr("x", 0)
									.attr("y", 0)
									.on("click", clickPlay );

			var resetButtonBlackground = tran.append( "rect" )
											.attr("class", "resetButtonBlackground");

			var resetButtonImg = tran.append( "image" )
									.attr("class", "resetButtonBlackground")
									.attr("xlink:href","https://cdn3.iconfinder.com/data/icons/google-material-design-icons/48/ic_replay_48px-128.png")
									.attr("width", "50px")
									.attr("height", "50px")
									.attr("x", 50)
									.attr("y", 0)
									.on("click", clickReset );

			var slideWidth = 950,
				slideheight = 30;

			var isPlay = false, intervalId, maxPoint = {{$slidebarLength}};

			var x = d3.scale.linear()
							.domain([0, maxPoint])
							.range([0, slideWidth])
							.clamp(true);

			var brush = d3.svg.brush()
							.x(x)
							.extent([0, 0])
							.on("brush", brushed);

			var svg = tran.append("svg")
							.attr("width", slideWidth+20)
							.attr("height", 50).attr("x",110).attr("y",10).attr("class","slidebarBound")
							.append("g")
							.attr("transform", "translate(" + 10 + "," + 0 + ")");

			svg.append("g")
				.attr("class", "x axis")
				.attr("transform", "translate(0," + slideheight / 2 + ")")
				.call(d3.svg.axis()
					.scale(x)
					.orient("bottom")
					.tickFormat(function(d) { return ""; })
					.tickSize(0)
					.tickPadding(12))
				.select(".domain")
				.select(function() { return this.parentNode.appendChild(this.cloneNode(true)); })
				.attr("class", "halo");

			var slider = svg.append("g")
							.attr("class", "slider")
							.call(brush);

			slider.selectAll(".extent,.resize").remove();
			slider.select(".background").attr("height", slideheight);

			var handle = slider.append("circle")
								.attr("class", "handle")
								.attr("transform", "translate(0," + slideheight / 2 + ")")
								.attr("r", 9);

			var currentBrush = 0;

			//---------------------------double-click to focus-----------------------------

			//Toggle stores whether the highlighting is on
			var toggle = 0;
			//Create an array logging what is connected to what
			var linkedByIndex = {};

			var previousClickNode = -1;

			data = {{$socialGraphData}};

			var nodeslen = data.nodes.length;
			var groupRef = [];
			for(var i=0; i < nodeslen; i++){
				if(data.nodes[i].group != 0){
					var groupidx = -1;
					for(var j = 0 ; j < groupRef.length; j++){
						if(data.nodes[i].group == groupRef[j].group){
							groupidx = j;
							break;
						}
					}
					if(groupidx == -1){
						groupRef.push({group:data.nodes[i].group, index:i});
					}
					else{
						data.links.push({source:data.nodes[groupRef[groupidx].index].name, target:data.nodes[i].name, type:0});
					}
				}
			}

			for (var i=0; i<data.links.length; ++i) {
				o = data.links[i];
				o.source = data.nodes[indexNode(o.source)];
				o.target = data.nodes[indexNode(o.target)];
				
			}

			hullg = vis.append("g");
			linkg = vis.append("g");
			nodeg = vis.append("g");

			init();

			vis.attr("opacity", 1e-6)
				.transition()
				.duration(1000)
				.attr("opacity", 1);

			function init() {
				if (force) force.stop();

				net = network(data, getGroup);

				force = d3.layout.force()
							.nodes(net.nodes)
							.links(net.links)
							.size([width, height])
							.linkDistance(function(l, i) {
								var n1 = l.source, n2 = l.target;
									// larger distance for bigger groups:
									// both between single nodes and _other_ groups (where size of own node group still counts),
									// and between two group nodes.
									//
									// reduce distance for groups with very few outer links,
									// again both in expanded and grouped form, i.e. between individual nodes of a group and
									// nodes of another group or other group node or between two group nodes.
									//
									// The latter was done to keep the single-link groups ('blue', rose, ...) close.
									// return 30 +
									//   Math.min(20 * Math.min((n1.size || (n1.group != n2.group ? n1.group_data.size : 0)),
									//                          (n2.size || (n1.group != n2.group ? n2.group_data.size : 0))),
									//        -30 +
									//        30 * Math.min((n1.link_count || (n1.group != n2.group ? n1.group_data.link_count : 0)),
									//                      (n2.link_count || (n1.group != n2.group ? n2.group_data.link_count : 0))),
									//        100);

								return (30 *(n1.group != n2.group ? 5 : 1))+30;
									//return 150;
							})
							.linkStrength(function(l, i) {
								return (l.source.group==l.target.group)?0.9:0.3;
							})
							.gravity(0)   // gravity+charge tweaked to ensure good 'grouped' view (e.g. green group not smack between blue&orange, ...
							.charge(-100)    // ... charge is important to turn single-linked groups to the outside
							.friction(0.5)   // friction adjusted to get dampened display: less bouncy bouncy ball [Swedish Chef, anyone?]
							.start();

				buttonWidth = 120;
				buttonHeight = 30;
				//-------------------disable all link------------------------------
				var disableAllLinksButton = body.select("#DisableAllLinks").on("click",disableAllLink);

				//-------------------enable all link------------------------------
				var enableAllLinksButton = body.select("#EnableAllLinks").on("click",enableAllLink);

				//-------------------hull------------------------------
				hullg.selectAll("path.hull").remove();
				hull = hullg.selectAll("path.hull")
				.data(convexHulls(net.nodes, getGroup, off))
				.enter().append("path")
				.attr("class", "hull")
				.attr("d", drawCluster)
				.style("fill", function(d) { 
					return stroke(d.group); 
				});

				

				//-------------------link------------------------------
				link = linkg.selectAll("line.link").data(net.links, linkid);
				link.exit().remove();
				link.enter().append("line")
				.attr("class", function(d){ return d.type?"link real":"link virtual";})
				.attr("x1", function(d) { return d.source.x; })
				.attr("y1", function(d) { return d.source.y; })
				.attr("x2", function(d) { return d.target.x; })
				.attr("y2", function(d) { return d.target.y; });

				
				//-------------------legend------------------------------

				var legendwidth = 200;
				var legend = vis.append("g")
				  .attr("class", "legend")
				  .attr("x", width - legendwidth)
				  .attr("y", 25)
				  .attr("height", 100)
				  .attr("width", legendwidth);
				
				legend.selectAll('g').data(data.groups)
				    .enter()
				    .append('g')
				    .each(function(d, i) {
				      var g = d3.select(this);
				      g.append("rect")
				        .attr("x", width - legendwidth)
				        .attr("y", i*25+15)
				        .attr("width", 10)
				        .attr("height", 10)
				        .style("fill", function(d) { return stroke(d.groupid); });
				      g.append("text")
				        .attr("x", width - legendwidth + 20)
				        .attr("y", i * 25 + 23)
				        .attr("height",30)
				        .attr("width",100)
				        .text(d.groupname);
				    }
				);
				//-------------------node------------------------------
				node = nodeg.selectAll(".node")
							.data(net.nodes, nodeid)
							.enter().append("g")
							.attr("class", "node")
							.attr("x", function(d) { return d.x = Math.max(dr, Math.min(width - legendwidth - dr, d.x)); })
							.attr("y", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); });
				
				node.append("circle")
						//.attr("class", function(d) { return "node" + (d.size?"":" leaf"); })
						.attr("id",function(d) { return "key" + d.name; })
						.attr("fill","#FFF")
						.attr("r", function(d) { return d.size ? d.size + dr : dr+1; })
						.style("stroke", function(d) { return stroke(d.group); })
						//.on('dblclick', connectedNodes)
						.on('click', showDetail)
						.on('mouseover', showTip)
						.on('mouseout', hideTip);
				node.append("text")
						.attr("dx", ".35em")
						.attr("dy", -10)
						.text(function(d) { return d.screenname })
						.style("stroke", "gray")
						.style("opacity", 0);

				// node = nodeg.selectAll("circle.node").data(net.nodes, nodeid);
				// node.exit().remove();
				// node.enter().append("circle")
				//     // if (d.size) -- d.size > 0 when d is a group node
				//     .attr("class", function(d) { return "node" + (d.size?"":" leaf"); })
				//     .attr("id",function(d) { return "key" + d.name; })
				//     .attr("fill","#FFF")
				//     .attr("r", function(d) { return d.size ? d.size + dr : dr+1; })
				//     .attr("cx", function(d) { return d.x = Math.max(dr, Math.min(width - dr, d.x)); })
				//     .attr("cy", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); })
				//     .style("stroke", function(d) { return stroke(d.group); })
				//     .on('dblclick', connectedNodes);
				// node.append("text")
				//     .attr("dx", 10)
				//     .attr("dy", ".35em")
				//     .text(function(d) { return d.name })
				//     .style("stroke", "gray");
				node.call(force.drag);

				groupLen = data.groups.length;

			
				//-------------------force------------------------------

				force.on("tick", function() {
					if (!hull.empty()) {
						hull.data(convexHulls(net.nodes, getGroup, off))
						.attr("d", drawCluster);
					}

					link.attr("x1", function(d) { return d.source.x; })
					.attr("y1", function(d) { return d.source.y; })
					.attr("x2", function(d) { return d.target.x; })
					.attr("y2", function(d) { return d.target.y; });

					node.selectAll("circle").attr("cx", function(d) { return d.x = Math.max(dr, Math.min(width - dr, d.x)); })
					.attr("cy", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); });
					node.selectAll("circle").each(collide(0.5));
					node.selectAll("text").attr("x", function (d) {
						return d.x;
					})
					.attr("y", function (d) {
						return d.y;
					});
				});



				function collide(alpha) {
					var padding = 30, // separation between circles
					radius=9;
					var quadtree = d3.geom.quadtree(net.nodes);
					return function(d) {
						var rb = 2*radius + padding,
						nx1 = d.x - rb,
						nx2 = d.x + rb,
						ny1 = d.y - rb,
						ny2 = d.y + rb;
						quadtree.visit(function(quad, x1, y1, x2, y2) {
							if (quad.point && (quad.point !== d)) {
								var x = d.x - quad.point.x,
								y = d.y - quad.point.y,
								l = Math.sqrt(x * x + y * y);
								if (l < rb) {
									l = (l - rb) / l * alpha;
									d.x -= x *= l;
									d.y -= y *= l;
									quad.point.x += x;
									quad.point.y += y;
								}
							}
							return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
						});
					};
				}

				//for double-click focus
				for (var i = 0; i < data.nodes.length; i++) {
					linkedByIndex[i + "," + i] = 1;
				};
				data.links.forEach(function (d) {
					if(d.type) linkedByIndex[d.source.index + "," + d.target.index] = 1;
				});

				link.style('opacity',0);

				//arrow marker
				svg.append("defs").selectAll("marker")
				.data(["suit", "licensing", "resolved"])
				.enter().append("marker")
				.attr("id", function(d) { return d; })
				.attr("viewBox", "0 -5 10 10")
				.attr("refX", 23)
				.attr("refY", 0)
				.attr("markerWidth", 6)
				.attr("markerHeight", 6)
				.attr("orient", "auto")
				.append("path")
				.attr("d", "M0,-5L10,0L0,5");
			}

			function noop() { return false; }

			function indexNode(name){
				for(var i=0;i<data.nodes.length;i++){
					if(data.nodes[i].name == name)  return i;
				}
			}

			function nodeid(n) {
				return n.size ? "_g_"+n.group : n.name;
			}

			function linkid(l) {
				var u = nodeid(l.source),
				v = nodeid(l.target);
				return u+"|"+v;
			}

			function getGroup(n) { return n.group; }

			// constructs the network to visualize
			function network(data, index) {
				expand = expand || {};
				var gm = {},    // group map
						nm = {},    // node map
						lm = {},    // link map
						nodes = [], // output nodes
						links = []; // output links

				// determine nodes
				for (var k=0; k<data.nodes.length; ++k) {
					var n = data.nodes[k],
					i = index(n),
					l = gm[i] || (gm[i]={group:i, size:0, nodes:[]});

					// the node should be directly visible
					nm[n.name] = nodes.length;
					nodes.push(n);
					
					// always count group size as we also use it to tweak the force graph strengths/distances
					l.size += 1;
					n.group_data = l;
				}

				for (i in gm) { gm[i].link_count = 0; }

				// determine links
				for (k=0; k<data.links.length; ++k) {
					var e = data.links[k],
					u = index(e.source),
					v = index(e.target);
					if (u != v) {
						gm[u].link_count++;
						gm[v].link_count++;
					}
					u = nm[e.source.name];
					v = nm[e.target.name];
					var i = u+"|"+v,
					l = lm[i] || (lm[i] = {source:u, target:v, size:0, type:e.type});
					l.size += 1;
				}
				for (i in lm) { links.push(lm[i]); }

				return {nodes: nodes, links: links};
			}

			function convexHulls(nodes, index, offset) {
				var hulls = {};

				// create point sets
				for (var k=0; k<nodes.length; ++k) {
					var n = nodes[k];
					if(n.group!=0){
						var i = index(n),
						l = hulls[i] || (hulls[i] = []);
						l.push([n.x-offset, n.y-offset]);
						l.push([n.x-offset, n.y+offset]);
						l.push([n.x+offset, n.y-offset]);
						l.push([n.x+offset, n.y+offset]);
					}
					
				}

				// create convex hulls
				var hullset = [];
				for (i in hulls) {
					hullset.push({group: i, path: d3.geom.hull(hulls[i])});
				}

				return hullset;
			}

			function drawCluster(d) {
				return curve(d.path); // 0.8
			}

			function brushed() {
				var value = Math.round(brush.extent()[0]);

				if (d3.event.sourceEvent) { // not a programmatic event
					value = x.invert(d3.mouse(this)[0]);
					brush.extent([value, value]);
				}
				if(currentBrush > value){
					removeAnimationNode(value, currentBrush);
				}
				else if(currentBrush < value){
					addAnimationNode(currentBrush, value);
				}
				handle.attr("cx", x(value));
				currentBrush = value; 
			}

			function removeAnimationNode(pointStart, pointStop){
				for(var k=data.transitions.length-1;k>=0;k--){
					if(data.transitions[k].count <= pointStart) break;
					if(data.transitions[k].count <= pointStop){
						for(var j=0;j<data.transitions[k].nodes.length;j++){
							d3.select('#'+'key'+data.transitions[k].nodes[j]).attr("fill","#FFFFFF");
						}
					}  
				}
				var newDate = addHours(startDateForSocialGraph, pointStart);
				showDate.text(""+newDate.getDate()+" "+monthNames[newDate.getMonth()]+" "+newDate.getFullYear());
				showTime.text(""+((newDate.getHours()<10)?("0"+newDate.getHours()):newDate.getHours())+" : 00");
			}

			function addAnimationNode(pointStart, pointStop){
				for(var k=0;k<data.transitions.length;k++){
					if(data.transitions[k].count > pointStop) break;
					if(data.transitions[k].count > pointStart){
						for(var j=0;j<data.transitions[k].nodes.length;j++){
							d3.select('#'+'key'+data.transitions[k].nodes[j]).attr("fill","#0000FF");
						}
					}
				}
				var newDate = addHours(startDateForSocialGraph, pointStop);
				showDate.text(""+newDate.getDate()+" "+monthNames[newDate.getMonth()]+" "+newDate.getFullYear());
				showTime.text(""+((newDate.getHours()<10)?("0"+newDate.getHours()):newDate.getHours())+" : 00");
			}

			function stepAnimationNode(){
				if(currentBrush <= maxPoint){
					handle.attr("cx", x(currentBrush));
					addAnimationNode(currentBrush,currentBrush+1);
					currentBrush++;
				}
				else{
					clickPlay();
				}
			}


			function clickPlay(){

				if(isPlay){
					playButtonImg = playButtonImg.attr("xlink:href","https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-play-128.png");
					clearInterval(intervalId);

				}
				else{
					playButtonImg = playButtonImg.attr("xlink:href","https://cdn4.iconfinder.com/data/icons/cc_mono_icon_set/blacks/48x48/playback_pause.png");
					intervalId = setInterval(stepAnimationNode,80);
				}
				isPlay=!isPlay;
			}

			function clickReset(){
				removeAnimationNode(0, currentBrush);
				handle.attr("cx", x(0));
				currentBrush = 0;
			}

			function disableAllLink(){
				link.style("opacity", 0);
			}

			function enableAllLink(){
				link.style("opacity", 1);
			}

			//This function looks up whether a pair are neighbours
			function neighboring(a, b) {
				return linkedByIndex[a.index + "," + b.index];
			}

			function getGroupName(groupid){
				for(var i=0; i<data.groups.length; i++){
					if(data.groups[i].groupid == groupid)	return data.groups[i].groupname;
				}
			}
			function showDetail() {
				d = d3.select(this).node().__data__;
				if (d.name != previousClickNode || toggle==0) {
					//Reduce the opacity of all but the neighbouring nodes
					
					node.attr("class", function (o) {
						return neighboring(d, o) | neighboring(o, d) ? "node activeNode" : "node hideNode";
					});
					link.style("opacity", function (o) {
						return d.index==o.source.index | d.index==o.target.index ? 1 : 0;
					});
					
					//infoPanel
					infoPanel.html("");
					infoPanel.append("span").attr("class","chat-img pull-left")
								.append("a").attr("class", "tweet_avatar2").attr("href", d.user_timeline_url)
								.append("img").style("margin-right","5px").attr("class","avatar").attr("src", d.profile_pic_url).attr("onerror","if (this.src != 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png') this.src = 'http://a0.twimg.com/sticky/default_profile_images/default_profile_1_normal.png';");
					userDetailDiv = infoPanel.append("div").attr("class", "chat-body clearfix");
					userHeaderDiv = userDetailDiv.append("div").attr("class", "header");
					userHeaderDiv.html('<strong class="primary-font" style="display:block"><a href="'+d.user_timeline_url+'" target="blank" class="tweet_screen_name2 screen_name">'+d.realname+'</a></strong>'+ 
		                                '<span style="color:#AAAAAA;">@'+d.screenname+'</span>'+
		                                '<span>'+
		                                ((d.isProtected=="yes")?'<i class="fa fa-fw fa-lock" style="color:#AAAAAA;"></i>':'<i class="fa fa-fw fa-unlock" style="color:#AAAAAA;"></i>')+
		                                '</span>'
		                               );
					groupsShowList = '<strong>กลุ่ม:</strong><span style="margin-left:5px">';
					for( var i=0; i < d.groupsList.length; i++){
						groupsShowList += ''+getGroupName(d.groupsList[i]);
						if(i!=d.groupsList.length-1) groupsShowList += ', ';
					}
					groupsShowList += '</span>';
					infoPanel.append("div").style('font-size','1.1em').style("margin-top", "15px").html(groupsShowList);
					tweetLen = d.tweet.length;
					if(tweetLen == 0){

					}
					else{
						infoPanel.append("h4").style("margin-top","20px").text("ทวีตที่เกี่ยวข้อง");
						relatedTweet = infoPanel.append("div").attr("class","panel-body").style('padding-top','5px');

						relatedTweetHTML = '<ul class="chat">'
						
						for(var i=0; i<tweetLen; i++){
							relatedTweetHTML += '<li>'+
												'<div>'+
													'<p style="margin:0;">'+d.tweet[i].text+'</p>'+
													'<small>'+
													'<i class="fa fa-clock-o fa-fw"></i>'+ d.tweet[i].created_at+
													((d.tweet[i].activitytypekey==3)?'<i class="fa fa-retweet fa-fw" style="margin-left:5px"></i> Retweeted':'')+
													'</small>'+
				                                '</div>'+

				                                '</li>';
						}
						relatedTweetHTML += '</ul>';

						relatedTweet.html(relatedTweetHTML);
					}


					toggle = 1;
				} 
				else {
					//Put them back to opacity=1
					node.attr("class", "node activeNode");
					link.style("opacity", 0);
					infoPanel.html("<p>คลิกที่จุดเพื่อแสดงรายละเอียด</p>");
					toggle = 0;
				}
				previousClickNode = d.name;
			}

			function showTip(){
				d = d3.select(this).node().__data__;
				node.selectAll('text').style("opacity", function(o){ return (o==d)?1:0});
			}

			function hideTip(){
				d = d3.select(this).node().__data__;
				node.selectAll('text').style("opacity", 0);
			}

	</script>
</div>
</div>