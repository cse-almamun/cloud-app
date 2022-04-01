@extends('template.admin-template')

@section('title', 'Welcome Admin Panel')

@section('content')
    <div class="card my-3">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All System Users
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Storage</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Storage</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->storage }} GB</td>
                            <td>{{ $user->locked === 0 ? 'Unlocked' : 'Locked' }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="d-flext text-center">
                                <a href="{{ route('admin.debug.user', ['uuid' => $user->uuid]) }}"
                                    class="text-blue"><i class="fas fa-user-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection
