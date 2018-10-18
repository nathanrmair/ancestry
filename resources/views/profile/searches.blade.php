@extends('layouts.dashboard')


@section('content')
    <script src="{{ url('/') }}/js/highlight.js"></script>

    <body>
    <script type="application/javascript">
        highlight("searches_dash");
    </script>
    @include('flash::message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>My Ancestors Searches</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        {{--text--}}

        <div class="container-fluid">
            <div class="row" style="max-height: 100vh;overflow: auto">
                @if($searches == null || count($searches)==0)
                    @if($user->type==='visitor')
                        <p><h3 style="padding-left: 10px;">You haven't been offered any searches yet.</h3></p>
                    @else
                        <p><h3 style="padding-left: 10px;">You haven't offered any searches yet.</h3></p>
                    @endif
                @else
                    <table class="table table-bordered table-hover" id="results-table" style="margin: 0">
                        <thead>
                        <tr>
                            <th>
                                @if($user->type==='visitor')
                                    Offered from
                                @else
                                    Offered to
                                @endif
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                View details
                            </th>
                            @if($user->type==='provider')
                                <th>
                                    Complete this search
                                </th>
                                @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($searches as $search)
                            <tr>
                                <td>
                                    @if($user->type === 'visitor')
                                        {{App\Provider::where('user_id',App\Conversations::where('conversation_id',$search->conversation_id)->first()->provider_id)->first()->name}}
                                    @else
                                        <?php $visitor = App\Visitor::where('user_id', App\Conversations::where('conversation_id', $search->conversation_id)->first()->visitor_id)->first(); ?>
                                        {{$visitor->forename}} {{$visitor->surname}}
                                    @endif
                                </td>
                                <td>
                                    @if($search->status==='accepted')
                                        <span style="color: #30aff0;">{{$search->status}}</span>
                                    @elseif($search->status==='declined')
                                        <span style="color: red;">{{$search->status}}</span>
                                    @elseif($search->status==='pending')
                                        <span style="color: orange;">{{$search->status}}</span>
                                    @elseif($search->status==='cancelled')
                                        <span style="color: red;">{{$search->status}}</span>
                                    @elseif($search->status==='completed')
                                        <span style="color: green;">{{$search->status}}</span>
                                    @endif
                                </td>
                                <td><a href="{{url('/profile/searches').'/'. \Vinkla\Hashids\Facades\Hashids::encode($search->offered_search_id)}}">
                                        <button class="btn btn-primary">Details</button>
                                    </a></td>
                                @if($user->type==='provider')
                                    @if($search->status === 'accepted')
                                    <td>
                                        <a href="{{url('/profile/searches/complete').'/'. \Vinkla\Hashids\Facades\Hashids::encode($search->offered_search_id)}}">
                                            <button class="btn btn-success">Complete</button>
                                        </a>
                                    </td>
                                        @elseif($search->status === 'completed')
                                        <td>
                                            <span style="color: orange;">Already completed</span>

                                        </td>
                                        @else
                                        <td>
                                            <span style="color: orange;">Not available at this stage</span>

                                        </td>
                                        @endif
                                    @endif
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    </body>


@endsection