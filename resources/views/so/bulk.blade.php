@extends('layouts.so')


@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom">
        <div class="panel-heading">
          <h2>Bulks</h2>
          <h4>Create your campaign</h4>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="wrapper">
              <div class="col-sm-8 col-xs-12">
                <h4><span class="icon-envelope"></span> Email Finder</h4>
                <p>Find the Email from URL list</p>
              </div>
              <div class="col-sm-4 col-xs-12 text-right">
                <button type="button" class="btn btn-primary" onclick="App.modalEmails();">Create campaign</button>
              </div>
              <div class="clearfix"></div>
            </div>  
          </div>
          <div class="row">
            <div class="wrapper">
              <div class="col-sm-8 col-xs-12">
                <h4><span class="icon-fire"></span> 404 Broken links Checker</h4>
                <p>Find broken links on page</p>
              </div>
              <div class="col-sm-4 col-xs-12 text-right">
                <button type="button" class="btn btn-primary" onclick="App.modalBrokenLinks();">Create campaign</button>
              </div>
              <div class="clearfix"></div>
            </div>  
          </div>
          <div class="row">
            <div class="wrapper">
              <div class="col-sm-8 col-xs-12">
                <h4><span class="icon-link"></span> Backlink checker</h4>
                <p>Find backlinks by url</p>
              </div>
              <div class="col-sm-4 col-xs-12 text-right">
                <button type="button" class="btn btn-primary" onclick="App.modalBacklink();">Create campaign</button>
              </div>
              <div class="clearfix"></div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
    
  @include('so.modals.create_bulk')
    
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default panel-custom">
        <div class="panel-body">
          <table class="table table-responsive table-hover table-custom">
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
                        <a href="/me/bulk/{{ $bulk->id }}/xls/download" target="_blank" class="btn btn-xs btn-default">
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
                <select name="selectQuantity">
                  <option value="20">20 items</option>
                  <option value="50">50 items</option>
                  <option value="100">100 items</option>
                </select>
              </div>
            </div>
            <div class="col-md-6 text-right">
                {!! $bulks->render() !!}
             {{--
              <nav>
                <ul class="pagination pagination-sm">
                  <li class="disabled">
                    <a href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li>
                    <a href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              </nav>
              --}} 
            </div>
          </div>             
        </div>
      </div>
    </div>
  </div>
    
  @include('partials.upgrade_account')

@stop