@extends('layouts.adminLayout')


@section('content')
    <div class="container">

        <h1>Details for: {{$user->email}}</h1>
        <div class="row">
            <h3>
            @if($user->confirmed == 1)
                This user has verified their email address.
            @else
                This user has not verified their email address.
            @endif
            </h3>
        </div>


        <div class="row">
            <div class="col-md-12">
                <h3> Delete User</h3>
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{$user->user_id}}"/>
                <button id="delete-user-button" onclick="done()" class=" btn btn-danger">DELETE</button>
            </div>
        </div>

    </div>

    <script>
        function done() {

            bootbox.confirm("Are you sure you want to delete this user?", function (result) {
                if (result) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                        }
                    });

                    $.ajax({
                        url: base_url() + 'admin/users/delete',
                        data: {user_id: $('input[name="user_id"]').attr('value')},
                        dataType: 'json',
                        method: 'POST',
                        success: function () {

                        }
                    });
                    window.location.href = base_url() + '/admin/adminMain';
                }
            });
        }
    </script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>

@endsection