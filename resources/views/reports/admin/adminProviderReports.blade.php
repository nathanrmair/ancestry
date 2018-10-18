.@extends('layouts.adminLayout')
@section('content')
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
                    <td><a href="{{  \Illuminate\Support\Facades\URL::route('reports/get', \Vinkla\Hashids\Facades\Hashids::encode($report->report_id)) }}">{{$report->title}}</a></td>
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
    <div class="card"><a href="{{  \Illuminate\Support\Facades\URL::route('admin/reports/provider_stats', $encoded_user_id) }}">current stats</a></div>
@endsection