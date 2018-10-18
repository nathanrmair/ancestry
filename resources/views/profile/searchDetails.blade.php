@extends('layouts.dashboard')


@section('content')

    <body>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">Search Details</div>
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
                                Search id: <span class="search-field">{{\Vinkla\Hashids\Facades\Hashids::encode($search->offered_search_id)}}</span>
                            </div>
                            <div class="search-details-element">
                                @if($user->type ==='visitor')
                                    Offered
                                    from: <span
                                            class="search-field">{{App\Provider::where('user_id',App\Conversations::where('conversation_id',$search->conversation_id)->first()->provider_id)->first()->name}}</span>
                                @else
                                    Offered
                                    to: <?php $visitor = App\Visitor::where('user_id', App\Conversations::where('conversation_id', $search->conversation_id)->first()->visitor_id)->first(); ?>
                                    <span class="search-field">{{$visitor->forename}} {{$visitor->surname}}</span>
                                @endif
                            </div>
                            <div class="search-details-element">
                                Price of search (in credits): <span class="search-field">{{$search->price}}</span>
                            </div>
                            <div class="search-details-element">
                                Pre-search information: <span class="search-field">{{$search->message}}</span>
                            </div>
                            <div class="search-details-element">
                                Date offered: <span class="search-field">{{$search->created_at}}</span>
                            </div>
                            <div class="search-details-element">
                                @if($search->status==='accepted')
                                    Status: <span style="color: #30aff0;"
                                                  class="search-field">{{$search->status}}</span>
                                @elseif($search->status==='declined')
                                    Status: <span style="color: red;" class="search-field">{{$search->status}}</span>
                                @elseif($search->status==='pending')
                                    Status: <span style="color: orange;" class="search-field">{{$search->status}}</span>
                                @elseif($search->status==='cancelled')
                                    Status: <span style="color: red;" class="search-field">{{$search->status}}</span>
                                @elseif($search->status==='completed')
                                    Status: <span style="color: green;" class="search-field">{{$search->status}}</span>
                                @endif
                            </div>
                            <div class="search-details-element">
                                Estimated completion date: <span
                                        class="search-field">{{$search->completion_date}}</span>
                            </div>
                            @if(isset($search->result_message))
                                <div class="search-details-element">
                                    Result message: <p class="search-field">{{$search->result_message}}</p>
                                </div>
                            @endif
                            @if(isset($docs))  {{--  if there are any files attached to search --}}
                            <div class="search-details-element">
                                Search result files: <br>
                                @forelse($docs as $doc)
                                    <a download="{{$doc['original_filename']}}"
                                       href="{{ \App\Http\Controllers\SearchesStatusController::getResultFilesBase64($doc['search_result_file_id'],
                                       $search->offered_search_id,
                                       App\Conversations::where('conversation_id',$search->conversation_id)->first()->provider_id) }}"
                                    >
                                        <b>{{$doc['original_filename']}}</b>
                                    </a><br>
                                @empty
                                    <span class="card-files">No documents provided</span>
                                @endforelse
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>

@endsection