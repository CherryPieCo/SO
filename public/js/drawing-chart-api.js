var linearChartApiData = {
	labels : ["30/03","31/03","01/04","02/04","03/04","04/04","05/04", "06/04", "07/04", "08/04", "09/04", "10/04","11/04","12/04","13/04","14/04","15/04", "16/04", "17/04", "18/04", "19/04", "20/04","21/04","22/04","23/04","24/04","25/04", "26/04", "27/04", "28/04"],
	datasets : [
		{
			label: "API usage",
			fillColor : "rgba(230, 109, 76,0.2)",
			strokeColor : "rgba(230, 109, 76,1)",
			pointColor : "rgba(230, 109, 76,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(230, 109, 76,1)",
			data : [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		}
	]
}

// Line charts options
var linearChartApiOptions = {
	animation: false,
	responsive: true,
	//Boolean - Whether the line is curved between points
  bezierCurve : false,
  // showScale: false,
  scaleFontSize: 10,
  // tooltipFontSize: 14,
  tooltipCornerRadius: 2,
  tooltipTemplate: "<%= value %>"
}

var ctx_api = document.getElementById("linearChartApi").getContext("2d");
var linearChartApi = new Chart(ctx_api).Line(linearChartApiData, linearChartApiOptions);