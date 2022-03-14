@extends('template.user-dash-template')

@section('title', 'All Folder')

@section('content')
    <div class="my-3 d-flex">
        <form action="{{ url('/create-folder') }}" method="POST">
            <div class="input-group">
                @csrf
                <input type="text" name="folder" class="form-control" placeholder="input your folder name" required>
                <button type="sumbit" class="btn btn-blue">Create Folder</button>
            </div>
        </form>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Folder Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>


                    @foreach ($folders as $folder)
                        <tr>
                            <td><a href="folders/{{ $folder->uuid }}">{{ $folder->name }}</a> </td>
                            <td>{{ $folder->created_at }}</td>
                            <td class="d-flex">
                                <form action="{{ url('folders/update') }}" method="POST">

                                    @csrf
                                    <input type="hidden" name="folder_id" value="{{ $folder->uuid }}">
                                    <button type="submit" class="tb-btn text-warning"><i class="fas fa-edit"></i></button>
                                </form>
                                <form action="{{ url('folders/delete') }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="folder_id" value="{{ $folder->uuid }}">
                                    <button type="submit" class="tb-btn text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
