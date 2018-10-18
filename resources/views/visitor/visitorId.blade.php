@extends('layouts.mainLayout')


@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-2"></div>

            <div class="col-md-6">

                <h1>Visitor page</h1>

            </div>

        </div>

        <hr>
        <div class="text-center">
        @if($visitor->avatar_id == 0)
            <img src="{{ url('/') }}/img/avatar/default_visitor.png" class="dashpic" style="max-width:500px; height:auto;">
        @else
            <img src="{{json_decode(App\Http\Controllers\ProfileController::getAnAvatar($visitor->user_id))}}"
                 style="max-width:500px; height:auto;" class="user-avatar">
        @endif
        </div>
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
                <th>Origin</th>
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
                <td>{{$visitor->origin}}</td>
                <td>{{$visitor->description}}</td>
            @endif
            </tbody>
        </table>
    </div>
@endsection