@extends('layouts.mainLayout')


{{--}}move to mainLayout.blade.php to make the full table row clickable--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<script>

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });

</script>
{{--}}move to mainLayout.blade.php --}}

@section('content')



    <h1>Visitors by membership</h1>

    <hr>

    <div class="container">

        <h2>Visitor Details</h2>
        <p>Select a visitor from the table:</p>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Visitor ID</th>
                <th>Forename</th>
                <th>Surname</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Member</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Origin</th>
                <th>Description</th>
            </tr>
            </thead>

            @foreach($visitors as $visitor)

                <tbody>
                <tr class='clickable-row' data-href="{{action('Admin\VisitorController@searchById', [$visitor->visitor_id])}}">

                    <td>{{$visitor->visitor_id}}</td>
                    <td>{{$visitor->forename}}</td>
                    <td>{{$visitor->surname}}</td>
                    <td>{{$visitor->user_id}}</td>
                    <td>{{$visitor->status}}</td>
                    <td>{{$visitor->member}}</td>
                    <td>{{$visitor->dob}}</td>
                    <td>{{$visitor->gender}}</td>
                    <td>{{$visitor->origin}}</td>
                    <td>{{$visitor->description}}</td>

                </tr>



                @endforeach

                </tbody>
        </table>





    </div>

    @stop