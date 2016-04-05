@extends('layouts.so')


@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom plan-selector">
        <div class="panel-body">
          <h4>API usage</h4>
          <h4><small>Last 30 days</small></h4>
          <canvas id="linearChartApi" width="600" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
    
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom plan-selector">
        <div class="panel-body">
          <h4>API secret keys</h4>
          <h4><small>Your API keys are like your password: make sure to always keep them hidden!</small></h4>
          <table class="table table-responsive table-hover table-custom">
            <tbody>
              <tr>
                <td>API key</td>
                <td>{{ $token }}</td>
              </tr>
            </tbody>                  
          </table>  
        </div>
      </div>
    </div>
  </div>
    
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom plan-selector">
        <div class="panel-body">
          <h4>Upgrade my account</h4>
          <p><strong>Select your new plan</strong></p>
          <div class="row">
            <div class="col-xs-8">
              <label>
                <input type="radio" name="select-plan" value="">
                <span>
                  <strong class="text-primary">Starter</strong>
                  <p>1,000 requests / month</p>
                </span>
              </label>
            </div>
            <div class="col-xs-4">
              <div class="col-sm-6 text-right"><h5>$49.00</h5></div>
              <div class="col-sm-6 text-right">
                <img src="https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif" alt="PayPal button">
              </div>
            </div>  
          </div>
          <div class="row">
            <div class="col-xs-8">
              <label>
                <input type="radio" name="select-plan" value="">
                <span>
                  <strong class="text-primary">Growth</strong>
                  <p>5,000 requests / month</p>
                </span>
              </label>
            </div>
            <div class="col-xs-4">
              <div class="col-sm-6 text-right"><h5>$99.00</h5></div>
              <div class="col-sm-6 text-right">
                <img src="https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif" alt="PayPal button">
              </div>
            </div>  
          </div>
          <div class="row">
            <div class="col-xs-8">
              <label>
                <input type="radio" name="select-plan" value="">
                <span>
                  <strong class="text-primary">Pro</strong>
                  <p>20,000 requests / month</p>
                </span>
              </label>
            </div>
            <div class="col-xs-4">
              <div class="col-sm-6 text-right"><h5>$199.00</h5></div>
              <div class="col-sm-6 text-right">
                <img src="https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif" alt="PayPal button">
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>

@stop

@section('scripts')
    <script src="/js/Chart.min.js"></script>
    <script src="/js/drawing-chart-api.js"></script>
@stop

