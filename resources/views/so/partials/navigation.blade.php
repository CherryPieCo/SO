
<nav class="navbar navbar-default navbar-inverse navbar-custom" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
        <img src="/images/simpleoutreach-logo.png" alt="SimpleOutreach-logo">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('me/bulk') ? 'active' : '' }}"><a href="/me/bulk"><i class="fa fa-list"></i> Bulk</a></li>
        <li class="{{ Request::is('me/api') ? 'active' : '' }}"><a href="/me/api"><i class="fa fa-tachometer"></i> API</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
            <h4>
                <small>
                    {{ Sentinel::getUser()->getCurrentRequests() }} 
                    @if (!Sentinel::getUser()->isProType())
                     / {{ Sentinel::getUser()->getMaximumRequests() }}
                    @endif
                    requests
                </small>
            </h4>
        </li>
        
        {{--
        <li>
              <a href="#" class="btn btn-success">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219.376 219.376"><path d="M40.6 219.4h138c6.8 0 12-5.4 12-12V59.2c0-3.2-1-6.2-3.4-8.5L136 3.4c-2.4-2.2-5.3-3.4-8.5-3.4h-87c-6.5 0-12 5.4-12 12v195.4c0 6.6 5.5 12 12 12zm89.8-195.7l35 32.6h-34c-.5 0-1-.5-1-1V23.6zM43.6 15h71.8v40.2c0 9 7.2 16 16 16h44.3v133.2h-132V15zM57 178.6h106.6v-87H57v87zm60.7-72h31v8.7h-31v-8.7zm0 23.7h31v9.7h-31v-9.7zm0 24.7h31v8.6h-31V155zM72 106.6h30.7v8.7H72v-8.7zm0 23.7h30.7v9.7H72v-9.7zm0 24.7h30.7v8.6H72V155z" fill="#FFF"/></svg>
              SimpleOutreach App
            </a>
        </li>  
        --}}
        <li><a href="#" class="btn btn-primary">Upgrade</a></li>      
        <li><a href="/me/logout" class="btn btn-link btn-logout" title="Log Out"><i class="fa fa-sign-out"></i></a></li>      
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>

    