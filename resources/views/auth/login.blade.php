@extends('layouts.mainLayout')

@section('content')


    <body class="login-body">

    <div class="container" style="padding-top: calc(2% + 50px);">
        @include('flash::message')


        <form name="login" id="login" action="{{ url('/login') }}" method="post" class="login-form" role="form" onsubmit="buttonDisable('login-submit')" >
            {{ csrf_field() }}
            <div class="login-wrap">
                <div class="legend" style="font-size:22px;">Login</div>
                <p id="login-img-p"><i class="fa fa-4x fa-key" ></i></p>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" ></i></span>
                        <input id="email"  maxlength="254" type="text" class="form-control"  placeholder="Email" autofocus name="email" value="{{ old('email') }}">

                    </div>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" ></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">


                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                <label style="color: black;">
                    <input  class="pull-left" id="remember-me-checkbox" type="checkbox" name="remember"><span class="pull-left remember-me"> Remember me</span></label>
                    <label class="pull-right">  <a  class="btn-link" href="{{ url('/password/reset') }}"><span style="color: darkblue;">Forgot Your Password?</span></a></label>
                </div>
                <button id="login-submit" class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            </div>
        </form>
    </div>


    </body>
@endsection
