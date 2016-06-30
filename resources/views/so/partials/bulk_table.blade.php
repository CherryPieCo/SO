<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom">
        <div class="panel-body">
          <table id="bulk-table" class="table table-responsive table-hover table-custom">
            <thead>
              <tr>
                <th>List name</th>
                <th>Type</th>
                <th class="text-center">List size</th>
                <th class="text-center">Creation date</th>
                <th class="text-center">Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>  
              
              @foreach ($bulks as $bulk)
                <tr class="bulk-tr">
                    <td>{{ $bulk->title }}</td>
                    <td>{{ $bulk->type }}</td>
                    <td class="text-center">{{ $bulk->getCompletedUrlsCount() }} / {{ $bulk->getUrlsCount() }}</td>
                    <td class="text-center">{{ date('d/m/Y', $bulk->created_at) }}</td>
                    <td class="text-center">
                        @if ($bulk->isComplete())
                            <strong class="text-success text-uppercase">Ok</strong>
                        @else
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                  in progress
                                </div>
                            </div>
                        @endif
                    </td>
                    <td class="text-right">
                      @if ($bulk->isComplete())
                        <a {!! $bulk->isBacklinksType() ? 'onclick="App.downloadBacklinkXls(this);return false;"' : '' !!} href="/me/bulk/{{ $bulk->id }}/xls/download" target="_blank" class="btn btn-xs btn-default">
                            <i class="fa fa-download"></i>
                        </a>
                      @endif
                      @if (Sentinel::getUser()->isSuperuser())
                        <a href="/me/bulk/{{ $bulk->id }}/xls/download?dr=dr" target="_blank" class="btn btn-xs btn-default">
                            <i class="fa fa-heart"></i>
                        </a>
                      @endif
                      <a onclick="App.removeBulk(this, '{{ $bulk->id }}');" href="javascript:void(0);" class="btn btn-xs btn-link">
                          <i class="fa fa-times"></i>
                      </a>
                    </td>
                </tr>
              @endforeach
              
            </tbody>  
          </table>
    
          <div class="row table-controls">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label" for="selectQuantity">Show: </label>
                <select name="selectQuantity" onchange="App.setBulksPerPage(this.value);">
                  <option value="20" @if(session('bulks-per-page', 20) == 20) selected @endif>20 items</option>
                  <option value="50" @if(session('bulks-per-page') == 50) selected @endif>50 items</option>
                  <option value="100" @if(session('bulks-per-page') == 100) selected @endif>100 items</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 text-right">
                {!! $bulks->render() !!}
            </div>
          </div>             
        </div>
      </div>
    </div>
  </div>
  

<script id="bulk-tr-template" type="text/html">
    <tr class="bulk-tr">
        <td>~title~</td>
        <td>~type~</td>
        <td class="text-center">0 / ~count~</td>
        <td class="text-center">{{ date('d/m/Y') }}</td>
        <td class="text-center">
            <div class="progress">
                <div class="progress-bar progress-bar-striped active" role="progressbar"
                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                  in progress
                </div>
            </div>
        </td>
        <td class="text-right">
          <a onclick="App.removeBulk(this, '~id~');" href="javascript:void(0);" class="btn btn-xs btn-link">
              <i class="fa fa-times"></i>
          </a>
        </td>
    </tr>
</script>

