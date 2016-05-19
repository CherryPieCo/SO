@extends('layouts.so')


@section('main')

  @include('so.partials.stats_chart')
    
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom plan-selector">
        <div class="panel-body">
          <h4>API secret keys</h4>
          <h4><small>Your API keys are like your password: make sure to always keep them hidden!</small></h4>
          <table class="table table-responsive table-hover table-custom">
            <tbody>
              <tr>
                <td style="white-space: nowrap;">API key</td>
                <td><code>{{ $token }}</code></td>
              </tr>
            </tbody>                  
          </table>  
        </div>
      </div>
    </div>
  </div>
    
  @include('so.partials.upgrade_account')

@stop

@section('scripts')
    <script src="/js/Chart.min.js"></script>
@stop

