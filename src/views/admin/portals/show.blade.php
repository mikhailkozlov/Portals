@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Content Portals</a></li>
<li class="active">{{ $portal->title }}</li>
@stop


@section('title')
{{ $portal->title }} - Admin -
@stop

@section('container')

<div class="row">
    <div class="col-sm-9">
        <h1>{{ $portal->title }}</h1>

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Basic portal settings.</p>
    </div>
</div>
@stop