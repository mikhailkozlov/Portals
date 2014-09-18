@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portal</a></li>
<li class="active">{{{ $portal->title ? $portal->title : 'Create portal' }}}</li>
@stop

@section('title')
{{ $portal->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-9">

        <h1>{{{ $portal->title ? $portal->title : 'Create portal' }}}</h1>

        {{Former::vertical_open( route('admin.portals.update', array($portal->id)), 'PUT') }}

        {{ Former::populate($portal) }}

        {{ Former::text('title','Title')->required() }}

        {{ Former::text('slug','Path')->required()->help('Root path to the portal. Use can nest path into folder like <code>path/to/portal</code>.') }}

        {{ Former::textarea('description','Description')->required()->rows(5)->columns(20) }}

        {{ Former::select('page_id','Home Page')->options($pages)->help('Select Blog if you would like home page to show latest posts/pages. Select particular page to make it portal\'s home page.') }}

        {{ Former::select('status','Status')->options($status_opt) }}

        {{ Former::text('keywords','Keywords') }}

        {{ Former::actions()->large_primary_submit('Save')->large_link_reset('Reset') }}

        {{Former::close()}}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>

        <p>Basic portal settings.</p>
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