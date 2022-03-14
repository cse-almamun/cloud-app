@extends('template.admin-template')

@section('title', 'Welcome Admin Panel')

@section('content')
    <h1 class="mt-2">Welcome {{ Auth::guard('admin')->user()->name }} !</h1>

    <div class="card my-3">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Contact Messages
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th>Sended At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th>Sended At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->first_name . ' ' . $contact->last_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->question }}</td>
                            <td>{{ $contact->read === 0 ? 'Unread' : 'Read' }}</td>
                            <td>{{ $contact->created_at }}</td>
                            <td class="d-flext text-center">
                                <a href="#" class="pe-2 readMessage" data-bs-toggle="modal"
                                    data-uuid="{{ $contact->uuid }}" data-bs-target="#viewMessage"><i
                                        class="fas fa-eye"></i></a>
                                <a href="#" class="ps-2 replyMessage" data-uuid="{{ $contact->uuid }}"
                                    data-bs-toggle="modal" data-bs-target="#replyMessage"><i class="fas fa-reply"></i></a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Show Message Modal -->
    <div class="modal fade" id="viewMessage" tabindex="-1" aria-labelledby="viewMessageLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewMessageLabel">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="readMessageForm">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control rounded-0 firstName" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control rounded-0 lastName" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control rounded-0 email" readonly>
                            </div>
                        </div>
                        <div class="my-3">
                            <textarea name="" class="form-control message" id="" rows="10" readonly></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Reply Message Modal -->
    <div class="modal fade" id="replyMessage" tabindex="-1" aria-labelledby="replyMessageLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyMessageLabel">Reply Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.reply.contact-message') }}" method="POST" id="replyContactMessage">
                        @csrf
                        <div class="mb-2">
                            <label>Full Name</label>
                            <input type="text" class="form-control rounded-0 fullName" name="full_name" readonly required>
                        </div>

                        <div class="mb-2">
                            <label>To</label>
                            <input type="email" class="form-control rounded-0 toEmail" name="to_email"
                                placeholder="example@mai.com" required>
                        </div>
                        <div class="mb-2">
                            <label>Subject</label>
                            <input type="text" class="form-control rounded-0 subject" name="subject" placeholder="subject"
                                required>
                        </div>
                        <div class="mb-2">
                            <label>Message</label>
                            <textarea name="message" class="form-control rounded-0 reply_message" rows="10"
                                placeholder="message" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-blue">Send</button>
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
            $(".readMessage").click(function(e) {
                e.preventDefault();
                let uuid = $(this).attr('data-uuid');
                let parent = $(this).closest('tr');
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.read.message') }}",
                    data: {
                        'uuid': uuid
                    },
                    dataType: "json",
                    success: function(response) {
                        let data = JSON.stringify(response);
                        let obj = JSON.parse(data);
                        if (obj !== null) {
                            if (obj.read === 1) {
                                parent.find('td:eq(3)').text('Read');
                            }
                            implementForm(obj);
                        }
                    }
                });
            });


            //populate the read popup data
            function implementForm(data) {
                let readForm = $('#readMessageForm');
                readForm.trigger('reset');
                $('input.firstName').val(data.first_name);
                $('input.lastName').val(data.last_name);
                $('input.email').val(data.email);
                $('textarea.message').val(data.message);
            }


            //reply to user message
            $('.replyMessage').click(function(e) {
                e.preventDefault();
                let parent = $(this).closest('tr');
                let name = parent.find('td:eq(0)').text();
                let to = parent.find('td:eq(1)').text();
                $('input.fullName').val(name);
                $('input.toEmail').val(to);
            });

        });
    </script>

@endsection
