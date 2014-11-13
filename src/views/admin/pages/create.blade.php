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
    <div class="col-sm-12">

        <h1>Create Page</h1>

        {{Former::vertical_open( route('admin.pages.store', array($portal_id)), 'POST') }}
            {{ Former::hidden('status')->value('draft') }}

            {{ Former::text('title','Title')->required() }}

            {{ Former::textarea('content','Content')->rows(5)->columns(40) }}

            <div class="row">
                <div class="col-sm-6">
                    {{ Former::text('slug','Page Url')->help('Please only provide desired page URL not full path. If no URL provided, it will be generated from title.') }}
                </div>
                <div class="col-sm-6">
                    {{ Former::select('type','Page Type')->options($types)->required()->help('By default pages of type Blog will be displayed on front page of the portal. Pages are regular html pages and will be organized in a tree.')  }}
                </div>
            </div>

            {{ Former::actions()->large_primary_submit('Save')->link_reset('Reset') }}

        {{Former::close()}}

    </div>
</div>
@stop

@section('javascript')
{{ HTML::script('/packages/sugarcrm/portals/tinymce/tinymce.min.js'); }}
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        menubar: false,
        paste_as_text: true,
        plugins: [
                "advlist autolink lists link image anchor",
                "code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        content_css:'/packages/sugarcrm/portals/bootstrap/css/bootstrap.min.css'
    });
</script>
@stop