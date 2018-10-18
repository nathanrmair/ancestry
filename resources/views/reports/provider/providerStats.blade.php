.@extends('layouts.dashboard')
@section('content')
    <body onload="init()">
    <div class="card container-fluid">
        <H1>Stats</H1>

        <div class="container-fluid ">
            <table class="table">

                <tr>
                    <td>Total page visits</td>
                    <td>{{$stats['total_page_visits']}}</td>
                </tr>
                <tr>
                    <td>Total messages unread</td>
                    <td>{{$stats['total_messages_unread']}}</td>
                </tr>
                <tr>
                    <td>Total conversations</td>
                    <td>{{$stats['total_conversations']}}</td>
                </tr>
                <tr>
                    <td>Total searches completed</td>
                    <td>{{$stats['total_searches_completed']}}</td>
                </tr>
            </table>


            {{--<img src="{{url('/')}}/charts/testGraph.php" />--}}
            {{--<img src="@include('public.charts.testGraph')">--}}
            {{--<p>{{url('/')}}/charts/testGraph.php</p>--}}

        </div>
    </div>
    </body>
    <script>
        function init() {
            highlight();
        }
        function highlight() {

            holder = document.getElementById('reports_dash');
            holder.className = holder.className + ' blueholder';
            holder.style.paddingLeft = '15%';
        }
    </script>
@endsection