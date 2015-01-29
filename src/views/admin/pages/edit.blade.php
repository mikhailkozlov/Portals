@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portals</a></li>
<li><a href="{{ route('admin.pages.view', array($page->portal_id)) }}">Pages</a></li>
<li class="active">{{{ $page->title ? $page->title : 'Create page' }}}</li>
@stop

@section('title')
{{ $page->title }} - Admin -
@stop

@section('container')
<div class="row">
    <div class="col-sm-12">

        <h1>Edit page <small class="pull-right"><a href="{{ url($page->portal->slug.'/'.$page->slug .'?preview=test') }}" data-toggle="tooltip" title="Preview"><i class="fa fa-external-link"></i></a></small></h1>

        {{Former::vertical_open( route('admin.pages.update', array($page->portal_id, $page->id)), 'PUT') }}

            {{ Former::populate($page) }}

            {{ Former::text('title','Title')->required() }}

            @if($page->type != 'page')
                {{ Former::textarea('excerpt','Excerpt')->rows(5)->columns(20)->help('Excerpt will be used as introduction to an article') }}
            @endif

            {{ Former::textarea('content','Content')->required()->rows(25)->columns(20) }}

            @foreach($attributes as $i=>$attr)
                @if(is_array($attr['value']))
                    {{ Former::select('attributes['.$i.']', $attr['label'])->options( $attr['value'])->value($page->attributes()->whereTitle($i)->lists('value')) }}
                @else
                    {{ Former::text('attributes['.$i.']',  $attr['label'])->value($page->attributes()->whereTitle($i)->first(array('value')) ) }}
                @endif
            @endforeach

            <div class="row">
                <div class="col-sm-6">
                    {{ Former::text('slug','Page Url')->required()->help('Please only provide desired page URL not full path. If no URL provided, it will be generated from title.') }}
                </div>
                <div class="col-sm-6">
                    {{ Former::select('parent_id','Parent Page',$parents)->help('You nest pages using Parent setting') }}
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    {{ Former::select('type','Page Type')->required()->options($types)->help('By default pages of type Blog will be displayed on front page of the portal. Pages are regular html pages and will be organized in a tree.')  }}
                </div>
                <div class="col-sm-6">
                    {{ Former::select('status','Status')->required()->options($status_opt)->help('Only published pages visible to visitors.') }}
                </div>
            </div>

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