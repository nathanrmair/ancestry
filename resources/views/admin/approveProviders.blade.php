@extends('layouts.adminLayout')


@section('content')

    <div style="margin: 15px; margin-bottom: 0">
    @include('flash::message')
        </div>

    <div class="panel panel-default" style="margin: 15px; margin-bottom: 0">
        <div class="panel-heading">
            <div class="pull-left">Pending providers</div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        <div class="container" style="padding: 0; width: 100%; max-height: 400px; overflow: auto;">
            @if (!$pending->isEmpty())
                <div class="results">
                    <table class="table table-bordered table-hover" id="results-table" style="margin: 0">
                        <thead>
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Postcode
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Approve
                            </th>
                            <th>
                                Decline
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pending as $provider)
                            <tr>
                                <td>{{$provider->id}}</td>
                                <td>{{$provider->email}}</td>
                                <td>{{$provider->name}}</td>
                                <td>{{$provider->postcode}}</td>
                                <td>{{$provider->type}}</td>
                                <td>{{$provider->description}}</td>
                                <td>
                                <a href="{{url('admin/approve/'.$provider->id)}}"><button type="button" class="btn btn-primary btn-md">Approve</button></a>
                                </td>
                                <td>
                                    <a href="{{url('admin/decline/'.$provider->id)}}"><button type="button" class="btn btn-primary btn-md">Decline</button></a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else

                <div style="margin: 15px; font-size: 150%;">
                    No pending providers.
                </div>

            @endif

        </div>
    </div>



@endsection