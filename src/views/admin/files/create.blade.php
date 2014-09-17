@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.files.view') }}">Files</a></li>
<li class="active">Upload File</li>
@stop

@section('title')
Upload File - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>Upload File</h1>

        {{Former::vertical_open(route('admin.files.store'), 'POST', array('enctype'=>'multipart/form-data')) }}

        {{ Former::file('file','File')->required() }}

        {{ Former::text('title','Label') }}

        {{ Former::select('permissions','Access')->options($userGroups) }}

        {{ Former::textarea('description','Description')->rows(5)->columns(20) }}

        {{ Former::textarea('keywords','Keywords')->rows(2)->columns(20) }}

        {{ Former::actions()->large_primary_submit('Save')->large_link_reset('Reset') }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Basic portal settings.</p>
    </div>
</div>
@stop