@extends('layouts.so')

@section('main')

<div class="broken-link-builder-page">
<section class="container-fluid">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <!-- <div class="panel panel-default panel-custom plan-selector"> -->
            <!-- <div class="panel-body"47-> -->
            <h3 class="page-title">
                Link Profiler
                <div style="float: right;">
                    <a href="/me/bulk" class="btn btn-block btn-primary btn-sm">Back</a>
                </div>
            </h3>
            <div class="row">
                <div class="col-xs-6">
                    <form>
                        <label> Campaign:
                            <select onchange="window.location = '/me/bulk/'+this.value+'/profiler';">
                                <option value="{{ $pack->_id }}">{{ $pack->title }}</option>
                                @foreach ($pack->getLastProfilerBulksIds() as $latestPacks)
                                <option value="{{ $latestPacks->_id }}">{{ $latestPacks->title }}</option>
                                @endforeach
                            </select> 
                        </label>
                    </form>
                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>

    @include('so.partials.bulk_profiler_filters')

    <div class="col-md-10 col-md-offset-1">
        <p id="displayed-items-top" class="displayed-items"></p>
        <script id="displayed-items-top-template" into="displayed-items-top" type="text/html">
            Now you see only ~total~-filtered URLs of the total number of ~bulk_total~-URLs of the company.
        </script>
    </div>

    <div class="row content-table">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-custom">
                <div class="panel-heading">
                    <div class="row">
                        <!-- table header -->
                        <div class="col-xs-2">
                            <div class="checkbox" style="margin-top: 7px;">
                                <label>
                                    <input class="check-all check-all-top" type="checkbox" value="" onclick="Profiler.checkAll(this)">
                                    Check All </label>
                            </div>
                        </div>
                        <div class="col-xs-2 col-xs-offset-8 text-right">
                            <button type="button" class="btn btn-block btn-sm btn-default">
                                <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Backlink Page URL</th>
                                        <th class="th-sorter" onclick="Profiler.addOrderBy(this, 'contacts_count');">
                                            <i class="fa fa-fw fa-sort"></i>
                                            Contacts
                                        </th>
                                        <th>Status</th>
                                        <th class="th-sorter" onclick="Profiler.addOrderBy(this, 'page_authority');">
                                            <i class="fa fa-fw fa-sort"></i>
                                            <img src="/images/moz.gif" alt="moz icon"> 
                                            PA
                                        </th>
                                        <th class="th-sorter" onclick="Profiler.addOrderBy(this, 'domain_authority');">
                                            <i class="fa fa-fw fa-sort"></i>
                                            <img src="/images/moz.gif" alt="moz icon"> 
                                            DA
                                        </th>
                                        <th class="th-sorter" onclick="Profiler.addOrderBy(this, 'alexa_rank');">
                                            <i class="fa fa-fw fa-sort"></i>
                                            <img src="/images/alexa.png" alt="alexa icon"> 
                                            Alexa
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tr-container">
                                    <?php /*
                                    @foreach ($pack->getData() as $hash => $site)
                                        @if ($loop->index >= 25)
                                            @set('hide', true)
                                        @endif
                                        @include('so.partials.bulk_profiler_row')
                                    @endforeach
                                    */ ?>
                                    
                                    @include('so.partials.bulk_profiler_row_js')
                                    
                                    {{--
                                    <tr>
                                        <td class="text-center">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                <!-- Get Email --> </label>
                                        </div></td>
                                        <td class="sitename"><strong>Модуль Broken link building</strong><a href="#">https://docs.google.com/document/d/1Wek4MWXVX2wQbxUIdL/edit</a>
                                        <div class="status-icons">
                                            <i class="fa fa-envelope fa-lg brand-mail active" data-title="description text"></i>
                                            <i class="fa fa-list fa-lg brand-form active" style="position: relative; top: 1px;" data-title="description text"></i>
                                            <i class="fa fa-chain-broken fa-lg brand-link active" data-title="description text"></i>
                                            <i class="fa fa-facebook-official fa-lg brand-facebook active" data-title="description text"></i>
                                            <i class="fa fa-twitter fa-lg brand-twitter active" data-title="description text"></i>
                                            <i class="fa fa-pinterest fa-lg brand-pinterest active" data-title="description text"></i>
                                            <i class="fa fa-google-plus fa-lg brand-google active" data-title="description text"></i>
                                            <i class="fa fa-linkedin fa-lg brand-linkedin active" data-title="description text"></i>
                                        </div></td>
                                        <td><span class="badge">3245</span></td><!-- Contacts -->
                                        <td>
                                        <div class="status-icons mt-0 second-set">
                                            <i class="fa fa-audio-description fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-link fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-money fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-bold fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-pencil fa-lg active" data-title="description text"></i>
                                        </div></td><!-- Status -->
                                        <td>88</td><!-- PA -->
                                        <td>100</td><!-- DA -->
                                        <td>1 000 000</td><!-- Alex -->
                                    </tr>
                                    <tr class="advanced-info">
                                        <td></td>
                                        <td colspan="6">
                                        <div>
                                            <div class="advanced-info-wrapper">
                                                <div class="username">
                                                    <!-- <i class="fa fa-user" data-title="description text"></i> -->
                                                    Martin Scorsese
                                                </div>
                                                <div class="block-emails">
                                                    <i class="fa fa-envelope" data-title="description text"></i>
                                                    <a href="mailto:somebody@somesite.com">Theaticand1990@jourrapide.com</a>
                                                    <a href="mailto:somebody@somesite.com">samuel.ross@example.com</a>
                                                    <a href="mailto:somebody@somesite.com">tracy.edwards50@example.com</a>
                                                    <a href="mailto:somebody@somesite.com">hannah.terry51@example.com</a>
                                                    <a href="mailto:somebody@somesite.com">edward.franklin47@example.com</a>
                                                </div>
                                                <div class="block-contacts">
                                                    <i class="fa fa-info-circle" data-title="description text"></i>
                                                    <a href="#">About Us</a>
                                                    <a href="#">Contact Us</a>
                                                    <a href="#">Write Us</a>
                                                </div>
                                                <div class="block-socials">
                                                    <i class="fa fa-user" data-title="description text"></i>
                                                    <a href="#">Facebook</a>
                                                    <a href="#">Twitter</a>
                                                    <a href="#">Pinterest</a>
                                                    <a href="#">Google+</a>
                                                    <a href="#">LinkedIn</a>
                                                </div>
                                            </div>
                                            <!-- /.advanced-info-wrapper -->
                                        </div><!-- /.advanced-info --></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                <!-- Get Email --> </label>
                                        </div></td>
                                        <td class="sitename"><strong>Модуль Broken link building</strong><a href="#">https://docs.google.com/document/d/1Wek4MWXVX2wQbxUIdL/edit</a>
                                        <div class="status-icons">
                                            <i class="fa fa-envelope fa-lg brand-mail " data-title="description text"></i>
                                            <i class="fa fa-list fa-lg brand-form" style="position: relative; top: 1px;" data-title="description text"></i>
                                            <i class="fa fa-chain-broken fa-lg brand-link " data-title="description text"></i>
                                            <i class="fa fa-facebook-official fa-lg brand-facebook " data-title="description text"></i>
                                            <i class="fa fa-twitter fa-lg brand-twitter " data-title="description text"></i>
                                            <i class="fa fa-pinterest fa-lg brand-pinterest " data-title="description text"></i>
                                            <i class="fa fa-google-plus fa-lg brand-google " data-title="description text"></i>
                                            <i class="fa fa-linkedin fa-lg brand-linkedin " data-title="description text"></i>
                                        </div></td>
                                        <td><span class="badge">3245</span></td><!-- Contacts -->
                                        <td>
                                        <div class="status-icons mt-0 second-set">
                                            <i class="fa fa-audio-description fa-lg " data-title="description text"></i>
                                            <i class="fa fa-link fa-lg" data-title="description text"></i>
                                            <i class="fa fa-money fa-lg " data-title="description text"></i>
                                            <i class="fa fa-bold fa-lg " data-title="description text"></i>
                                            <i class="fa fa-pencil fa-lg" data-title="description text"></i>
                                        </div></td><!-- Status -->
                                        <td>88</td><!-- PA -->
                                        <td>100</td><!-- DA -->
                                        <td>1 000 000</td><!-- Alex -->
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                <!-- Get Email --> </label>
                                        </div></td>
                                        <td class="sitename"><strong>Модуль Broken link building</strong><a href="#">https://docs.google.com/document/d/1Wek4MWXVX2wQbxUIdL/edit</a>
                                        <div class="status-icons">
                                            <i class="fa fa-envelope fa-lg brand-mail active" data-title="description text"></i>
                                            <i class="fa fa-list fa-lg brand-form active" style="position: relative; top: 1px;" data-title="description text"></i>
                                            <i class="fa fa-chain-broken fa-lg brand-link active" data-title="description text"></i>
                                            <i class="fa fa-facebook-official fa-lg brand-facebook " data-title="description text"></i>
                                            <i class="fa fa-twitter fa-lg brand-twitter active" data-title="description text"></i>
                                            <i class="fa fa-pinterest fa-lg brand-pinterest " data-title="description text"></i>
                                            <i class="fa fa-google-plus fa-lg brand-google active" data-title="description text"></i>
                                            <i class="fa fa-linkedin fa-lg brand-linkedin active" data-title="description text"></i>
                                        </div></td>
                                        <td><span class="badge">3245</span></td><!-- Contacts -->
                                        <td>
                                        <div class="status-icons mt-0 second-set">
                                            <i class="fa fa-audio-description fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-link fa-lg " data-title="description text"></i>
                                            <i class="fa fa-money fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-bold fa-lg active" data-title="description text"></i>
                                            <i class="fa fa-pencil fa-lg " data-title="description text"></i>
                                        </div></td><!-- Status -->
                                        <td>88</td><!-- PA -->
                                        <td>100</td><!-- DA -->
                                        <td>1 000 000</td><!-- Alex -->
                                    </tr>
                                    --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <!-- table header -->
                        <div class="col-xs-2">
                            <div class="checkbox" style="margin-top: 7px;">
                                <label>
                                    <input class="check-all check-all-bottom"  type="checkbox" value="" onclick="Profiler.checkAll(this)">
                                    Check all </label>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group leave-on-one-line">
                                <button type="button" class="btn btn-sm btn-default" onclick="Profiler.remove();">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                                </button>
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a onclick="Profiler.removeAll();" href="javascript:void(0);">Delete All</a>
                                    </li>
                                    {{-- 
                                    <li>
                                        <a href="javascript:void(0);">Blacklist</a>
                                    </li>
                                    --}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-5 text-right">
                            <p id="displayed-items" class="displayed-items"></p>
                            <script id="displayed-items-template" into="displayed-items" type="text/html">
                                Showing <strong>~from~ to ~to~</strong> of <strong>~total~</strong> entries
                            </script>
                        </div>
                        <div class="col-xs-3 text-right">
                            <form class="form-inline">
                                <div class="form-group form-group-sm leave-on-one-line">
                                    <label for="">Show on page: </label>
                                    <select class="form-control" onchange="Profiler.changePerPage(this)">
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="99999">All</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <nav>
                        <ul id="pagination-wrapper" class="pagination pagination-sm"></ul>
                        
                        <script id="pagination" into="pagination-wrapper" type="text/html">
                            <li class="~class~">
                                <a onclick="Profiler.changePage(this, ~index~);" href="javascript:void(0);">~index~</a>
                            </li>
                        </script>
                        {{--
                            <li class="disabled">
                                <a href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
                            </li>
                            <li class="active">
                                <a href="#">1</a>
                            </li>
                            <li>
                                <a href="#">5</a>
                            </li>
                            <li>
                                <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a>
                            </li>  
                        --}}
                    </nav>
                </div>
            </div>
        </div>
    </div>

</section>
</div>

@include('so.modals.no_checkboxes')

@stop

@section('styles')
<link href="/css/bootstrap/bootstrap-slider.min.css" rel="stylesheet">
<style>
.th-sorter {
    cursor: pointer;
    white-space: nowrap;
}
.open-advanced-info {
    cursor: pointer;
}
.th-sorter i.fa {
    float: left;
}
.truncate {
    overflow: hidden;
    width: 400px;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.leave-on-one-line {
    width: 165px;
    overflow: hidden;
    white-space: nowrap;
}
</style>
@stop

@section('scripts')
<script src="/js/underscore-min.js"></script>
<script src="/js/tangular.min.js"></script>
<script src="/js/bootstrap-slider.min.js"></script>
<script src="/js/profiler.js"></script>

<script>
Profiler._id = '{{ $pack->_id }}';
Profiler.total = {{ count($pack->getData()) }};
Profiler.sites = [
@foreach ($pack->getData() as $hash => $site)
    {
        hash: '{{ $hash }}',
        url: '{{ $site['url'] }}',
        title: '{{ trim(addslashes(mb_strtolower((!isset($site['title']) || !$site['title'] ? '[notitle]' : $site['title'])))) }}',
        tld: '{{ mb_strtolower($site['tld']) }}',
        emails: {!! json_encode(array_values(array_get($site, 'parsers.email.data.emails', []))) !!},
        has_email: {{ array_get($site, 'parsers.email.data.emails', []) ? 'true' : 'false' }},
        has_contacts: {{ array_get($site, 'parsers.email.data.contacts', []) ? 'true' : 'false' }},
        has_social_profiles: {{ array_get($site, 'parsers.email.data.social', []) ? 'true' : 'false' }},
        has_facebook: {{ array_get($site, 'parsers.email.data.social.facebook', []) ? 'true' : 'false' }},
        has_twitter: {{ array_get($site, 'parsers.email.data.social.twitter', []) ? 'true' : 'false' }},
        has_pinterest: {{ array_get($site, 'parsers.email.data.social.pinterest', []) ? 'true' : 'false' }},
        has_gplus: {{ array_get($site, 'parsers.email.data.social.gplus', []) ? 'true' : 'false' }},
        has_linkedin: {{ array_get($site, 'parsers.email.data.social.linkedin', []) ? 'true' : 'false' }},
        domain_authority: {{ array_get($site, 'parsers.moz.data.pda', 0) }},
        page_authority: {{ array_get($site, 'parsers.moz.data.upa', 0) }},
        alexa_rank: {{ array_get($site, 'parsers.alexa.data.rank', 0) }},
        pages: {!! json_encode(array_keys(array_get($site, 'parsers.pages.data', []))) !!},
        contacts_count: {{ count(array_get($site, 'parsers.email.data.emails', [])) }},
        contacts: {{ count(array_get($site, 'parsers.email.data.contacts', [])) }},
        pages: {
            advertising: {{ array_get($site, 'parsers.pages.data.advertising') ? 'true' : 'false' }},
            useful: {{ array_get($site, 'parsers.pages.data.useful') ? 'true' : 'false' }},
            donate: {{ array_get($site, 'parsers.pages.data.donate') ? 'true' : 'false' }},
            blog: {{ array_get($site, 'parsers.pages.data.blog') ? 'true' : 'false' }},
            guest: {{ array_get($site, 'parsers.pages.data.guest') ? 'true' : 'false' }}
        },
        social: [
            @foreach (array_get($site, 'parsers.email.data.social', []) as $socialName => $socialLinks) 
                @foreach ($socialLinks as $socialLink) 
                    {
                        link: '{{ $socialLink }}',
                        title: '{{ $socialName }}',
                    },
                @endforeach
            @endforeach
        ]
    },
@endforeach
];
</script>
@stop
