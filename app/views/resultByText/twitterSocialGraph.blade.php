<div id="page-wrapper">
	<div class="container-fluid top-buffer socialGraph">
		
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="{{URL::asset('js/d3.slider.js')}}"></script>
<script>

var width = 1100,     // svg width
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

function nodeid(n) {
  return n.size ? "_g_"+n.group : n.name;
}

function linkid(l) {
  var u = nodeid(l.source),
      v = nodeid(l.target);
  return u<v ? u+"|"+v : v+"|"+u;
}

function getGroup(n) { return n.group; }

// constructs the network to visualize
function network(data, prev, index, expand) {
  expand = expand || {};
  var gm = {},    // group map
      nm = {},    // node map
      lm = {},    // link map
      gn = {},    // previous group nodes
      gc = {},    // previous group centroids
      nodes = [], // output nodes
      links = []; // output links

  // process previous nodes for reuse or centroid calculation
  if (prev) {
    prev.nodes.forEach(function(n) {
      var i = index(n), o;
      if (n.size > 0) {
        gn[i] = n;
        n.size = 0;
      } else {
        o = gc[i] || (gc[i] = {x:0,y:0,count:0});
        o.x += n.x;
        o.y += n.y;
        o.count += 1;
      }
    });
  }

  // determine nodes
  for (var k=0; k<data.nodes.length; ++k) {
    var n = data.nodes[k],
        i = index(n),
        l = gm[i] || (gm[i]=gn[i]) || (gm[i]={group:i, size:0, nodes:[]});

    //if (expand[i]) {
      // the node should be directly visible
      nm[n.name] = nodes.length;
      nodes.push(n);
      if (gn[i]) {
        // place new nodes at cluster location (plus jitter)
        n.x = gn[i].x + Math.random();
        n.y = gn[i].y + Math.random();
      }
    
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
    var i = (u<v ? u+"|"+v : v+"|"+u),
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
    if (n.size) continue;
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




d3.json("miserables.json", function(json) {
  data = json;
  for (var i=0; i<data.links.length; ++i) {
    o = data.links[i];
    o.source = data.nodes[o.source];
    o.target = data.nodes[o.target];
    
  }

  hullg = vis.append("g");
  linkg = vis.append("g");
  nodeg = vis.append("g");

  init();

  vis.attr("opacity", 1e-6)
    .transition()
      .duration(1000)
      .attr("opacity", 1);
});

function init() {
  if (force) force.stop();

  net = network(data, net, getGroup, expand);

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
    return 1;
    })
    .gravity(0.05)   // gravity+charge tweaked to ensure good 'grouped' view (e.g. green group not smack between blue&orange, ...
    .charge(-600)    // ... charge is important to turn single-linked groups to the outside
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
      .style("stroke-width", function(d) { return d.size || 1; });

  node = nodeg.selectAll("circle.node").data(net.nodes, nodeid);
  node.exit().remove();
  node.enter().append("circle")
      // if (d.size) -- d.size > 0 when d is a group node
      .attr("class", function(d) { return "node" + (d.size?"":" leaf"); })
      .attr("id",function(d) { return "" + nodeid(d); })
      .attr("fill","#FFF")
      .attr("r", function(d) { return d.size ? d.size + dr : dr+1; })
      .attr("cx", function(d) { return d.x = Math.max(dr, Math.min(width - dr, d.x)); })
      .attr("cy", function(d) { return d.y = Math.max(dr, Math.min(height - dr, d.y)); })
      .style("stroke", function(d) { return stroke(d.group); });

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
}



var slideWidth = 1000,
    slideheight = 30;

var x = d3.scale.linear()
    .domain([0, 264])
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
        d3.select('#'+data.transitions[k].nodes[j]).attr("fill","#FFFFFF");
      }
    }  
  }
}

function addAnimationNode(pointStart, pointStop){
  for(var k=0;k<data.transitions.length;k++){
    if(data.transitions[k].count > pointStop) break;
    if(data.transitions[k].count > pointStart){
      for(var j=0;j<data.transitions[k].nodes.length;j++){
        d3.select('#'+data.transitions[k].nodes[j]).attr("fill","#0000FF");
      }
    }
  }
}

function clickPlay(){
  console.log("play");
  var i=0,k=0;
  while(i<264){
    if(k<data.transitions.length && data.transitions[k].count==i){
      for(var j=0;j<data.transitions[k].nodes.length;j++){
        d3.select('#'+data.transitions[k].nodes[j]).transition().attr("fill","#0000FF").delay(10*i);
        console.log(""+i);
        console.log(""+data.transitions[k].nodes[j]);
      }
      k++;
    }
    brush.extent([i, i]);
    handle.transition().attr("cx", x(i)).delay(200*i);
    i++;
  }
}


</script>

	</div>
</div>