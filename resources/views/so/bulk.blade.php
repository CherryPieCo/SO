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
    
  <div id="bulks-table-container">
    @include('so.partials.bulk_table')
  </div>
  
  @include('partials.upgrade_account')

@stop