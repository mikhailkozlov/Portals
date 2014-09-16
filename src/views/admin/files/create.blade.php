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

        {{ Former::text('title','Title') }}

        {{ Former::file('file','File') }}

        {{ Former::select('permissions','User group')->options($userGroups) }}

        {{ Former::textarea('description','Description')->rows(5)->columns(20) }}

        {{ Former::textarea('keywords','Keywords')->rows(5)->columns(20) }}

        {{ Former::actions()->large_primary_submit('Upload')->link_reset('Reset') }}

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