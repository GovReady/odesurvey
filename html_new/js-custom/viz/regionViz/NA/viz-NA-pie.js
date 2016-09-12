// define svg canvas dimensions
// setting global variables
var width = 300,
    height = 300,
    radius = Math.min(width, height-20) / 2;

var arc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius-35);

var labelArc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius-10);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.number; });

// pie one --- breakdown by orgtype
var color = d3.scale.ordinal()
    .range(["#98abc5", "#7b6888", "#a05d56", "#ff8c00"]);

var svg = d3.select("#threePie").append("svg")
    .attr("id", "byType")
    .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("viz-data/data-sample-pie1.csv", type, function(error, data) {
  d3.json("js-custom/viz/regionViz/NA/NATypePieData.php", function(error, data) {
  if (error) throw error;

  total1 = 0;
  // console.log(data.length);
  for (i=0; i<data.length; i++) {
    total1 = total1 + data[i].number;
    // console.log(i);
    // console.log(total1);
  }

  var formatPercent = d3.format(",.0%");

  var g = svg.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip.style("display", null); })
      .on("mouseout", function() { tooltip.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#byType').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#byType').node())[1] - 20;
        tooltip.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_type for org type name
        tooltip.select("text").text(formatPercent(d.value/total1));
        // console.log(d.value);
        // console.log(total1);
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.org_type); });

  var legend = svg.selectAll(".legend")
      .data(color.domain().slice().reverse())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title = ["Organization Types"];
  var legendTitle = svg.selectAll(".legendTitle")
      .data(title)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-80)
      .attr("y", -10)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title);

   legend.append("rect")
      .attr("x", width - 40)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);
      // offset between rect and text is 6
  legend.append("text")
      .attr("x", width - 45)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

// function type(d) {
//   d.number = +d.number;
//   return d;
// }

// pie two --- breakdown by org size
var color2 = d3.scale.ordinal()
    .range(["#ffd369", "#376d86", "#926239", "#a4579e", "#50b094"]);

var svg2 = d3.select("#threePie").append("svg")
    .attr("id", "bySize")
    .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("viz-data/data-sample-pie2.csv", type, function(error, data) {
d3.json("js-custom/viz/regionViz/NA/NASizePieData.php", function(error, data) {
  if (error) throw error;
  // console.log(data);
  total = 0;
    for (i=0; i<data.length; i++) {
      total = total + data[i].number;
    }

  var formatPercent = d3.format(",.0%");

  var g = svg2.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip2.style("display", null); })
      .on("mouseout", function() { tooltip2.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#bySize').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#bySize').node())[1] - 20;
        tooltip2.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip2.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_size for org size label
        tooltip2.select("text").text(formatPercent(d.value/total));
        // console.log(total);
        // console.log(d.value);
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color2(d.data.org_size); });

  var legend2 = svg2.selectAll(".legend")
      .data(color2.domain().slice().reverse())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title2 = ["Organization Sizes"];
  var legendTitle2 = svg2.selectAll(".legendTitle")
      .data(title2)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-80)
      .attr("y", -10)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title2);

   legend2.append("rect")
      .attr("x", width - 40)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color2);
      // offset between rect and text is 6
  legend2.append("text")
      .attr("x", width - 45)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

// function type(d) {
//   d.number = +d.number;
//   return d;
// }

// pie three --- breakdown by org age
var color3 = d3.scale.ordinal()
    .range(["#0055A4", "#d69f3e", "#c55542"]);

var svg3 = d3.select("#threePie").append("svg")
     .attr("id", "byAge")
     .attr("class", "pieSvg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// d3.csv("viz-data/data-sample-pie3.csv", type, function(error, data) {
  d3.json("js-custom/viz/regionViz/NA/NAAgePieData.php", function(error, data) {
  if (error) throw error;

  total2 = 0;
    for (i=0; i<data.length; i++) {
      total2 = total2 + data[i].number;
    }

  var formatPercent = d3.format(",.0%");

  var g = svg3.selectAll(".arc")
      .data(pie(data))
      .enter().append("g")
      .attr("class", "arc")
      .on("mouseover", function() { tooltip3.style("display", null); })
      .on("mouseout", function() { tooltip3.style("display", "none"); })
      .on("mousemove", function(d) {
        var xPosition = d3.mouse(d3.select('#byAge').node())[0] - 20;
        var yPosition = d3.mouse(d3.select('#byAge').node())[1] - 20;
        tooltip3.attr("transform", "translate(" + xPosition + "," + yPosition + ")");
        // tooltip3.select("text").text(d.value + " (" + formatPercent(d.value/total) + ")"); // d.data.org_age for org age label
        tooltip3.select("text").text(formatPercent(d.value/total2));
      });

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color3(d.data.org_age); });

  var legend3 = svg3.selectAll(".legend")
      .data(color3.domain().slice().reverse())
      .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(-245," + (i-1) * 20 + ")"; });

  var title3 = ["Organization Ages"];
  var legendTitle3 = svg3.selectAll(".legendTitle")
      .data(title3)
      .enter().append("g")
      .attr("class", "legendTitle")
      .attr("transform", "translate(-175,-25)")
      .append("text")
      .attr("x", width-80)
      .attr("y", -10)
      .style("text-anchor", "end")
      .style("font-weight", "bold")
      .style("font-size", "12px")
      .text(title3);

   legend3.append("rect")
      .attr("x", width - 40)
      .attr("y", -5)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color3);
      // offset between rect and text is 6
  legend3.append("text")
      .attr("x", width - 45)
      .attr("y", 8)
      .style("text-anchor", "end")
      .style("font-size", "12px")
      .text(function(d) { return d; });

});

// function type(d) {
//   d.number = +d.number;
//   return d;
// }

// Prep the tooltips, initial display is hidden
      var tooltip = d3.select("#byType").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");

      var tooltip2 = d3.select("#bySize").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip2.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");

      var tooltip3 = d3.select("#byAge").append("g")
        .attr("class", "tooltip")
        .style("display", "none");

      tooltip3.append("text")
        .attr("x", 15)
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .attr("font-size", "12px")
        .attr("font-weight", "bold");