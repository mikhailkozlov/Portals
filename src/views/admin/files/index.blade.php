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
        <h1>Content Files</h1>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>File name</th>
                <th>Size</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ $file->title }}</td>
                        <td>{{ $file->filename }}</td>
                        <td>{{ $file->size }}</td>
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