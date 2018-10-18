@extends('layouts.dashboard')


@section('content')

    <script src="{{ url('/') }}/js/complete_search.js"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <body>
<?php $encoded_search_id = \Vinkla\Hashids\Facades\Hashids::encode($search->offered_search_id); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">Complete A Search</div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="col-lg-4" style="padding:20px; text-align: center;">
                        <i style="color: #30aff0;" class="fa fa-5x fa-search" aria-hidden="true"></i>
                        <br>
                        <i style="color: #30aff0;" class="fa fa-5x fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-8">
                        <div class="search-details-holder">
                            <div class="search-details-element">
                                Search id: <span class="search-field">{{$encoded_search_id}}</span>
                            </div>
                            <div class="search-details-element">
                                Offered
                                to: <?php $visitor = App\Visitor::where('user_id', App\Conversations::where('conversation_id', $search->conversation_id)->first()->visitor_id)->first(); ?>
                                <span class="search-field">{{$visitor->forename}} {{$visitor->surname}}</span>
                            </div>
                            <div class="search-details-element">
                                Pre-search information: <span class="search-field">{{$search->message}}</span>
                            </div>
                            <form name="completeSearch" id="completeSearch"
                                  action="{{ url('/profile/searches/complete') .'/'. $encoded_search_id}}"
                                  method="post" enctype="multipart/form-data" role="form">
                                {{ csrf_field() }}
                                <div class="container-fluid" style="padding: 0; margin: 5px;">
                                    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                        <div class="input-group">
                                            <label for="message" class="control-label">Result message:
                                            <textarea id="message"  maxlength="2000"rows = "4" columns = "10" class="form-control"
                                                   placeholder="Result message"
                                                   autofocus name="message"></textarea></label>
                                            @if ($errors->has('message'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="attachments-search">
                                        <span class="attach-document-label">Attach documents: </span>
                                        <label class="btn btn-default btn-file" id="choose-file-input">
                                            Choose files <input type="file" id="fileinput" name="fileinput[]"
                                                                accept="image/*, application/pdf, application/vnd.ms-powerpoint,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.slideshow,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain, .docx, .doc"
                                                                 style="display: none;" multiple/>
                                        </label>
                                        <br>
                                        <span class="bottom-message-buttons" style="margin: 0;" id="file-chosen"></span>
                                    </div>

                                    <button id="complete" class="btn btn-primary btn-block" type="submit">Complete this search
                                    </button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

@endsection