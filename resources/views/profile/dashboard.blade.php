@extends('layouts.dashboard')
@section('content')
    <script src="{{ url('/') }}/js/highlight.js"></script>
    @include('flash::message')
    <body>
    <script type="application/javascript">
        highlight("dashboard_dash");
    </script>
    <div class="alert alert-info" role="alert" style="margin-bottom: 5px; text-align: center;">
        @if(Auth::user()->type==='visitor')
            Providers will see this overview when they look at your profile.
        @else
            Users will see this overview when they navigate to your profile.
        @endif
    </div>
    <div class="container-fluid">
        <div class="row">
            <div
                    @if($user->type ==='visitor')
                    class="col-md-12 ancestry-card background-bricks zero-padded"
                    @else
                    class="col-md-12 ancestry-card"
                        @endif
            >
                @include('components.summaryCard',['user_id' => $user->user_id])
            </div>
        </div>
        @if($user->type == 'provider')
            @if($images != null)
            <div class="row">
                <div class="col-md-12 ancestry-card">
                    @include('components.carousel', ['images' => $images])
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-12 ancestry-card">
                    <div class="panel-body" id="profile-map">
                        @include('components.map',['user'=>$user,'user_id'=> $user->user_id])
                    </div>
                </div>
            </div>

        @elseif($user->type == 'visitor')
            <div class="row">
                <div class="col-md-12 location ancestry-card">
                    @include('components.ancestors',['user_id'=> $user->user_id])
                </div>
            </div>
        @endif
    </div>

    </body>

    <script type="text/javascript">


        function toggle_visibility(id) {
            var e = document.getElementById(id);
            if (e.style.display == 'block')
                e.style.display = 'none';
            else
                e.style.display = 'block';
        }

        function toggle_visibility2(id1, id2) {
            var e = document.getElementById(id1);
            var e2 = document.getElementById(id2);
            e.style.display = 'block';
            e2.style.display = 'none';

        }

    </script>
@endsection