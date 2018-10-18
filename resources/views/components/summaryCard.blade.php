<?php
$user = App\Http\Controllers\ProfileController::getUser($user_id);
$source = App\Http\Controllers\ProfileController::getAnAvatar($user_id);?>
@if($user->type == 'provider') <?php $data = App\Http\Controllers\ProfileController::getProvider($user_id); ?>
@elseif($user->type == 'visitor')<?php $data = App\Http\Controllers\ProfileController::getVisitor($user_id); ?>
@else <?php $data == null;?>
@endif

<script src="{{ url('/') }}/js/form-mandatory-fields.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="text-center">
            @if (isset($data->name))
                <h2 id="name">{{$data->name}}</h2>

            @elseif (isset($data->forename)||isset($data->surname))
                <h2 id="name">{{$data->forename}} {{$data->surname}}</h2>
            @endif
        </div>
    </div>
</div>
<div @if($user->type=='provider')
     class="row"
     @else
     class="row zero-margin"
        @endif
>
    <div @if($user->type=='provider')
         class="col-lg-12 text-center"
         @else
         class="col-lg-4 text-center zero-padded"
            @endif
    >
        @if($data->avatar_id == 0)
        @if($user->type=='visitor')
        </span><img class="user-avatar overview-avatar"
                    src="{{ url('/') }}/img/avatar/default_visitor.png"
                    style="max-width: 500px;">
        @else
            <img class="provider-avatar" src="{{ url('/') }}/img/avatar/default_provider.png">
        @endif
        @else
            <img @if($user->type==='visitor')
                 class="user-avatar overview-avatar"
                 @else
                 class="provider-avatar"
                 @endif
                 src="{{json_decode($source)}}">
        @endif
    </div>
    @if($user->type=='provider')
</div>
<div class="row">
    @endif
    <div @if($user->type=='provider')
         class="col-lg-6 col-lg-offset-3 text-center zero-padded"
         @else
         class="col-lg-6 col-lg-offset-1 text-center zero-padded"
            @endif
    >
        <ul class="list-group list-group-flush trans" style="width: auto">
            @if (isset($data->type))
                <li class="list-group-item"><span class="title">Type:</span>
                    <span id="type">{{$data->type}}</span>
                    @endif
                </li>
                @if (isset($data->description))
                    <li class="list-group-item"><span class="title">Description:</span>
                        <span id="description">{{$data->description}}</span>
                    </li>
                @endif
                @unless(isset($summarise))
                    @if (isset($data->prices))
                        <li class="list-group-item"><span class="title">Prices:</span> <span
                                    id="price">{{$data->prices}}</span>
                        </li>
                    @endif
                    @if (isset($data->open_hour))
                        <li class="list-group-item"><span class="title">Opening hours: </span><span
                                    id="open">{{$data->open_hour}}</span>
                        </li>
                    @endif
                    @if (isset($data->close_hour))
                        <li class="list-group-item"><span class="title">Closed: </span><span
                                    id="close">{{$data->close_hour}}</span>
                        </li>
                    @endif
                @endunless
                @if (isset($data->dob))
                    <li class="list-group-item"><span class="title"> Date of Birth: </span><span
                                id="dob">{{$data->dob}}</span>
                    </li>
                @endif
                @if($user->type == 'provider')

                    <li class="list-group-item"><span class="title">Address:</span><br>
                        @if (isset($data->street_name))
                            {{$data->street_name}}<br>
                        @endif
                        @if (isset($data->county))
                            {{$data->county}}<br>
                        @endif
                        @if (isset($data->town))
                            {{$data->town}}<br>
                        @endif
                        @if (isset($data->region))
                            {{$data->region}}<br>
                        @endif
                        @if (isset($data->postcode))
                            {{$data->postcode}}<br>
                        @endif
                    </li>
                    @unless(isset($summarise))
                        @if (isset($data->historic_county))
                            <li class="list-group-item"><span class="title">Historic County:</span>
                                <span id="historic_county">{{$data->historic_county}}</span>
                            </li>
                        @endif
                    @endunless

                @endif
                @if (isset($data->origin))
                    <li class="list-group-item"><span class="title">Origin:</span>
                        <span id="origin">{{$data->origin}}</span>
                    </li>
                @endif
                @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->type==='visitor')
                    @if($user->type==='provider')
                        <li class="list-group-item">
                            <button id="new-message" data-user-id="{{\Vinkla\Hashids\Facades\Hashids::encode($user_id)}}"
                                    data-user-name="{{ $data->name }}"
                                    class="btn btn-primary" style="background-color: #30aff0;"><i
                                        class="fa fa-envelope-o" aria-hidden="true"></i> Message
                            </button>
                        </li>
                    @endif
                @endif
        </ul>
    </div>
</div>





