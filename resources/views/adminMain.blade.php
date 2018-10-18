@extends('layouts.adminLayout')


@section('content')

    <div class="container-fluid container-position">
        <div class="panel panel-default" style="padding-bottom:10px;">
            <div class="panel-heading">
                <div class="pull-left">Admin Main Page</div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-offset-1 col-md-11 text-center">
                    <h2>Edit/Update Details</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-11 text-center">
                    <h3>Search Users</h3>
                    <div class="btn-group btn-group-lg">
                        <a href="{{action('Admin\UsersController@index')}}">
                            <button type="button" class="btn btn-primary">View all users</button></a>
                        <a href="{{action('Admin\UsersController@search')}}">
                            <button type="button" class="btn btn-primary">Search user parameters</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-offset-1 col-md-11 text-center">
                    <h2>Reports</h2>
                    <div class="btn-group btn-group-lg">
                        <a href="{{action('Admin\ReportsController@showReports')}}">
                            <button type="button" class="btn btn-primary">Reports overview</button>
                        </a>
                    </div>
                    <div class="btn-group btn-group-lg">
                        <a href="{{ url('admin/reports/providers') }}">
                            <button type="button" class="btn btn-primary">Provider reports</button>
                        </a>
                    </div>
                    <div class="btn-group btn-group-lg">
                        <a href="{{ url('admin/queries-report') }}">
                            <button type="button" class="btn btn-primary">Queries</button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-offset-1 col-md-11 text-center">
                    <h2>Approve pending providers</h2>
                    <div class="btn-group btn-group-lg">
                        <a href="approveProviders">
                            <button type="button" class="btn btn-primary">Approve providers</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-11 text-center">
                    <h2>Email Facilities</h2>
                    <div class="btn-group btn-group-lg">
                        <a href="{{ url('/admin/email-all-visitors') }}">
                            <button type="button" class="btn btn-primary">Email all visitors</button>
                        </a>
                        <a href="{{ url('/admin/email-all-providers') }}">
                            <button type="button" class="btn btn-primary">Email all providers</button>
                        </a>
                        <a href="{{url('/admin/send-newsletter')}}">
                            <button type="button" class="btn btn-primary">Send Newsletter</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-11 text-center">
                    <h2>FAQs</h2>
                    <div class="btn-group btn-group-lg">
                        <a href="{{ url('/FAQs') }}">
                            <button type="button" class="btn btn-primary">Edit FAQs</button>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop