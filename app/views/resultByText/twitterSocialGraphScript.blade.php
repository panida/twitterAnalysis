<style type="text/css">

/*circle.node {
  fill: lightsteelblue;
  stroke: #555;
  stroke-width: 3px;
}
circle.leaf {
  stroke: #fff;
  stroke-width: 1.5px;
}
path.hull {
  fill: lightsteelblue;
  fill-opacity: 0.3;
}
line.link {
  stroke: #333;
  stroke-opacity: 0.5;
  pointer-events: none;
}*/
circle.node {

  stroke: #555;
  stroke-width: 3px;
}
circle.leaf {
  stroke: #fff;
  stroke-width: 1.5px;
}
path.hull {
  fill: lightsteelblue;
  fill-opacity: 0.3;
}

.node.activeNode circle{
  opacity: 1;
}


.node.hideNode circle{
  opacity: 0.1;
}
.socialGraph{
  width: 1200px;
}

.socialGraphSvg{
  border: 2px solid #5cb85c;
}

.socialGraphPanel{
  width: 300px;
  height: 500px;
  margin-right: 10px;
  display: inline-block;
}

.timePanel{
  width: 300px;
  height: 140px;
  border: 2px solid #5cb85c;
  margin: 0 0 10px 0;
  float: left;
  text-align: center;
}

.infoPanel{
  width: 300px;
  height: 350px;
  border: 2px solid #5cb85c;
  margin: 0 0 0 0;
  float: left;
  top:200px;
}

.axis {
  font: 10px sans-serif;
  -webkit-user-select: none;
  -moz-user-select: none;
  user-select: none;
}

.axis .domain {
  fill: none;
  stroke: #000;
  stroke-opacity: .3;
  stroke-width: 10px;
  stroke-linecap: round;
}

.axis .halo {
  fill: none;
  stroke: #ddd;
  stroke-width: 8px;
  stroke-linecap: round;
}

.slider .handle {
  fill: #fff;
  stroke: #000;
  stroke-opacity: .5;
  stroke-width: 1.25px;
  cursor: crosshair;
}

.link.real{
  stroke: #333;
  stroke-opacity: 0.5;
  pointer-events: none;
  marker-end: url(#suit);
  stroke-width: 1;
}

.link.virtual{
  stroke-opacity: 0;
  pointer-events: none;
  stroke-width: 0;
}
</style>
