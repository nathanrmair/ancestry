<?php $mostcontacted = App\Http\Controllers\SearchController::findMostPopular(); ?>
<?php $newest = App\Http\Controllers\SearchController::findLatest(); ?>

<div class="row featured-row">
    @if($mostcontacted!=null)
    <div class="col-lg-4 col-lg-offset-1 featured-col">
        <div class="panel panel-default deep_shadowed">
            <div class="panel-heading" style="font-weight: bold; font-size: large;">Most Contacted <i class="fa fa-star membership-avatar" style="color: #e2da23; vertical-align: middle"
                                                                                                      id="arrow-icon" aria-hidden="true"></i></div>
            <a href="{{url('/provider_overview/').'/'.\Vinkla\Hashids\Facades\Hashids::encode($mostcontacted->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($mostcontacted->avatar_id != 0)
                         src="{{json_decode(App\Http\Controllers\ProfileController::getAvatarSource($mostcontacted->user_id))}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >
                    <div class="featured-name">
                        <span>{{$mostcontacted->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if($newest)
    <div class="col-lg-4 col-lg-offset-2 featured-col">
        <div class="panel panel-default deep_shadowed">
            <div class="panel-heading" style="font-weight: bold; font-size: large;">Recently Joined</div>
            <a href="{{url('/provider_overview').'/'.\Vinkla\Hashids\Facades\Hashids::encode($newest[0]->user_id)}}">
                <div class="featured-container">
                    <img class="featured-avatar"
                         @if($newest[0]->avatar_id != 0)
                         src="{{json_decode(App\Http\Controllers\ProfileController::getAvatarSource($newest[0]->user_id))}}"
                         @else
                         src="{{ url('/') }}/img/avatar/default_provider.png"
                            @endif
                    >

                    <div class="featured-name"><span>{{$newest[0]->name}}</span></div>
                </div>
            </a>
        </div>
    </div>
        @endif
</div>