@extends('layouts.mainLayout')
@section('content')
    <?php $provider = App\Http\Controllers\ProfileController::getProviderById($provider_id); ?>
    <div class="container-fluid">
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-10 col-lg-offset-1">
            @include('components.summaryCard',['user_id' =>$provider->user_id])
        </div>
    </div>
    @if($images != null)
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-10 col-lg-offset-1 ancestry-card">
                @include('components.carousel', ['images' => $images])
            </div>
        </div>
    @endif
    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-10 col-lg-offset-1 ancestry-card">
            <div class="panel-body" id="profile-map">
                @include('components.map',['user'=>$provider,'user_id'=>$provider->user_id])
            </div>
        </div>
    </div>
    </div>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script type="application/javascript" src="{{ url('/') }}/js/message_provider.js"></script>
    <script src="{{ url('/') }}/js/lightbox/lightbox.js"></script>
@endsection