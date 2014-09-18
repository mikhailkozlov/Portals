<div class="navbar navbar-inverse navbar-static-top" id="navigation" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation_collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">Content</a>
        </div>
        <div class="navbar-collapse collapse" id="navigation_collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="{{ route('admin.portals.view') }}">
                        Portals <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.portals.view') }}">Manage Portals</a></li>
                        <li role="presentation" class="divider"></li>
                        <li><a href="#">List of Portals</a></li>
                        <li><a href="#">List of Portals</a></li>
                        <li><a href="#">List of Portals</a></li>
                        <li><a href="#">List of Portals</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.files.store') }}">Files</a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    @if( Sentry::check() )
                        <a href="#">{{ htmlEncode($user->username) }}</a>
                    @else
                        <a href="{{ URL::route('user.login') }}?redirect={{ Request::path() }}">Login</a>
                    @endif
                </li>
            </ul>
        </div><!--/.navbar-collapse -->
    </div>
</div>
