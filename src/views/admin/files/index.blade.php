@section('crumb')
<li><a href="/admin">Admin</a></li>
<li class="active">Files</li>
@stop


@section('title')
Files - Admin -
@stop

@section('container')

<div class="row">
    <div class="col-sm-9">
        <h1>Content Files <small class="pull-right"><a href="{{ route('admin.files.create') }}" class="btn btn-sm btn-primary" title="Upload File"><i class="fa fa-plus-square"></i> New</a></small></h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>File name</th>
                <th>Size</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ $file->title }}</td>
                        <td>{{ $file->filename }}</td>
                        <td>{{ $file->size }}</td>
                        <td><a href="{{ route('admin.files.edit', $file->id) }}">Edit</a> | <a href="{{ route('admin.files.download', $file->id) }}">Download</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $files->links() }}

    </div>
    <div class="col-sm-3">
        <h4>Help</h4>
        <p>Content portals are designed to group content in categories.</p>
    </div>
</div>
@stop