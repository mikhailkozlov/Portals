@section('crumb')
<li><a href="/admin">Admin</a></li>
<li><a href="{{ route('admin.portals.view') }}">Portal</a></li>
<li class="active">Content Pages</li>
@stop


@section('title')
Content Pages - Admin -
@stop

@section('container')

<div class="row">
    <div class="col-sm-12">
        <h1>Content Pages <small class="pull-right"><a href="{{ route('admin.pages.create', array($portal_id)) }}" class="btn btn-sm btn-primary" title="Add New Page"><i class="fa fa-plus-square"></i> New</a></small></h1>
        <table class="table table-striped" style="width:100%; table-layout:fixed;">
            <thead>
                <tr>
                    <th class="col-xs-10 col-sm-7">Page Name</th>
                    <th class="col-sm-1 hidden-xs">Type</th>
                    <th class="col-sm-1 hidden-xs">Status</th>
                    <th class="col-sm-2 hidden-xs">Updated</th>
                    <th class="col-xs-2 col-sm-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $page->title }}</td>
                        <td class="hidden-xs">{{ Config::get('portals::pages.types.'.$page->type, 'Page') }}</td>
                        <td class="hidden-xs">{{ $page->status }}</td>
                        <td class="hidden-xs">{{ $page->updated_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.pages.edit', array($page->portal_id, $page->id)) }}">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pages->links() }}

    </div>
</div>
@stop