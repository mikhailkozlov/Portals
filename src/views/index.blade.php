@section('title')
{{ $portal->title }} -
@stop

@section('container')
<h1>{{ $portal->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-2 col-lg-2 col-md-2">
        <div class="panel panel-default">

            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked">
                    @foreach ($portalMenu as $section)
                    <li>
                        @if(Request::is($section['link']))
                            <a class="active" href="{{ url($section['link']) }}">{{$section['title']}}</a>
                        @else
                            <a href="{{ url($section['link']) }}">{{$section['title']}}</a>
                        @endif
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


        @if(!empty($page))
            <p>{{ $page->content }}</p>
        @else
            {{ $portal->description }}
        @endif

    </div>
    <div class="col-xs-12 col-sm-2 col-lg-2 col-md-2">
        <h3>Quick Links</h3>
    </div>
</div>
@stop