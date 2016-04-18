
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
        <li><h4><small>0 / 150 requests</small></h4></li>
        <li><a href="#" class="btn btn-primary">Upgrade</a></li>            
      </ul>
    </div><!-- /.navbar-collapse -->
  </div>
</nav>

    