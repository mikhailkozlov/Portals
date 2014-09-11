@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portal</a></li>
<li><a href="{{ route('admin.pages.view', array($portal_id)) }}">Pages</a></li>
<li class="active">Create Page</li>
@stop

@section('title')
Create Page - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>Create Page</h1>

        {{Former::vertical_open( route('admin.pages.store', array($portal_id)), 'POST') }}


        {{ Former::text('title','Title')->required() }}

        {{ Former::text('slug','Slug')->required() }}

        {{ Former::select('status','Status')->options($status_opt) }}

        {{ Former::textarea('content','Content')->required()->rows(5)->columns(20) }}

        {{ Former::textarea('excerpt','Excerpt')->rows(5)->columns(20) }}


        {{ Former::actions()->large_primary_submit('Save')->link_reset('Reset') }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Basic page settings.</p>
    </div>
</div>
@stop

@section('javascript')
{{ HTML::script('assets/js/tinymce/tinymce.min.js'); }}
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        menubar: false,
        toolbar_items_size: 'small'
    });
</script>
@stop