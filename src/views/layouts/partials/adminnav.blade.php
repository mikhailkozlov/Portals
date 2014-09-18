<nav class="navbar navbar-inverse navbar-default navbar-fixed-top subnav" id="subnavigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#subnavigation-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin.home') }}" title="Portal Admin Home"><i class="fa fa-home fa-lg"></i></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="subnavigation-collapse-1">
            <ul class="nav navbar-nav">
                @foreach (Config::get('cpanel::menu') as $title => $args)
                    @if ($args['type'] === 'single')
                        <li>{{ HTML::linkRoute($args['route'], $title) }}</li>
                    @else
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="blank.html#">
                                {{ $title }} <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($args['links'] as $title => $value)
                                <li>{{ HTML::linkRoute($value['route'], $title) }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
