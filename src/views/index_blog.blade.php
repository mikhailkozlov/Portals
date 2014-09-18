@section('title')
{{ $portal->title }} -
@stop

@section('container')
<h1>{{ $portal->title }}</h1>
<div class="row">
    <div class="col-xs-12 col-sm-9 col-lg-9 col-md-9">
        @foreach($pages as $i=>$page)
            <article>
                <h3>{{ $page->title }}</h3>
                <div class="datetime muted">{{ $page->created_at->format('F j, Y') }}</div>
                <p>{{ $page->excerpt }}</p>
                <p><a href="{{ url($portal->slug.'/'.$page->slug) }}">Read More</a></p>
            </article>
        @endforeach
    </div>
    <div class="col-xs-12 col-sm-3 col-lg-3 col-md-3">
        <h3>Quick Links</h3>
    </div>
</div>
@stop