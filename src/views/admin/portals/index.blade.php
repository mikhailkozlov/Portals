@section('crumb')
<li><a href="/admin">Admin</a></li>
<li class="active">Content Portals</li>
@stop


@section('title')
Content Portals - Admin -
@stop

@section('container')

<div class="row">
    <div class="col-sm-9">
        <h1>Content Portals <small class="pull-right"><a href="{{ route('admin.portals.create') }}" class="btn btn-sm btn-primary" title="Add New Portal"><i class="fa fa-plus-square"></i> New</a></small></h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="col-sm-5">Portal Name</th>
                <th class="col-sm-2">Path</th>
                <th class="col-sm-2">Status</th>
                <th class="col-sm-3">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($portals as $portal)
                    <tr>
                        <td>{{ $portal->title }}</td>
                        <td><a href="{{ url($portal->slug) }}">{{ $portal->slug }}</a></td>
                        <td>{{ $portal->status }}</td>
                        <td>
                            <a href="{{ route('admin.pages.create', $portal->id) }}" title="Add new page/post"><i class="fa fa-plus hidden-md hidden-lg"></i><span class="hidden-xs hidden-sm"> New Page</span></a> <span class="hidden-xs hidden-sm">|</span>
                            <a href="{{ route('admin.pages.view', $portal->id) }}" title="View all pages"><i class="fa fa-files-o hidden-md hidden-lg"></i><span class="hidden-xs hidden-sm"> Pages</span></a> <span class="hidden-xs hidden-sm">|</span>
                            <a href="{{ route('admin.portals.edit', $portal->id) }}" title="Change portal settings"><i class="fa fa-cogs  hidden-md hidden-lg"></i><span class="hidden-xs hidden-sm"> Settings</span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $portals->links() }}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Content portals are designed to group content in categories.</p>
    </div>
</div>
@stop