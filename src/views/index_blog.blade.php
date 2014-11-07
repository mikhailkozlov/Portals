@section('title')
{{ $portal->title }} -
@stop

@section('container')
<h1>{{ $portal->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-lg-9 col-md-9">
        @if(!$pages->isEmpty())

            @foreach($pages as $i=>$page)
                @include(Config::get('portals::layouts.portals.blog_post','portals::partials.blog_post'),$page)
            @endforeach

            {{ $pages->links() }}
        @else
            <p class="alert alert-info">No posts yet. Post something.</p>
        @endif
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-3 col-md-3">
        @include(Config::get('portals::layouts.portals.sidebar','portals::partials.sidebar'),$page)
    </div>
</div>
@stop