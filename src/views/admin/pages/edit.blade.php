@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portal</a></li>
<li><a href="{{ route('admin.pages.view', array($page->portal_id)) }}">Pages</a></li>
<li class="active">{{{ $page->title ? $page->title : 'Create page' }}}</li>
@stop

@section('title')
{{ $page->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>{{{ $page->title ? $page->title : 'Create page' }}}</h1>

        {{Former::vertical_open( route('admin.pages.update', array($page->portal_id, $page->id)), 'PUT') }}

        {{ Former::populate($page) }}

        {{ Former::text('title','Title')->required() }}

        {{ Former::text('slug','Slug')->required() }}

        {{ Former::select('status','Status')->options($status_opt) }}

        {{ Former::textarea('content','Content')->required()->rows(5)->columns(20) }}

        {{ Former::textarea('excerpt','Excerpt')->rows(5)->columns(20) }}

        {{ Former::actions()->large_primary_submit('Save')->large_link_reset('Reset') }}

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