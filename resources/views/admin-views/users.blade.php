@extends('template.admin-template')

@section('title', 'Welcome Admin Panel')

@section('content')
    <div class="mx-auto w-50 mt-3">
        <form class="d-flex" action="{{ route('admin.users') }}" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="search user" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    @isset($users)
        <div class="card my-3">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                User
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joine Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>UUID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joine Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->uuid }}</td>
                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.debug.user', ['uuid' => $user->uuid]) }}"
                                        class="text-blue"><i class="fas fa-user-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endisset
    {{-- @if ($users)
        
    @endif --}}

@endsection
