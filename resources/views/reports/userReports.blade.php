.@extends('layouts.dashboard')
@section('content')
    <body onload="init()">
    <div class="container-fluid">
        @if(isset($reports)&&(count($reports)>0))
            <H1>Reports</H1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th>PDF</th>

                </tr>
                </thead>

                @foreach($reports as $report)
                    <tbody>
                    {{--class='clickable-row' data-href="{{url('/reports/get/')}}{{\Vinkla\Hashids\Facades\Hashids::encode($report->report_id)}}"--}}
                    <tr>
                        <td>
                            <a href="{{  \Illuminate\Support\Facades\URL::route('reports/get', \Vinkla\Hashids\Facades\Hashids::encode($report->report_id)) }}">{{$report->title}}</a>
                        </td>
                        <td>{{$report->type}}</td>
                        <td>{{\Carbon\Carbon::parse($report->creted_at)->format('j M Y')}}</td>
                        <td>
                            <a href="{{  \Illuminate\Support\Facades\URL::route('reports/pdf', \Vinkla\Hashids\Facades\Hashids::encode($report->report_id)) }}">PDF</a>
                        </td>

                    </tr>
                    </tbody>
                @endforeach
            </table>
        @else
            <H2>Your first report will become available at the end of this month</H2>
        @endif
    </div>

    <div class="card"><a href="{{  \Illuminate\Support\Facades\URL::route('reports/stats', $encoded_user_id) }}">current
            stats</a></div>

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