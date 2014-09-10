@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Content Portals</a></li>
<li class="active">Create Portal</li>
@stop

@section('title')
Create Portal - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>Create Portal</h1>

        {{Former::horizontal_open( route('admin.portals.store'), 'POST') }}


        {{ Former::text('title','Title')->required() }}

        {{ Former::text('slug','Slug') }}

        {{ Former::textarea('description','Description')->required()->rows(5)->columns(20) }}

        {{ Former::select('status','Status')->options($status_opt) }}

        {{ Former::textarea('keywords','Keywords')->rows(5)->columns(20) }}


        {{ Former::actions()->large_primary_submit('Save')->link_reset('Reset') }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Basic portal settings.</p>
    </div>
</div>
@stop