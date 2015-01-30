<div id="page-wrapper">
	<div class="container-fluid top-buffer socialGraph">
		
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="{{URL::asset('js/d3.slider.js')}}"></script>

<script>

var width = 800,     // svg width
    height = 500,     // svg height
    dr = 6,      // default point radius
    off = 15,    // cluster hull offset
    expand = {}, // expanded clusters
    data, net, force, hullg, hull, linkg, link, nodeg, node;

var curve = d3.svg.line()
    .interpolate("cardinal-closed")
    .tension(.85);

var stroke = d3.scale.category20();

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
        l = lm[i] || (lm[i] = {source:u, target:v, size:0});
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
    var i = index(n),
        l = hulls[i] || (hulls[i] = []);
    l.push([n.x-offset, n.y-offset]);
    l.push([n.x-offset, n.y+offset]);
    l.push([n.x+offset, n.y-offset]);
    l.push([n.x+offset, n.y+offset]);
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

// --------------------------------------------------------

var body = d3.select("body");

var vis = body.select('.socialGraph').append("svg")
   .attr("width", width)
   .attr("height", height)
   .attr("class", "socialGraphSvg");

var panel = body.select('.socialGraph').append("div")
   .attr("class", "socialGraphPanel"); 

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

var slideWidth = 1000,
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
    .attr("height", 50).attr("x",60).attr("y",10).attr("class","slidebarBound")
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

slider.selectAll(".extent,.resize")
    .remove();

slider.select(".background")
    .attr("height", slideheight);

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

//d3.json("miserables.json", function(json) {
  
  data = {{$socialGraphData}};
  
  for (var i=0; i<data.links.length; ++i) {
    o = data.links[i];
    o.source = data.nodes[indexNode(o.source)];
    o.target = data.nodes[indexNode(o.target)];
    
  }
  console.log(data);

  hullg = vis.append("g");
  linkg = vis.append("g");
  nodeg = vis.append("g");

  init();

  vis.attr("opacity", 1e-6)
    .transition()
      .duration(1000)
      .attr("opacity", 1);
//});

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
    return 30 +
      Math.min(20 * Math.min((n1.size || (n1.group != n2.group ? n1.group_data.size : 0)),
                             (n2.size || (n1.group != n2.group ? n2.group_data.size : 0))),
           -30 +
           30 * Math.min((n1.link_count || (n1.group != n2.group ? n1.group_data.link_count : 0)),
                         (n2.link_count || (n1.group != n2.group ? n2.group_data.link_count : 0))),
           100);
      //return 150;
    })
    .linkStrength(function(l, i) {
      return 0.9;
    })
    .gravity(0.05)   // gravity+charge tweaked to ensure good 'grouped' view (e.g. green group not smack between blue&orange, ...
    .charge(-500)    // ... charge is important to turn single-linked groups to the outside
    .friction(0.5)   // friction adjusted to get dampened display: less bouncy bouncy ball [Swedish Chef, anyone?]
    .start();

  hullg.selectAll("path.hull").remove();
  hull = hullg.selectAll("path.hull")
      .data(convexHulls(net.nodes, getGroup, off))
    .enter().append("path")
      .attr("class", "hull")
      .attr("d", drawCluster)
      .style("fill", function(d) { return stroke(d.group); });

  link = linkg.selectAll("line.link").data(net.links, linkid);
  link.exit().remove();
  link.enter().append("line")
      .attr("class", "link")
      .attr("x1", function(d) { return d.source.x; })
      .attr("y1", function(d) { return d.source.y; })
      .attr("x2", function(d) { return d.target.x; })
      .attr("y2", function(d) { return d.target.y; })
      .style("marker-end",  "url(#suit)")
      .style("stroke-width", function(d) { return d.size || 1; });

  node = nodeg.selectAll("circle.node").data(net.nodes, nodeid);
  node.exit().remove();
  node.enter().append("circle")
      // if (d.size) -- d.size > 0 when d is a group node
      .attr("class", function(d) { return "node" + (d.size?"":" leaf"); })
      .attr("id",function(d) { return "key" + d.name; })
      .attr("fill","#FFF")
      .attr("r", function(d) { return d.size ? d.size + dr : dr+1; })
      .attr("cx", function(d) { return d.x = Math.max(dr, Math.min(width - dr, d.x)); })
      .attr("cy", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); })
      .style("stroke", function(d) { return stroke(d.group); })
      .on('dblclick', connectedNodes);

  node.call(force.drag);

  force.on("tick", function() {
    if (!hull.empty()) {
      hull.data(convexHulls(net.nodes, getGroup, off))
          .attr("d", drawCluster);
    }

    link.attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    node.attr("cx", function(d) { return d.x = Math.max(dr, Math.min(width - dr, d.x)); })
        .attr("cy", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); });
  });

  //for double-click focus
  for (var i = 0; i < data.nodes.length; i++) {
      linkedByIndex[i + "," + i] = 1;
  };
  data.links.forEach(function (d) {
      linkedByIndex[d.source.index + "," + d.target.index] = 1;
  });

  //arrow marker
  svg.append("defs").selectAll("marker")
      .data(["suit", "licensing", "resolved"])
    .enter().append("marker")
      .attr("id", function(d) { return d; })
      .attr("viewBox", "0 -5 10 10")
      .attr("refX", 25)
      .attr("refY", 0)
      .attr("markerWidth", 6)
      .attr("markerHeight", 6)
      .attr("orient", "auto")
    .append("path")
      .attr("d", "M0,-5L10,0L0,5 L10,0 L0, -5")
      .style("stroke", "#4679BD")
      .style("opacity", "0.6");
}

function brushed() {
  var value = brush.extent()[0];

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
  console.log(""+value+", "+currentBrush);
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
}

function stepAnimationNode(){
  if(currentBrush < maxPoint){
    
    handle.attr("cx", x(currentBrush));
    addAnimationNode(currentBrush,currentBrush+1);
    currentBrush++;
  }
  else{
    clickPlay();
  }
}


function clickPlay(){
  console.log("play");

  if(isPlay){
    playButtonImg = playButtonImg.attr("xlink:href","https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-play-128.png");
    clearInterval(intervalId);

  }
  else{
    playButtonImg = playButtonImg.attr("xlink:href","https://cdn4.iconfinder.com/data/icons/cc_mono_icon_set/blacks/48x48/playback_pause.png");
    intervalId = setInterval(stepAnimationNode,50);
  }
  isPlay=!isPlay;
}



//This function looks up whether a pair are neighbours
function neighboring(a, b) {
    return linkedByIndex[a.index + "," + b.index];
}
function connectedNodes() {
    if (toggle == 0) {
        //Reduce the opacity of all but the neighbouring nodes
        d = d3.select(this).node().__data__;
        node.style("opacity", function (o) {
            return neighboring(d, o) | neighboring(o, d) ? 1 : 0.1;
        });
        link.style("opacity", function (o) {
            return d.index==o.source.index | d.index==o.target.index ? 1 : 0.1;
        });
        //Reduce the op
        toggle = 1;
    } else {
        //Put them back to opacity=1
        node.style("opacity", 1);
        link.style("opacity", 1);
        toggle = 0;
    }
}
</script>
  </div>
</div>