@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Content Portals</a></li>
<li class="active">{{{ $portal->title ? $portal->title : 'Create portal' }}}</li>
@stop

@section('title')
{{ $portal->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>{{{ $portal->title ? $portal->title : 'Create portal' }}}</h1>

        {{Former::horizontal_open( route('admin.portals.update', array($portal->id)), 'PUT') }}

        {{ Former::text('title','Title',Input::old('title'))
        ->value($portal->title)
        ->required() }}

        {{ Former::text('slug','Slug',Input::old('slug'))
        ->value($portal->slug)
        ->required() }}

        {{ Former::textarea('description','Description', \Input::old('description') )
        ->value($portal->description)
        ->required()
        ->rows(5)->columns(20) }}

        {{ Former::select('status','Status')
        ->options($portal->status_opt, $portal->status) }}

        {{ Former::textarea('keywords','Keywords', \Input::old('keywords') )
        ->value($portal->keywords)
        ->rows(5)->columns(20) }}

        {{ Form::submit('Submit', array('class'=>'btn btn-primary')) }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Basic portal settings.</p>
    </div>
</div>
@stop