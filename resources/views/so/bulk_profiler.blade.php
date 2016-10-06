@extends('layouts.so')

@section('main')

<div class="broken-link-builder-page">
<section class="container-fluid">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <!-- <div class="panel panel-default panel-custom plan-selector"> -->
            <!-- <div class="panel-body"> -->
            <h3 class="page-title">Link Profiler</h3>
            <div class="row">
                <div class="col-xs-6">
                    <form>
                        <label> Campaign:
                            <select tabindex="1">
                                <option>Heineken</option>
                                <option>Carlsberg</option>
                                <option>Stella Artois</option>
                                <option>Cronenberg ronenberg</option>
                                <option>Guiness</option>
                                <option>Amstel</option>
                                <option>Corona</option>
                            </select> </label>
                    </form>
                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-custom">
                <div class="panel-heading filters-section">
                    <div class="row">
                        <!-- basik filters -->
                        <div class="col-sm-3">
                            <h6>Additional</h6>
                            <div class="checkbox small">
                                <label>
                                    <input type="checkbox" value="">
                                    Get Email </label>
                            </div>
                            <div class="checkbox small">
                                <label>
                                    <input type="checkbox" value="">
                                    Contact Form </label>
                            </div>
                            <div class="checkbox small">
                                <label>
                                    <input type="checkbox" value="">
                                    Social Profile </label>
                            </div>
                            <div class="checkbox small">
                                <label>
                                    <input type="checkbox" value="">
                                    Bad Links </label>
                            </div>
                        </div>
                        <!-- /"Additional" -->
                        <div class="col-sm-3">
                            <h6>Domain Authority</h6>
                            <div>
                                <!-- Info for using this slider -->
                                <!-- https://github.com/seiyria/bootstrap-slider -->
                                <input id="slider-da" type="text" class="span2" value="" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="[20,90]"/>
                            </div>
                        </div>
                        <!-- /"Domain Authority" -->
                        <div class="col-sm-3">
                            <h6>Alexa Rank</h6>
                            <div>
                                <!-- Info for using this slider -->
                                <!-- https://github.com/seiyria/bootstrap-slider -->
                                <input id="slider-ar" type="text" class="span2" value="" data-slider-min="0" data-slider-max="150000" data-slider-step="1" data-slider-value="[60000,100000]"/>
                            </div>
                        </div>
                        <!-- /"Alexa Rank" -->
                        <div class="col-sm-3" style="padding-top: 2em;">
                            <a href="#" class="btn btn-block btn-primary">Search</a>
                            <a href="#" class="btn btn-block btn-default btn-sm btn-advanced"> Advanced <span class="glyphicon glyphicon-menu-down" aria-hidden="true"> </a>
                        </div>
                    </div>
                    <!-- /basik filters -->
                    <div class="row advanced-inner">
                        <div class="col-xs-12">
                            <div class="row advanced-filters">
                                <!-- .advanced-filters -->
                                <div class="advanced-filters-inner">
                                    <div class="col-sm-2">
                                        <label> <h6>Advertise opportunities</h6>
                                            <select tabindex="1">
                                                <option>donate</option>
                                                <option>useful links</option>
                                            </select> </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label> <h6>Links by type</h6>
                                            <select tabindex="1">
                                                <option>comment</option>
                                                <option>forum</option>
                                                <option>profile</option>
                                            </select> </label>
                                    </div>
                                    <div class="col-sm-2">
                                        <label> <h6>Domain</h6>
                                            <select tabindex="1">
                                                <option>.com</option>
                                                <option>.org</option>
                                                <option>.net</option>
                                                <option>.co.uk</option>
                                            </select> </label>
                                    </div>
                                    <div class="col-sm-3">
                                        <form>
                                            <label> <h6>Find by URL</h6>
                                                <input type="text">
                                            </label>
                                        </form>
                                    </div>
                                    <div class="col-sm-3">
                                        <form>
                                            <label> <h6>Find by title</h6>
                                                <input type="text">
                                            </label>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.advanced-filters-inner -->
                            </div>
                            <!-- /.advanced-filters -->
                            <div class="row applied-filters">
                                <!-- .applied-filters -->
                                <div class="applied-filters-inner">
                                    <div class="col-sm-2">
                                        <h6>Applied filters:</h6>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            filter #1
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            filter #2
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            another filter #2
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            filter #3
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            filter #4
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            filter #5
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            another filter #5
                                        </div>
                                        <div class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            just another filter
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-block btn-xs btn-default">
                                            Remove all filters
                                        </button>
                                    </div>
                                </div>
                                <!-- /.applied-filters-inner -->
                            </div>
                            <!-- /.applied-filters -->
                        </div>
                    </div>
                    <!-- /.advanced-inner -->
                </div>
                <!-- /.panel-heading -->
            </div>
        </div>
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
                                    <input type="checkbox" value="">
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
                                        <th>Contacts</th>
                                        <th>Status</th>
                                        <th><img src="/images/moz.gif" alt="moz icon"> PA</th>
                                        <th><img src="/images/moz.gif" alt="moz icon"> DA</th>
                                        <th><img src="/images/alexa.png" alt="alexa icon"> Alexa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($pack->getData() as $hash => $site)
                                        @include('so.partials.bulk_profiler_row')
                                    @endforeach
                                    
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
                                    <input type="checkbox" value="">
                                    Check all </label>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete
                                </button>
                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Delete All</a>
                                    </li>
                                    <li>
                                        <a href="#">Blacklist</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-5 text-right">
                            <p class="displayed-items">
                                Showing <strong>1 to 25</strong> of <strong>177</strong> entries
                            </p>
                        </div>
                        <div class="col-xs-3 text-right">
                            <form class="form-inline">
                                <div class="form-group form-group-sm">
                                    <label for="">Show on page: </label>
                                    <select class="form-control">
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
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
                        <ul class="pagination pagination-sm">
                            <li class="disabled">
                                <a href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a>
                            </li>
                            <li class="active">
                                <a href="#">1</a>
                            </li>
                            <li>
                                <a href="#">2</a>
                            </li>
                            <li>
                                <a href="#">3</a>
                            </li>
                            <li>
                                <a href="#">4</a>
                            </li>
                            <li>
                                <a href="#">5</a>
                            </li>
                            <li>
                                <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

</section>
</div>

@stop

@section('styles')
<link href="/css/bootstrap/bootstrap-slider.min.css" rel="stylesheet">
@stop

@section('scripts')
<script src="/js/bootstrap-slider.min.js"></script>

<script>
    $(function() {
        $("#slider-da, #slider-ar").slider({
            tooltip : 'always'
        });

        $('.btn-advanced').on('click', function() {
            $('.advanced-inner').toggle();
            return false;
        });
    }); 
</script>

@stop
