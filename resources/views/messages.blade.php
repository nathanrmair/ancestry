@extends('layouts.dashboard')
@section('content')
    <script src="{{ url('/') }}/js/highlight.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <link rel="{{ url('/') }}/css/datepicker.css"/>


    <!-- for datepicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/messages.css">
    <script type="application/javascript">
        highlight("messages_dash");
    </script>
    <div id="result" class="alert hidden fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close"
                                                     title="close">×</a></div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>Messages</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="container-fluid">
            @if(empty($conversations))
                @if(Auth::user()->type==='visitor')
                    <p><h2>No messages yet. Why don't you <a href="{{ url('/') }}/search">search for a provider</a> and
                        start chatting?</h2></p>
                @else
                    <p><h2>No messages yet. Messages will appear here when users contact you.</h2></p>
                @endif
            @else
                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group list-unstyled" id="conversation-list" style="max-height: 500px; overflow: auto;">
                            <h3 class="text-center">Conversations</h3>
                            @forelse ($conversations as $conversation)
                                <a class="conversation-column list-group-item" href="#"
                                   id="{{ $conversation->conversation_id }}"
                                   data="{{ (\Illuminate\Support\Facades\Auth::User()->type === 'visitor')?$conversation->provider_id:$conversation->visitor_id}}">

                                    <div class="no-overflow pull-left avatar">
                                        <span class="label label-primary label-as-badge hidden"
                                              id="message-badge-{{ $conversation->conversation_id }}">&RightAngleBracket;</span>
                                        @if (Auth::User()->type === 'visitor')
                                            @if(json_decode($conversation->provider_source)!="null")
                                                <img src="{{json_decode($conversation->provider_source)}}"
                                                     class="user-avatar"
                                                     id="user-avatar-{{$conversation->provider_id}}">
                                            @else
                                                <img src="{{ url('/') }}/img/avatar/default_provider.png"
                                                     class="user-avatar"
                                                     id="user-avatar-{{$conversation->provider_id}}">
                                            @endif
                                        @else
                                            @if(json_decode($conversation->visitor_source)!="null")
                                                <img src="{{json_decode($conversation->visitor_source)}}"
                                                     class="user-avatar" id="user-avatar-{{$conversation->visitor_id}}">
                                            @else
                                                <img src="{{ url('/') }}/img/avatar/default_visitor.png"
                                                     class="user-avatar" id="user-avatar-{{$conversation->visitor_id}}">
                                            @endif
                                        @endif

                                    </div>
                                    <div>
                                        @if (Auth::User()->type === 'visitor')
                                            <div id="provider-name-{{$conversation->provider_id}}"
                                                 style="overflow: auto;">{{ \MessagesHelper::getNameOfProvider(\Vinkla\Hashids\Facades\Hashids::decode($conversation->provider_id)[0]) }}</div>
                                        @else
                                            <div id="visitor-name-{{$conversation->visitor_id}}"
                                                 style="overflow: auto;">{{ \MessagesHelper::getNameOfVisitor(\Vinkla\Hashids\Facades\Hashids::decode($conversation->visitor_id)[0]) }}</div>
                                        @endif
                                        <div id="conversation-last-{{$conversation->conversation_id}}"
                                             class="last-message-overflow">
                                            <p>{{ \MessagesHelper::getLastMessage(\Vinkla\Hashids\Facades\Hashids::decode($conversation->conversation_id)[0]) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                No conversations yet
                            @endforelse
                        </div>
                        @if(Auth::user()->type==='visitor')
                            <div style="text-align: center"><a href="{{url('/search')}}">
                                    <button class="btn btn-default" id="choose-file-input">New conversation</button>
                                </a></div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="row text-center">
                            <a class="col-md-8 col-md-offset-2" id="conversation-title-anchor"
                               @if(Auth::User()->type === 'visitor')
                               href="{{ url('/') }}/provider_overview/{{ $conversations[0]->provider_id }}"
                               @else
                               href="{{ url('/') }}/visitor_overview/{{ $conversations[0]->visitor_id }}"
                               @endif
                               style="text-decoration: none;">
                                @if (Auth::User()->type === 'visitor')
                                    @if(json_decode($conversations[0]->provider_source) != "null")
                                        <img id="title-avatar" src="{{json_decode($conversations[0]->provider_source)}}"
                                             class="avatar-top">
                                    @else
                                        <img id="title-avatar" src="{{ url('/') }}/img/avatar/default_provider.png"
                                             class="avatar-top"/>
                                    @endif
                                @else
                                    @if(json_decode($conversations[0]->visitor_source) != "null")
                                        <img id="title-avatar" src="{{json_decode($conversations[0]->visitor_source)}}"
                                             class="avatar-top"/>
                                    @else
                                        <img id="title-avatar" src="{{ url('/') }}/img/avatar/default_visitor.png"
                                             class="avatar-top"/>
                                    @endif
                                @endif
                                <div id="conversation-title"
                                     style="max-width: 100%; overflow: auto;">{{ $lastConvName }}</div>
                            </a>
                        </div>
                        <meta name="last-conv" content="{{ $lastConvId }}"/>
                        <meta name="userType" content="{{ Auth::User()->type }}"/>
                        <div id="conversation-content">
                            <div id="loadMoreField"></div>
                            <div id="more-results"></div>
                            <div id="initial-results"></div>
                            @unless($conversations)
                                <p>No messages. Why don't you search for a provider and start chatting?</p>
                            @endunless

                        </div>
                        <div id="offered-searches-box" class="hidden">
                            <h3>Offered Searches</h3>
                        </div>
                        <div class="clearfix"></div>
                        <div class="new-message">
                            <form class="new-message-form" name="new-message-form" id="new-message-form"
                                  action="{{ url('/message/new') }}" method="POST" role="form"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <label class="control-label" for="message">New Message</label>
                                <div class="controls">

                                            <textarea maxlength="2000" class="form-control vresize"
                                                      id="message-textarea" name="message"
                                                      rows="6"
                                                      placeholder="Enter a new message..."></textarea>
                                    <span class="pull-left attach-document-label">Attach a document: </span>

                                    <label class="btn btn-default pull-left btn-file" id="choose-file-input">

                                        Choose file <input type="file" id="fileinput" name="fileinput"
                                                           accept="image/*, application/pdf, application/vnd.ms-powerpoint,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.slideshow,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain, .docx, .doc"
                                                           style="display: none;">
                                    </label>
                                    <span class="bottom-message-buttons pull-left" id="file-chosen"></span>
                                </div>

                                <meta name="_token" content="{{ csrf_token() }}"/>
                                <input name="providerId" type="hidden" value="secret">
                                <input name="visitorId" type="hidden" value="secret">
                                <input name="conversationId" type="hidden" value="secret">
                                <button type="button" id="send-button"
                                        class="btn btn-primary btn-md bottom-message-buttons">Send
                                </button>
                                @if(\Illuminate\Support\Facades\Auth::User()->type === 'provider')
                                    <button type="button" id="offer-a-search-button"
                                            class="btn btn-primary btn-md hidden">
                                        Offer a
                                        Search
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/lightbox/lightbox.js"></script>
@endsection