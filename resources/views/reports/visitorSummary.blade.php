@extends('layouts.adminLayout')


@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <meta name="user_id" content="{{ $visitor->user_id }}" />
    <script>

        var sentMails = "{{$messagesSentCount}}";

        var receivedMails = "{{$messagesReceivedCount}}";

    </script>

    <div class="container">

        <h1>Details for: {{$visitor->forename}} {{$visitor->surname}}</h1>
        <div class="row">

            <div class="col-md-4">

                <div class="avatarImageDiv">

                    @if($visitor->avatar_id == 0)
                        <img src="{{ url('/') }}/img/avatar/default_visitor.png" class="dashpic" style="max-width:500px; height:auto;">
                    @else
                        <img src="{{json_decode(App\Http\Controllers\ProfileController::getAnAvatar($visitor->user_id))}}"
                             style="max-width:400px; height:auto;" class="user-avatar">
                    @endif

                </div>

            </div>

            <div class="col-md-4">

                <canvas id="visitorMessagesSentAndReceived" width="300" height="300"></canvas>

            </div>

            <div class="col-md-4">


            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Visitor ID</th>
                        <th>Forename</th>
                        <th>Surname</th>
                        <th>Member</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($visitor))
                        <td>{{$visitor->user_id}}</td>
                        <td>{{$visitor->visitor_id}}</td>
                        <td>{{$visitor->forename}}</td>
                        <td>{{$visitor->surname}}</td>
                        <td>{{$visitor->member}}</td>
                        <td>{{$visitor->dob}}</td>
                        <td>{{$visitor->gender}}</td>
                        <td>{{$visitor->description}}</td>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">

                <h3>History of credit top ups</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Credit Amount</th>
                        <th>Created At</th>
                        <th>Updated At</th>


                    </tr>
                    </thead>

                    <tbody>
                    @if(count($topUps))
                        @foreach($topUps as $topUp)
                            <tr class='clickable-row' data-href="#">
                                <td>{{$topUp->payment_id}}</td>
                                <td>{{$topUp->credit}}</td>
                                <td>{{$topUp->created_at}}</td>
                                <td>{{$topUp->updated_at}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>


            </div>


        </div>

        <div class="row">

            <div class="col-md-12">

                <h3>Ancestors</h3>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Ancestor ID</th>
                        <th>Visitor ID</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Date Of Death</th>
                        <th>Gender</th>
                        <th>Description</th>
                        <th>Clan</th>
                        <th>Place Of Birth</th>
                        <th>Place Of Death</th>


                    </tr>
                    </thead>

                    @if(count($ancestorDetails))

                        @foreach($ancestorDetails as $ancestors)

                            <tbody>
                            <tr class='clickable-row' data-href="#">

                                <td>{{$ancestors->ancestor_id}}</td>
                                <td>{{$ancestors->visitor_id}}</td>
                                <td>{{$ancestors->forename}} {{$ancestors->surname}}</td>
                                <td>{{$ancestors->dob}}</td>
                                <td>{{$ancestors->dod}}</td>
                                <td>{{$ancestors->gender}}</td>
                                <td>{{$ancestors->description}}</td>
                                <td>{{$ancestors->clan}}</td>
                                <td>{{$ancestors->place_of_birth}}</td>
                                <td>{{$ancestors->place_of_death}}</td>


                            </tr>


                            @endforeach

                            @endif

                            </tbody>
                </table>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <h3>Customer account details</h3>

                <br>

                {{--<h4>Credits: {{$balance->credits}}</h4>--}}
                <h4>Messages Sent: {{$messagesSentCount}}</h4>
                <h4>Messages Received: {{$messagesReceivedCount}}</h4>

                @if($percentComplete == 100)

                    <h4>Percentage of profile completion: <span style="color: green">{{$percentComplete}}%</span></h4>

                @elseif($percentComplete > 60 && $percentComplete < 100)

                    <h4>Percentage of profile completion: <span style="color: orange">{{$percentComplete}}%</span></h4>

                @else

                    <h4>Percentage of profile completion: <span style="color: red">{{$percentComplete}}%</span></h4>


                @endif

                @if($numberOfAncestors >= 3)

                    <h4>Number of Ancestors: <span style="color: green">{{$numberOfAncestors}}</span></h4>

                @elseif($numberOfAncestors < 3 && $numberOfAncestors > 0)

                    <h4>Number of Ancestors: <span style="color: orange">{{$numberOfAncestors}}</span></h4>

                @else

                    <h4>Number of Ancestors: <span style="color: red">{{$numberOfAncestors}}</span></h4>

                @endif


            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <h3> Delete User</h3>
                <hr>
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{$visitor->user_id}}" />
                <button id="delete-user-button" onclick="done()" class=" btn btn-danger">DELETE</button>
            </div>
        </div>

    </div>

    <script>
        function done(){

            bootbox.confirm("Are you sure you want to delete this user?", function(result) {
                if(result) {
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>


    <script src="{{ url('/') }}/js/mainVisitors.js"></script>
@endsection