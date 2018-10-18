@extends('layouts.mainLayout')


@section('content')


    <body class="login-body">

    <div class="container" style="padding-top: calc(2% + 50px);">


            <form class="signup-form" name="signup-form"  action="{{ url('/register') }}" method="POST" role="form" onsubmit="buttonDisable('register-submit')">
                {{ csrf_field() }}
                <div class="legend" style="font-size:22px;">Register</div>

                <p id="login-img-p"><i class="fa fa-4x fa-pencil-square-o" ></i></p>


                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="control-group">
                        <label class="control-label" for="email">E-mail</label>
                        <div class="controls">
                            <input id="email" type="email" maxlength="254" class="form-control input-lg" name="email" value="{{ old('email') }}">

                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input id="password" type="password" class="form-control input-lg" name="password">

                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="control-group">
                        <label class="control-label" for="password-confirm">Password (Confirm)</label>
                        <div class="controls">
                            <input id="password-confirm" type="password" class="form-control input-lg" name="password_confirmation">
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="control-group">
                <label style="color: black;">
                    <input  class="pull-left" id="remember-me-checkbox" type="checkbox" name="news"><span class="pull-left remember-me">I would like to receive a copy of the monthly newsletter by email</span></label>
                    </div>

                <div class="control-group">
                    <!-- Button -->
                    <div class="controls">
                        <button id="register-submit" class=" btn btn-primary btn-lg btn-block" type="submit" >Register</button>
                    </div>


                </div>
                <div style="margin-top: 2%;">
                <span style="color: black; margin-top: 10px;" >If you are representing a provider
                    and you would like to work with us please follow this link:  <a class="btn-link" style="color: darkblue;" href="{{ url('/provider_reg') }}"> Provider sign up</a></span>
                </div>
            </form>


    </div>
    </body>



@endsection
