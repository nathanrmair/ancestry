@extends('layouts.adminLayout')

@section('content')

    <script>

        var totalReceived = "{{$total}}"
        var totalUnread = "{{$unread}}";
        var totalRead = "{{$read}}";
        var totalUsers = "{{$totalUsers}}"
        var totalVisitors = "{{$totalVisitors}}"
        var totalProviders = "{{$totalProviders}}"

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>


    <script src="{{ url('/') }}/js/mainReports.js"></script>



    <div class="container">
        <div class="row">
            <div class="col-md-offset-4 col-md-5">
                <h1>Reports Overview</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h2>Total read/unread messages</h2>
                <canvas id="pieChartOverviewMessages" width="300" height="300"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Total registrations</h2>
                <canvas id="barChartRegistrations" width="300" height="200"></canvas>
                <canvas id="pieChartVisitorProfile" width="300" height="200"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Unread messages more than 1 month old</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Provider ID</th>
                        <th>Visitor ID</th>
                        <th>Message</th>
                        <th>Date and time</th>
                        <th>Read</th>
                        <th>Attachments</th>
                        <th>Conversation ID</th>
                        <th>Who</th>
                    </tr>
                    </thead>
                    @if(count($messagesOver1Month))
                        @foreach($messagesOver1Month as $messages)
                            <tbody>
                            <tr class='clickable-row' data-href="#">
                                <td>{{$messages->message_id}}</td>
                                <td>
                                    <a href="{{url('/admin/providerSummary')}}/{{$messages->provider_id}}">{{\Vinkla\Hashids\Facades\Hashids::encode($messages->provider_id)}}</a>
                                </td>
                                <td>
                                    <a href="{{url('/admin/visitorSummary/')}}/{{ $messages->visitor_id }}">{{\Vinkla\Hashids\Facades\Hashids::encode($messages->visitor_id)}}</a>
                                </td>
                                <td>{{$messages->message}}</td>
                                <td>{{$messages->time}}</td>
                                <td>{{$messages->read}}</td>
                                <td>{{$messages->attachments}}</td>
                                <td>{{$messages->conversation_id}}</td>
                                <td>{{$messages->who}}</td>
                            </tr>
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Unread messages more than 3 months old</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Message ID</th>
                        <th>Provider ID</th>
                        <th>Visitor ID</th>
                        <th>Message</th>
                        <th>Date and time</th>
                        <th>Read</th>
                        <th>Attachments</th>
                        <th>Conversation ID</th>
                        <th>Who</th>

                    </tr>
                    </thead>

                    @if(count($messagesOver3Months))
                        @foreach($messagesOver3Months as $message)
                            <tbody>
                            <tr class='clickable-row' data-href="#">
                                <td>{{$message->message_id}}</td>
                                <td>{{$message->provider_id}}</td>
                                <td>{{$message->visitor_id}}</td>
                                <td>{{$message->message}}</td>
                                <td>{{$message->time}}</td>
                                <td>{{$message->read}}</td>
                                <td>{{$message->attachments}}</td>
                                <td>{{$message->conversation_id}}</td>
                                <td>{{$message->who}}</td>
                            </tr>
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
@endsection