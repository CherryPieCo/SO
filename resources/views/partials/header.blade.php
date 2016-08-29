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
                            <li><a href="/#features">Features</a></li> 
                            <li><a href="/#pricing">Pricing</a></li>
                            <li class="{{ Request::is('contact') ? 'current' : '' }}"><a href="/contact">Contact Us</a></li> 
                            @if (Sentinel::check())
                                <li><a href="/me/bulk">Dashboard</a></li>
                                <li>
                                    <a href="/me/logout" title="Log Out" 
                                       style="border: solid 1px rgba(255, 255, 255, 0.3); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">
                                        <i class="fa fa-sign-out"></i>
                                    </a>
                                </li> 
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