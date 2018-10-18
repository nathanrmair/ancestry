@extends('layouts.dashboard')

@section('content')
    <script src="{{ url('/') }}/js/highlight.js"></script>


    <script type="application/javascript">
        highlight("ancestors_dash");
    </script>
    @include('flash::message')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>Ancestors</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="panel-body">
            <div class="col-lg-10 col-lg-offset-1">
                @include('components.ancestors',['user_id'=>$user_id,'edit_id'=>$visitor_id])

                <noscript>
                    <form id="noscriptForm" action="{{ url('/') }}/ancestor/create">
                        <button class="btn btn-primary btn-lg btn-block">Add Ancestor</button>
                    </form>
                </noscript>

                    <button id="scriptButton" class="btn btn-primary btn-lg btn-block" style="margin-top: 10px; margin-bottom: 10px; display:none"
                            onclick="createAnc()">Add
                        Ancestor
                    </button>

            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        $(document).load(init());

        function init(){
            $("#scriptButton").show();
        }


        function createAnc() {
            window.location.replace(base_url() + "ancestor/create");
        }
    </script>
@endsection