
<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom plan-selector">
        <div class="panel-body">
          <h4>API usage</h4>
          <h4><small>Last 30 days</small></h4>
          <canvas id="chart-stats-api" width="600" height="200"></canvas>
        </div>
      </div>
    </div>
</div>


<script>
$(document).ready(function() {
    var ChartStatsApiData = {
        labels : {!! json_encode(array_keys($stats)) !!},
        datasets : [
            {
                label: "API usage",
                fillColor : "rgba(230, 109, 76,0.2)",
                strokeColor : "rgba(230, 109, 76,1)",
                pointColor : "rgba(230, 109, 76,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(230, 109, 76,1)",
                data : {!! json_encode(array_values($stats)) !!}
            }
        ]
    }
    
    // Line charts options
    var ChartStatsApiOptions = {
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
    
    var ctx_api = document.getElementById("chart-stats-api").getContext("2d");
    var ChartStatsApi = new Chart(ctx_api).Line(ChartStatsApiData, ChartStatsApiOptions);
});
</script>
  
