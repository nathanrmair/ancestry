@extends('layouts.adminLayout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md 9">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td><h3>Query</h3></td>
                            <td><h3>Hits</h3></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($queries as $query)
                            <tr>
                                <td>{{$query->query}}</td>
                                <td>{{$query->hits}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection