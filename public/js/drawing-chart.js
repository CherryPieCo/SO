var linearChartData = {
	labels : ["January","February","March","April","May","June","July", "August", "September", "October", "November", "December"],
	datasets : [
		{
			label: "constant traffic links",
			fillColor : "rgba(220,220,220,0.2)",
			strokeColor : "rgba(220,220,220,1)",
			pointColor : "rgba(220,220,220,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [0, 500, 600, 550, 750, 1000, 2000, 2100, 2500, 3000, 3500, 3700]
		},
		{
			label: "relevant traffic",
			fillColor : "rgba(151,187,205,0.2)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
			data : [0, 50, 90, 100, 200, 300, 500, 550, 650, 700, 850, 1000]
		}
	]
}

// Line charts options
var linearChartOptions = {
	animation: false,
	responsive: true,
	//Boolean - Whether the line is curved between points
  bezierCurve : false,
	//String - A legend template
  legendTemplate : "<ul class=\"chart-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
}

var ctx = document.getElementById("linearChart").getContext("2d");
var linearChart = new Chart(ctx).Line(linearChartData, linearChartOptions);

// drawing chart legend
document.getElementById('linearChartLegend').innerHTML = linearChart.generateLegend();