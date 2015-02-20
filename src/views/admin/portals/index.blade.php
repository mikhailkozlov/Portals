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
        <table class="table table-striped"  style="width:100%; table-layout:fixed;">
            <thead>
            <tr>
                <th class="col-xs-9  col-sm-5">Portal Name</th>
                <th class="hidden-xs col-sm-2">Path</th>
                <th class="hidden-xs col-sm-2">Status</th>
                <th class="col-xs-3 col-sm-2">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($portals as $portal)
                    <tr>
                        <td style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><a href="{{ url($portal->slug) }}">{{ $portal->title }}</a></td>
                        <td class="hidden-xs"><a href="{{ url($portal->slug) }}">{{ $portal->slug }}</a></td>
                        <td class="hidden-xs">{{ $portal->status }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.pages.create', $portal->id) }}" class="btn btn-primary btn-xs " title="Add new page/post"><i class="fa fa-plus"></i><span class="hidden-xs hidden-sm"> Add Page</span></a>
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('admin.pages.view', $portal->id) }}" title="View all pages"><i class="fa fa-files-o"></i> Pages</a></li>
                                    <li><a href="{{ route('admin.widgets.view', $portal->id) }}" title="View portal widgets"><i class="fa fa-puzzle-piece"></i> Widgets</a></li>
                                    <li><a href="{{ route('admin.portals.edit', $portal->id) }}" title="Change portal settings"><i class="fa fa-cogs"></i> Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#delete">Delete</a></li>
                                </ul>
                            </div>
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