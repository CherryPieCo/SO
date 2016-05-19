<!-- Start Header -->

    <div id="header">
    
        <div class="container">
            <div class="row">
                <div class="span12">
                
                    <h1><a href="/"><img src="/images/simpleoutreach-logo.png" /></a></h1>
                    <h2 class="menulink"><a href="#">Menu</a></h2>
                    
                    <!-- Start Menu -->
                    <div id="menu">
                        <ul>  
                            <li class="{{ Request::is('/') ? 'current' : '' }}"><a href="/">Home</a></li> 
                            <li class="{{ Request::is('features') ? 'current' : '' }}"><a href="/features">Features</a></li> 
                            <li class="{{ Request::is('pricing') ? 'current' : '' }}"><a href="/pricing">Pricing</a></li>
                            <li class="{{ Request::is('contact') ? 'current' : '' }}"><a href="/contact">Contact Us</a></li> 
                            @if (Sentinel::check())
                                <li><a href="/me/bulk">Dashboard</a></li> 
                            @else
                                <li><a href="javascript:void(0);" id="loginToggler">Sign In</a></li> 
                            @endif                
                            
                        </ul> 
                    </div> 
                    <!-- End Menu -->
                    
                </div>
                <div class="clearfix"></div>
            </div>
            
        </div>
    
    </div>

    <!-- End Header -->