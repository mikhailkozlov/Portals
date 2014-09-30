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
    <div class="col-sm-9">

        <h1>{{{ $page->title ? $page->title : 'Create page' }}}</h1>

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
                <div class="col-sm-4">
                    {{ Former::text('slug','Page Url')->required()->help('Please only provide desired page URL not full path. If no URL provided, it will be generated from title.') }}
                </div>
                <div class="col-sm-4">
                    {{ Former::select('type','Page Type')->required()->options($types)->help('By default pages of type Blog will be displayed on front page of the portal. Pages are regular html pages and will be organized in a tree.')  }}
                </div>
                <div class="col-sm-4">
                    {{ Former::select('status','Status')->required()->options($status_opt)->help('Only published pages visible to visitors.') }}
                </div>
            </div>

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