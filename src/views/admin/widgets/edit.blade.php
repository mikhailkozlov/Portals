@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portals</a></li>
<li><a href="{{ route('admin.widgets.view', array($page->portal_id)) }}">Widgets</a></li>
<li class="active">{{{ $page->title ? $page->title : 'Create Widget' }}}</li>
@stop

@section('title')
{{ $page->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-12">

        <h1>Edit widget <small class="pull-right"><a href="{{ url($page->portal->slug.'/'.$page->slug .'?preview=test') }}" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a></small></h1>

        {{Former::vertical_open( route('admin.widgets.update', array($page->portal_id, $page->id)), 'PUT') }}

            {{ Former::populate($page) }}

            <div class="row">
                <div class="col-sm-4">
                    {{ Former::text('title','Title')->help('Keep it short, we only have 1/4 of the width')->required() }}
                </div>
                <div class="col-sm-4">
                    {{ Former::text('menu_order','Widget Weight')->help('"Lighter" widgets will flow to the top of the list')->required() }}
                </div>
                <div class="col-sm-4">
                    {{ Former::select('status','Status')->required()->options($status_opt)->help('Only published pages visible to visitors.') }}
                </div>
            </div>

            {{ Former::textarea('content','Content')->required()->rows(15)->columns(20) }}

            {{ Former::actions()->large_primary_submit('Save')->large_link_reset('Reset') }}

        {{Former::close()}}

    </div>
</div>
@stop

@section('javascript')
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" ></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>


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
        toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        content_css:'/packages/sugarcrm/portals/bootstrap/css/bootstrap.min.css'
    });
</script>
@stop