@extends('layouts.adminLayout')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="{{ url('/') }}/js/main.js"></script>

<script>

    var dataRows = "{{$individualJsonArray}}";

</script>


@section('content')

    <div class="container">

        <h1>Reports overview page</h1>

        <h2>Details for: {{$providerName}}</h2>

        <br>
        <hr>

        <div class="row">

            <h3>Message stats</h3>

            <div class="col-md-4">

                <canvas id="myChartMessages" width="300" height="300"></canvas>

            </div>
            <div class="col-md-4">

                <canvas id="pieChartMessages" width="300" height="300"></canvas>

            </div>
            <div class="col-md-4">

                <canvas id="polarChartMessages" width="300" height="300"></canvas>

            </div>

        </div>

        <br><br>
        <hr>

        <div class="row">

            <h3>Message stats</h3>

            <div class="col-md-4">

                <canvas id="myChartMessages" width="300" height="300"></canvas>

            </div>
            <div class="col-md-4">

                <canvas id="pieChartMessages" width="300" height="300"></canvas>

            </div>
            <div class="col-md-4">

                <canvas id="polarChartMessages" width="300" height="300"></canvas>

            </div>

        </div>

    </div>



@stop