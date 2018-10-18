@extends('layouts.adminLayout')


@section('content')

    <div class="container">
        <span class="text-center"><h1>Search user parameters</h1></span>

        <form id="searchByEmail" action="{{url('/admin/users/searchByEmail')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-md-10">
                        <label for="searchByEmail">Search by Email: </label>
                        <input class="form-control" type="email" name="email"  maxlength="254"
                               placeholder="Enter the user's email here"/>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <form id="searchByName" action="{{url('/admin/users/searchByName')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-md-10">
                        <label for="searchByEmail">Search by Name: </label>
                        <input class="form-control" type="text" name="name"
                               placeholder="Enter the user's name here"/>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <form id="searchByType" action="{{url('/admin/users/searchByType')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="row">
                    <div class="col-md-10">
                        <label for="searchByEmail">Search by Type: </label>
                        <input class="form-control" type="text" name="type"
                               placeholder="Enter the user's type here"/>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        @if(isset($users))
            <table class="table table-hover" id="user-resuls">
                <thead>
                <th>Username</th>
                <th>Type</th>
                <th>Email</th>
                <th>More Info</th>
                </thead>
                @foreach($users as $user)
                    <tr>
                    @if(isset($user['visitor_id']))
                        <td>{{$user['forename']}} {{ $user['surname'] }}</td>
                        <td>Visitor</td>
                    @else
                        <td>{{ $user['name'] }}</td>
                        <td>Provider</td>
                    @endif
                    <td>{{ \App\User::where('user_id',$user['user_id'])->first()->email}}</td>
                    @if(isset($user['visitor_id']))
                        <td><a href="{{ url('/admin/visitorSummary/') }}/{{$user['user_id']}}">User Report</a></td>
                    @else
                        <td><a href="{{ url('/admin/providerSummary/') }}/{{$user['user_id']}}">User Report</a></td>
                    @endif
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection