@extends('layouts.mainLayout')
@section('content')

    <div class="container-fluid" style="padding-top: calc(50px + 2%); min-height: 80%;">
        <div class="row" style="padding-top: 15px;">
            <div class="col-lg-offset-1 col-lg-10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-left"><b>Profile Information</b></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="container-fluid  background-bricks">
                        @include('components.summaryCard',['user_id' =>$user_id])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                @if(App\Http\Controllers\AncestorController::hasAncestors($user_id))
                    <div class="panel panel-default ancestor-head ">
                        <div class="panel-heading ">
                            <div class="pull-left">Ancestors</div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="panel-body ">
                            <div class="col-md-10 col-md-offset-1 location">
                                @include('components.ancestors',['user_id'=>$user_id])
                            </div>
                        </div>
                    </div>
                @else
                    <h2 style="text-align: center;">No ancestor information provided.</h2>
                @endif
            </div>
        </div>
    </div>
    <script src="{{ url('/') }}/js/lightbox/lightbox.js"></script>
@endsection