@extends('layouts.errors')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="error">
                <img class="error-image" src="{{url("img/highland-cow.jpg")}}">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="container-fluid">
            <div class="error-message-value">
                Error!
                <br>
                404 File Not Found!
            </div>
                </div>
        </div>
    </div>
    <div style="text-align: center;"><a href="{{url('/')}}">
            <button class="btn btn-primary btn-lg">Back to Home</button>
        </a>
    </div>
    </div>
@endsection