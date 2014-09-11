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
    <div class="col-sm-9">
        <h1>Content Pages <small class="pull-right"><a href="{{ route('admin.pages.create', array($portal_id)) }}" class="btn btn-sm btn-primary" title="Add New Page"><i class="fa fa-plus-square"></i> New</a></small></h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Page Name</th>
                <th>Path</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>{{ $page->status }}</td>
                        <td><a href="{{ route('admin.pages.edit', array($page->portal_id, $page->id)) }}">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $pages->links() }}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Content pages are designed to group content in categories.</p>
    </div>
</div>
@stop