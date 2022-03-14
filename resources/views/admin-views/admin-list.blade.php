@extends('template.admin-template')

@section('title', 'Welcome Admin Panel')

@section('content')
    <div class="card my-3">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Amdin Users
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->role === 1 ? 'Super Admin' : 'Regular Admin' }}</td>
                            <td>{{ $admin->updated_at }}</td>
                            <td class="d-flex">
                                <a href="#" class="pe-2 text-warning update-employee" data-uuid="{{ $admin->uuid }}"
                                    data-bs-toggle="modal" data-bs-target="#updateAdminModal"><i
                                        class="fas fa-user-edit"></i></a>
                                <a href="#" class="ps-2 text-dark reset-password" data-uuid="{{ $admin->uuid }}"><i
                                        class="fas fa-key"></i></a>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="updateAdminModal" tabindex="-1" aria-labelledby="updateAdminModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateAdminModalLabel">Update Admin Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('amdin.employee.update.submit') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="adminUUID">Admin UUID</label>
                            <input type="text" name="uuid" id="adminUUID" class="form-control" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="adminName">Name</label>
                            <input type="text" name="name" id="adminName" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="adminEmal">Email</label>
                            <input type="email" name="email" id="adminEmail" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="adminRole">Role</label>
                            <select name="role" id="adminRole" class="form-control" required>
                                <option value="1" class="super-admin">Super Admin</option>
                                <option value="2" class="regular-admin">Regular Admin</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-blue rounded-0">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {

            /**
             * udpate employee or admin information and roles
             * 
             */

            $('.update-employee').click(function(e) {
                e.preventDefault();
                let uuid = $(this).attr('data-uuid');
                let parent = $(this).closest('tr');


                implementForm(uuid, parent);
            });

            function implementForm(uuid, parent) {
                let name = parent.find('td:eq(0)').text();
                let email = parent.find('td:eq(1)').text();
                let role = parent.find('td:eq(2)').text();
                $('#adminUUID').val(uuid);
                $('#adminName').val(name);
                $("#adminEmail").val(email);
                role = role.replace(/\s/g, '-').toLowerCase();
                $("#adminRole ." + role).attr('selected', ' ');
            }

            /**
             * update employe or admin password to a temporary passowrd;
             */
            $('.reset-password').click(function(e) {
                e.preventDefault();
                let uuid = $(this).attr('data-uuid');
                swal({
                    title: 'Want to reset password?',
                    icon: 'warning',
                    text: "The user password will be reseted and will set and send a temporary password via email.",
                    buttons: true,
                    dangerMode: true
                }).then((confirm) => {
                    if (confirm) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('admin.set-admin.temp-password') }}",
                            data: {
                                uuid: uuid
                            },
                            dataType: "json",
                            success: function(response) {
                                let data = JSON.stringify(response);
                                let obj = JSON.parse(data);

                                console.log(obj.success);
                                if (obj.success) {
                                    swal("Temporary Password Sent Successfully!", {
                                        icon: "success",
                                    });
                                } else {
                                    swal("Ops! Operation Faile.", {
                                        icon: "error",
                                    });
                                }

                            }
                        });

                    }
                });
            });
        });
    </script>
@endsection
