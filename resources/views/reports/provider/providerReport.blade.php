@extends('reports.reportHeader')
@section('report')
    @if(isset($report))
        <div>
            <H1>{{$report->title}}</H1>
            <H2>This Month</H2>
            <div class="container-fluid">
                <table>
                    <tr>
                        <td>Page visits</td>
                        <td>{{$report_content->page_visits}}</td>
                    </tr>
                    <tr>
                        <td>Messages unread</td>
                        <td>{{$report_content->messages_unread}}</td>
                    </tr>
                    <tr>
                        <td>Conversations initiated</td>
                        <td>{{$report_content->new_conversations}}</td>
                    </tr>
                    <tr>
                        <td>Searches pending</td>
                        <td>{{$report_content->searches_offered}}</td>
                    </tr>
                    <tr>
                        <td>Searches accepted</td>
                        <td>{{$report_content->searches_accepted}}</td>
                    </tr>
                    <tr>
                        <td>Searches completed</td>
                        <td>{{$report_content->searches_completed}}</td>
                    </tr>

                </table>

                {{--<img src="{{url('/')}}/charts/testGraph.php" />--}}
                {{--<img src="@include('public.charts.testGraph')">--}}
                {{--<p>{{url('/')}}/charts/testGraph.php</p>--}}

            </div>
        </div>
        <H2>Total</H2>
        <div class="container-fluid">
            <table>
                <tr>
                    <td>Total page visits</td>
                    <td>{{$report_content->total_page_visits}}</td>
                </tr>
                <tr>
                    <td>Total messages</td>
                    <td>{{$report_content->total_messages}}</td>
                </tr>
                <tr>
                    <td>Total conversations</td>
                    <td>{{$report_content->total_conversations}}</td>
                </tr>
                <tr>
                    <td>Total searches</td>
                    <td>{{$report_content->total_searches_completed}}</td>
                </tr>
            </table>
        </div>
    @else
        <div><H2>Your first report will appear here at the end of this month</H2></div>
    @endif

@endsection