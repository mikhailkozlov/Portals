@section('title')
{{ $page->title }} - {{ $portal->title }} -
@stop

@section('container')
<h1>{{ $page->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-2 col-lg-2 col-md-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    @foreach ($portalMenu as $section)
                    <li @if(Request::is($section['link'])) class="active" @endif>
                        <a  href="{{ url($section['link']) }}">{{$section['title']}}</a>
                        <ul class="nav nav-pills nav-stacked">
                            @foreach ($section['children'] as $child)
                            @if(Request::is($child['link']))
                            <li><a class="active" href="{{ url($child['link']) }}">{{$child['title']}}</a></li>
                            @else
                            <li><a href="{{ url($child['link']) }}">{{$child['title']}}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-lg-8 col-md-8">
        <p>{{ $page->content }}</p>
    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2 col-md-2">
        <h3>Quick Links</h3>
    </div>
</div>
@stop