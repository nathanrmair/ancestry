@extends('layouts.dashboard')


@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><h3>Are you sure you wish to delete this ancestor?</h3></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="container-fluid ">
            <div class="col-lg-8 col-lg-offset-4">
                <br>
                @include('components.ancestorCard',['ancestor_id'=>$ancestor_id])
                <br>
            </div>
            <br>
            <div class="col-md-6">
                <form class="edit-form" name="ancestor-delete-form" onsubmit="buttonDisable('delete-anc'); buttonDisable('keep-anc'); "
                      action="{{url('/ancestor/delete')}}" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="ancestor_id" value="{{$ancestor_id}}">
                    <input type="hidden" name="confirmed" value="true">

                    <button class="btn btn-primary btn-lg btn-block" id="delete-anc"
                            style="margin-top: 10px;" name="submit" type="submit">Yes, Delete Ancestor
                    </button>

                </form>
            </div>
            <div class="col-md-6">
                <form class="edit-form" name="provider-edit-form" action="{{url('/ancestor/edit/'.$ancestor_id)}}" onsubmit="buttonDisable('delete-anc'); buttonDisable('keep-anc'); "
                      method="GET" enctype="multipart/form-data">

                    <button class="btn btn-primary btn-lg btn-block" style="margin-top: 10px; margin-bottom:2%" id="keep-anc" name="submit"
                            type="submit">No, Keep Ancestor
                    </button>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).load(highlight());

        function highlight() {

            holder = document.getElementById('ancestors_dash');
            holder.className = holder.className + ' blueholder';
            holder.style.paddingLeft = '15%';
        }
    </script>
@endsection