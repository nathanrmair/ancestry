<div class="row">

    <div class="col-lg-8 col-lg-offset-2"><h2> Providers you recently visited </h2>
        <hr>
    </div>
</div>
<div class="row">
@if(count($providers) >= 3)
    <div class="col-lg-4">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[0]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[0]->avatar_id != 0)
                         src="{{$providers[0]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[0]->name}}</span></div>
                </div>
            </a>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[1]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[1]->avatar_id != 0)
                         src="{{$providers[1]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[1]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[2]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[2]->avatar_id != 0)
                         src="{{$providers[2]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[2]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
@elseif(count($providers) == 2)
    <div class="col-lg-4 col-lg-offset-1">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[0]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[0]->avatar_id != 0)
                         src="{{$providers[0]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[0]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-lg-offset-2">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[1]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[1]->avatar_id != 0)
                         src="{{$providers[1]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[1]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>

@elseif(count($providers) == 1)
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-default deep_shadowed">
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($providers[0]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($providers[0]->avatar_id != 0)
                         src="{{$providers[0]->avatar}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name"><span>{{$providers[0]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
@endif
</div>

