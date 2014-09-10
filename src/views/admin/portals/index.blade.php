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
                <th>Portal Name</th>
                <th>Path</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($portals as $portal)
                    <tr>
                        <td>{{ $portal->title }}</td>
                        <td>{{ $portal->slug }}</td>
                        <td>{{ $portal->status }}</td>
                        <td><a href="{{ route('admin.pages.view', $portal->id) }}">Pages</a> | <a href="{{ route('admin.portals.edit', $portal->id) }}">Edit</a></td>
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