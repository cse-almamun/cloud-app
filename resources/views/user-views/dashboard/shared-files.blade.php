@extends('template.user-dash-template')

@section('title', 'All Files')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Files
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->file_name }}</td>
                            <td>{{ $file->file_size }}</td>
                            <td>{{ $file->created_at }}</td>
                            <td>{{ $file->updated_at }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ url('/file/download/' . $file->uuid) }}" class="ms-2 tb-btn"><i
                                        class="fas fa-download"></i></a>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
