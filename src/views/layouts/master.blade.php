<!DOCTYPE html>
<html lang="en" class="env_<?php echo App::environment(); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="SugarCRM Inc.">

    <title>@if(isset($title)) {{ $title }} | @else @yield('title') @endif</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('/packages/sugarcrm/portals/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('/packages/sugarcrm/portals/bootstrap/css/bootstrap-theme.min.css') }}
    {{ HTML::style('/packages/sugarcrm/portals/bootstrap/css/doc.min.css') }}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {{ HTML::script('/packages/sugarcrm/portals/js/html5shiv.min.js') }}
    <![endif]-->
</head>
<body class="{{ Request::segment(1) }} {{ Request::segment(2) }}">
    <div id="alert" class="alert-top" style="z-index: 10100"></div>

    @include(Config::get('portals::layouts.navbar','portals::layouts.partials.nav'))

    @if(!is_null(\Request::segment(1)))
        <div class="smalltron">
            <div class="container">
                <ol class="breadcrumb">
                    <li><a href="{{ Config::get('portal.home_page') }}">Home</a></li>
                    @yield('crumb')
                </ol>
            </div>
        </div>
    @endif

    <div id="global-popup-alert" class="alert-top">
        @if ( Session::has('app_message') )
            @foreach (Session::get('app_message') as $type=>$errors)
                <div class="alert alert-{{$type}} alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ implode('<br />',$errors)}}
                </div>
            @endforeach
        @endif
    </div>
    <!-- container -->
    <div class="container">
        @yield('h1')

        @include('portals::layouts.partials.alert')

        @if(isset($container))
            {{ $container }}
        @else
            @section('container')
                <div class="row">
                    <div class="col-lg-8">
                        @yield('main')
                    </div>
                    <div class="col-lg-4">
                        @yield('sidebar')
                    </div>
                </div>
            @show
        @endif
    </div>
    <!-- /container -->

    <!-- footer -->
    <footer>
        @yield('footer')
    </footer>
    <!-- /footer -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script('/packages/sugarcrm/portals/bootstrap/js/bootstrap.min.js') }}

    @yield('javascript')

</body>
</html>
