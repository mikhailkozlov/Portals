@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portal</a></li>
<li><a href="{{ route('admin.widgets.view', array($portal_id)) }}">Widgets</a></li>
<li class="active">Create Widget</li>
@stop

@section('title')
Create Widget - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-12">

        <h1>Create Widget</h1>

        {{Former::vertical_open( route('admin.widgets.store', array($portal_id)), 'POST') }}
            {{ Former::hidden('status')->value('draft') }}
            {{ Former::hidden('type','widget')  }}
            {{ Former::hidden('menu_order',1)  }}


        <div class="row">
            <div class="col-sm-4">
                {{ Former::text('title','Title')->help('Keep in mind that title should be short')->required() }}
            </div>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">

            </div>
        </div>



            {{ Former::textarea('content','Content')->rows(5)->columns(40) }}

            {{ Former::actions()->large_primary_submit('Save')->link_reset('Reset') }}

        {{Former::close()}}

    </div>
</div>
@stop

@section('javascript')
    <link rel="stylesheet" type="text/css" media="screen" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>


    <link rel="stylesheet" type="text/css" media="screen" href="/packages/sugarcrm/portals/tinymce/plugins/elfinder/css/elfinder.min.css">
    <script type="text/javascript" src="/packages/sugarcrm/portals/tinymce/plugins/elfinder/js/plugin.min.js"></script>

    <!-- Mac OS X Finder style for jQuery UI smoothness theme (OPTIONAL) -->
    <link rel="stylesheet" type="text/css" media="screen" href="/packages/sugarcrm/portals/tinymce/plugins/elfinder/css/theme.css">

{{ HTML::script('/packages/sugarcrm/portals/tinymce/tinymce.min.js'); }}
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        menubar: false,
        paste_as_text: true,
        plugins: [
                "advlist autolink lists link image anchor",
                "code fullscreen",
                "insertdatetime media table contextmenu paste",
                "elfinder"
            ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        content_css:'/packages/sugarcrm/portals/bootstrap/css/bootstrap.min.css'
    });
</script>
@stop