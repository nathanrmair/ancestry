@extends('layouts.adminLayout')


@section('content')

    <span class="text-center"><h1>All Users</h1></span>

    <hr>

    <div class="container">

        <h2>User Details</h2>
        <p>Select a user from the table:</p>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Email</th>
                <th>Confirmed</th>
                <th>User Type</th>
            </tr>
            </thead>

            @foreach($users as $user)

                <tbody>
                @if($user->type === 'visitor')
                        <tr class='clickable-row'
                            data-href="{{action('Admin\ReportsController@visitorSummary', [$user->user_id])}}">
                @elseif($user->type === 'provider')
                    <tr class='clickable-row'
                        data-href="{{action('Admin\ReportsController@providerSummary', [$user->user_id])}}">
                @else
                    <tr class='clickable-row'
                        data-href="#">
                        @endif
                        <td>{{$user->user_id}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->confirmed}}</td>
                        <td>{{$user->type}}</td>

                    </tr>


                    @endforeach

                </tbody>
        </table>


    </div>

    <script src="{{ url('/') }}/js/clickableRows.js"></script>
@stop