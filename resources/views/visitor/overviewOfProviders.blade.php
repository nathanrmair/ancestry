@extends('layouts.mainLayout')
@section('content')
    <body class="profile-img-body" id="contentM">
    @if(count($ids)==0)
        The site has no providers, awwwww...
    @endif
    <div id="dataContainer">
        <div class="col-lg-10 col-lg-offset-1">
            @foreach($ids as $user)

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-left">Credentials</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="container-fluid">
                        @include('components.summaryCard',['user_id' =>$user->user_id, 'summarise'=>true])
                        <a href="{{ url('/') }}/provider_overview/{{$user->user_id}}">View</a>
                    </div>

                </div>

            @endforeach
        </div>
    </div>

    @if(isset($offset))
        <form action="{{ url('/') }}/provider_overview" method="post">
            <div><input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" id="offset" value={{$offset}}
                        name="offset"/>

                @if($offset>0)
                    <button id="prev" style="display: inline;" type="submit"
                            name="Submit">Prev
                    </button>
                @endif
                <p id="page" style="display: inline;"></p>
                @if($offset+$size<$total)
                    <button id="next" type="submit"
                            name="Submit">Next
                    </button>
                @endif

                <select id="size" name="size">
                    <option>2</option>
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                    <option>30</option>
                    <option>50</option>
                </select>
            </div>
        </form>
    </body>
    <script>

                {{--@if(isset($size))--}}

        var size = "<?php echo($size)?>";
        var offset = "<?php echo($offset)?>";
        var total = "<?php echo($total)?>";
        var action = "next";

        function init() {
            var a = (parseInt(offset, 10) + 1);
            var b = (parseInt(offset, 10) + parseInt(size, 10));
            if (b > total) {
                b = total;
            }
            $("#page").html("showing " + a + " - " + b + " of " + total);
            $("#size").val(size);

        }

        $('form').submit(function () {
            if (action == "next") {
                var nextOffset = parseInt(offset, 10) + parseInt(size, 10);

                document.getElementById('offset').value = nextOffset;
            }
            else if (action == "prev") {

                var nextOffset = parseInt(offset, 10) - parseInt(size, 10);
                if (nextOffset >= 0) {
                    document.getElementById('offset').value = nextOffset;
                } else {
                    document.getElementById('offset').value = 0;
                }
            }
            else {

            }
        });

        $('#prev').click(function () {
            action = "prev";
        });

        $('#size').change(function () {
            action = "alter";
            this.form.submit();
        });

        $(document).ready(init());

    </script>
    @endif
@endsection