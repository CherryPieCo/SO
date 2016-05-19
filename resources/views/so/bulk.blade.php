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
                @if (Sentinel::getUser()->isCampaignAllowed('emails'))
                    <button type="button" class="btn btn-primary" onclick="App.modalEmails();">Create campaign</button>
                @else
                    <button type="button" class="btn btn-primary"><i class="fa fa-lock" aria-hidden="true"></i> Upgrade</button>
                @endif
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
                @if (Sentinel::getUser()->isCampaignAllowed('not_found'))
                    <button type="button" class="btn btn-primary" onclick="App.modalBrokenLinks();">Create campaign</button>
                @else
                    <button type="button" class="btn btn-primary"><i class="fa fa-lock" aria-hidden="true"></i> Upgrade</button>
                @endif
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
                @if (Sentinel::getUser()->isCampaignAllowed('backlinks'))
                    <button type="button" class="btn btn-primary" onclick="App.modalBacklink();">Create campaign</button>
                @else
                    <button type="button" class="btn btn-primary"><i class="fa fa-lock" aria-hidden="true"></i> Upgrade</button>
                @endif
              </div>
              <div class="clearfix"></div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
    
  @include('so.modals.create_bulk')
  @include('so.modals.delete_bulk')
    
  <div id="bulks-table-container">
    @include('so.partials.bulk_table')
  </div>
  
  @include('so.partials.upgrade_account')

@stop