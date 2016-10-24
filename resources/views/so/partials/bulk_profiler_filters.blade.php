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
                                <input type="checkbox" value="1" id="filter-by-has-email" class="filter-input">
                                Get Email </label>
                        </div>
                        <div class="checkbox small">
                            <label>
                                <input type="checkbox" value="1" id="filter-by-has-contact-form" class="filter-input">
                                Contact Form </label>
                        </div>
                        <div class="checkbox small">
                            <label>
                                <input type="checkbox" value="1" id="filter-by-has-social-profile" class="filter-input">
                                Social Profile </label>
                        </div>
                        <div class="checkbox small">
                            <label style="text-decoration: line-through;">
                                <input type="checkbox" value="" disabled>
                                Bad Links </label>
                        </div>
                    </div>
                    <!-- /"Additional" -->
                    <div class="col-sm-3">
                        <h6>Domain Authority</h6>
                        <div>
                            <!-- Info for using this slider -->
                            <!-- https://github.com/seiyria/bootstrap-slider -->
                            <input id="slider-da" type="text" class="span2" value="" data-slider-step="0.000000000001" data-slider-min="{{$pack->getLowestPda()}}" data-slider-max="{{$pack->getHighestPda()}}" data-slider-step="1" data-slider-value="[{{$pack->getLowestPda()}},{{$pack->getHighestPda()}}]"/>
                        </div>
                    </div>
                    <!-- /"Domain Authority" -->
                    <div class="col-sm-3">
                        <h6>Alexa Rank</h6>
                        <div>
                            <!-- Info for using this slider -->
                            <!-- https://github.com/seiyria/bootstrap-slider -->
                            <input id="slider-ar" type="text" class="span2" value="" data-slider-min="{{$pack->getLowestAlexaRank()}}" data-slider-max="{{$pack->getHighestAlexaRank()}}" data-slider-step="1" data-slider-value="[{{$pack->getLowestAlexaRank()}},{{$pack->getHighestAlexaRank()}}]"/>
                        </div>
                    </div>
                    <!-- /"Alexa Rank" -->
                    <div class="col-sm-3" style="padding-top: 2em;">
                        <a href="javascript:void(0)" onclick="Profiler.search();" class="btn btn-block btn-primary">Search</a>
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
                                    <label> 
                                        <h6>Advertise opportunities</h6>
                                        <select id="filter-by-advertise-type" class="filter-input">
                                            <option></option>
                                            @foreach ($pack->getPageTypes() as $pageType => $pageTypeCaption)
                                                <option value="{{ $pageType }}">{{ $pageTypeCaption }}</option>
                                            @endforeach
                                        </select> 
                                    </label>
                                </div>
                                <div class="col-sm-2">
                                    <label> <h6 style="text-decoration: line-through;">Links by type</h6>
                                        <select disabled>
                                            <option></option>
                                        </select> </label>
                                </div>
                                <div class="col-sm-2">
                                    <label> <h6>Top-level Domain</h6>
                                        <select id="filter-by-tld" class="filter-input">
                                            <option></option>
                                            @foreach ($pack->getTlds() as $tld)
                                                <option value="{{ $tld }}">.{{ $tld }}</option>
                                            @endforeach
                                        </select> 
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label> 
                                        <h6>Find by URL</h6>
                                        <input id="filter-by-url" type="text" class="filter-input">
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <label> 
                                        <h6>Find by title</h6>
                                        <input id="filter-by-title" type="text" class="filter-input">
                                    </label>
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
                                    <div id="applied-filters"></div>
                                    <script id="single-close" into="applied-filters" type="text/html">
                                        <div id="applied-filter-~type~" class="alert alert-inline alert-warning alert-dismissible" role="alert">
                                            <button onclick="Profiler.removeFilter('~type~')" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            ~title~
                                        </div>
                                    </script>
                                </div>
                                <div class="col-sm-3">
                                    <button onclick="Profiler.removeAllFilters();" class="btn btn-block btn-xs btn-default">
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