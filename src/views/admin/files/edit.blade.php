@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.files.view') }}">Files</a></li>
<li class="active">{{ $file->title }}</li>
@stop

@section('title')
{{ $file->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>{{ $file->title }}</h1>

        {{Former::vertical_open( route('admin.files.update', array($file->id)), 'PUT') }}

        {{ Former::populate($file) }}

        {{ Former::select('group_id','User group')->options($userGroups) }}

        {{ Former::textarea('description','Description')->rows(5)->columns(20) }}

        {{ Former::textarea('keywords','Keywords')->rows(2)->columns(20) }}

        {{ Former::actions()->large_primary_submit('Save')->large_link_reset('Reset') }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>

        <p>Basic file settings.</p>
    </div>
</div>
@stop