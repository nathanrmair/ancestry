.@extends('layouts.adminLayout')
@section('content')
    <div class="container-fluid">
        @if(isset($providers)&&(count($providers)>0))
            <H1>Providers</H1>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Overview Link</th>
                    <th>Statistics</th>

                </tr>
                </thead>

                @foreach($providers as $provider)
                    <tbody>
                    {{--class='clickable-row' data-href="{{url('/reports/get/')}}{{\Vinkla\Hashids\Facades\Hashids::encode($report->report_id)}}"--}}
                    <tr>
                        <td><a href="{{  \Illuminate\Support\Facades\URL::route('admin/reports/provider', \Vinkla\Hashids\Facades\Hashids::encode($provider->user_id)) }}">{{$provider->name}}</a></td>
                        <td>{{$provider->type}}</td>
                        <td>
                            <a href="{{  \Illuminate\Support\Facades\URL::route('provider_overview', \Vinkla\Hashids\Facades\Hashids::encode($provider->user_id)) }}">Overview</a>
                        </td>
                        <td><a href="{{  \Illuminate\Support\Facades\URL::route('admin/reports/provider_stats',\Vinkla\Hashids\Facades\Hashids::encode($provider->user_id)) }}">Stats</a></td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @else
            <H2>No providers exist! Something has gone wrong...</H2>
        @endif
    </div>
@endsection