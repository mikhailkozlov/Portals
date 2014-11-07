@section('title')
{{ $portal->title }} -
@stop

@section('container')
<h1>{{ $portal->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-lg-9 col-md-9">
        @if(!empty($page))
            {{ $page->content }}
        @else
            {{ $portal->description }}
        @endif
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-3 col-md-3">
        @include(Config::get('portals::layouts.portals.sidebar','portals::partials.sidebar'),$page)
    </div>
</div>
@stop