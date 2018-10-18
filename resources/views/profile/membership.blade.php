@extends('layouts.dashboard')


@section('content')

    <script src="{{ url('/') }}/js/highlight.js"></script>

    <body onload="highlight('membership_dash')">
    @include('flash::message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>Membership</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        {{--text--}}

        <div class="container-fluid">
            <div class="col-lg-5 col-lg-offset-1" style="text-align: center; padding-top: 10px;">
                <p style="font-weight: 700;">Your membership</p>
                <i class="fa fa-5x fa-arrow-down" id="arrow-icon" aria-hidden="true"></i>
            </div>
        </div>

        @if($visitor->member == 1)
            @include('components.member')
        @else
            @include('components.notmember')
        @endif
    </div>

    </body>




@endsection