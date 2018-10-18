@extends('layouts.mainLayout')
<!--NOTE - key is not associated with an appropriate account and should be changed before the website goes live-->

@section('content')
    <?php $mapKey = App\Http\Controllers\MapController::getMapKey(); ?>
    <script  src="http://maps.googleapis.com/maps/api/js?v=3.exp&key={{$mapKey}}"></script>
    <link rel="stylesheet" href="{{ url('/') }}/js/dist/css/map-icons.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/searching.css">

    <div class="container" style="padding-top: calc(2% + 50px);">
        <div id="result" class="alert hidden fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close"
                                                         title="close">×</a></div>
        <div class="row" id="search-row">
            <div class="col-md-8">
                <h2>Search for a provider</h2>
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        {{ csrf_field() }}
                        <input type="text" class="form-control input-lg" name="search-query" id="search-box"
                               placeholder="Type a provider's name or keyword"/>
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" id="search-button" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </div> <b>OR</b>
                <button id="show-all" class="btn btn-primary show-all-btn">Show all</button>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row" id="map-row">
                <div class="col-md-8" id="map"  style="width: 100%; height:60vh;">

                </div>
            </div>
        </div>
        <div class="map-legend" style="width: 100%; padding-top: 5px;">
            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/museum.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Museum</span>

            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/archive.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Archive Centre/Records Office</span>

            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/heritage.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Heritage Centre</span>

            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/library.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Library</span>

            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/other.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Other (e.g. historic attraction)</span>

            <div style="display: inline-block; width: 30px; border-left: 1px solid lightgrey; padding-left: 2px;">
                <img src="{{url('/').'/img/icons/family.png'}}" style="width: 100%;">
            </div>
            <span style="padding-right: 7px;">Family History Society</span>
        </div>
        <div class="results">
            <table class="table table-bordered table-hover" id="results-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Postcode</th>
                    <th>Type</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div id="no-results-found">
                <i class="fa fa-5x fa-thumbs-o-down" aria-hidden="true"></i>
                <br>
                <br>
                <span> Sorry! We could not find a provider matching your search. </span>
            </div>
        </div>
    </div>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/searchbar.js"></script>
    <script src="{{ url('/') }}/js/dist/js/map-icons.js"></script>
    <script src="{{ url('/') }}/js/maps.js"></script>
    <script> initialize() </script>
@endsection