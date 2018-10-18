@extends('layouts.adminLayout')

@section('content')

    <script src="{{ url('/') }}/js/main.js"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/reportsFunctions.js"></script>
    <script src="{{ url('/') }}/js/mainVisitors.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="providerTitle">
                    <h2>{{$providerDetails->name}}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="emailButton" style="padding-top: 22px;">
                    <a href="{{ url('/admin/emailProvider') }}/{{ $providerDetails->user_id }}">
                        <button type="button" class="btn btn-info btn-lg">Email
                            this provider
                        </button>
                    </a>
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2>Total read/unread</h2>
                <canvas id="pieChartProvider" width="300" height="300"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Breakdown of unread</h2>
                <canvas id="barChartBreakdown" width="300" height="300"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3>General provider details</h3>
                <br>
                <h4>Provider ID: {{\Vinkla\Hashids\Facades\Hashids::encode($providerDetails->user_id)}}</h4>
                <h4>First line of address: {{$providerDetails->street_name}}</h4>
                <h4>Town: {{$providerDetails->town}}</h4>
                <h4>County: {{$providerDetails->county}}</h4>
                <h4>Region: {{$providerDetails->region}}</h4>
                <h4>Post Code: {{$providerDetails->postcode}}</h4>
                <h4>Type: {{$providerDetails->type}}</h4>
                <h4>Description: {{$providerDetails->description}}</h4>
                <h4>Unique Visits: {{$providerDetails->visits}}</h4>
                <h4>Keywords:
                    <?php
                    $keywords = explode(",",$providerDetails->keywords);
                    ?>
                    @foreach($keywords as $keyword)
                        <span class="label label-info" style="margin-bottom: 5px; display: inline-block;">{{$keyword}}</span>
                        @endforeach
                </h4>
            </div>
            <div class="col-md-6">
                <h3>Message stats</h3>
                <br>
                <h4>Number of messages received: {{$total}}</h4>
                <h4>Number of messages answered: {{$read}}</h4>
                <h4>Number of messages unread: {{$unread}}</h4>
                <h4>Unread more than 1 month ago: {{$unansweredOneMonth}}</h4>
                <h4>Unread more than 3 months ago: {{$unansweredThreeMonths}}</h4>
                <h4>Oldest date of unanswered messages: {{$oldestDate}}</h4>
                <h3>Unanswered messages</h3>
                <br>
                <table class="table table-hover" id="messageTable">
                    <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Visitor ID</th>
                        <th>Message</th>
                        <th>Date and Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unansweredMessages as $mess)
                        <tr class='clickable-row' data-href="#">
                            <td>{{$mess->message_id}}</td>
                            <td>{{$mess->visitor_id}}</td>
                            <td>{{$mess->message}}</td>
                            <td>{{$mess->time}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </div>
        {{--end of main container div--}}
        <div class="row">
            <div class="col-md-12">
                <h3> Delete User</h3>
                    {{csrf_field()}}
                    <input type="hidden" name="user_id" value="{{$providerDetails->user_id}}" />
                    <button id="delete-user-button" onclick="done()" class=" btn btn-danger">DELETE</button>
            </div>
        </div>

    </div>

    <script>

        var viewUnread = "{{$unread}}";

        var viewRead = "{{$read}}";

        var viewTotal = "{{$total}}";

        var dataRows = "{{$jsonArrayProvider}}";

        var unansweredAfterOneMonth = "{{$unansweredOneMonth}}";

        var unansweredAfterThreeMonths = "{{$unansweredThreeMonths}}";

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>



@endsection