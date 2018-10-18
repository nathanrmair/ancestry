@extends('layouts.mainLayout')


@section('content')

    <h1>visitorSearch page</h1>


    {!! Form::open(['url' => 'visitorSearch']) !!}


    <div class="form-group">

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select surname
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                @foreach($visitors as $visitor)
                    <li><a href="{{action('Admin\VisitorController@searchBySurname', [$visitor->surname])}}">{{$visitor->surname}}</a></li>

                @endforeach
            </ul>
        </div>

    </div>

    <div class="form-group">

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select status
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                @foreach($visitors as $visitor)
                <li><a href="{{action('Admin\VisitorController@searchByStatus', [$visitor->status])}}">{{$visitor->status}}</a></li>
                    @endforeach
            </ul>
        </div>

    </div>

    <div class="form-group">

        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select member
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                @foreach($visitors as $visitor)
                    <li><a href="{{action('Admin\VisitorController@searchByMember', [$visitor->member])}}">{{$visitor->member}}</a></li>
                @endforeach
            </ul>
        </div>

    </div>


    {!! Form::close() !!}

    @stop