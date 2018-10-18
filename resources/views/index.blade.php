@extends('layouts.mainLayout')

@section('content')


    <header>
        <div style="padding-top: 50px;">
        @include('flash::message')
        </div>
        <div class="header-content">
            <div class="header-content-inner">
                <h1 id="homeHeading">My Ancestral Scotland</h1>
                <h4>The perfect place for finding out more about your ancestral roots in Scotland</h4>
            </div>
        </div>
    </header>

{{--UNDER CONSTRUCTION BANNER--}}
<!--
    <div  style="
    position: fixed;
    width: 150%;
    height: auto;
    top: 50vh;
    left: -25%;
    padding: 2px 45px;
    line-height: 10vh;
    font-size: 6vh;
    -webkit-transform: rotate(30deg);
    -ms-transform: rotate(30deg);
    transform: rotate(30deg);
    color: rgba(255, 255, 255, 0.6);
    background: rgba(255, 0, 0, 0.6);
    text-align: center;
    z-index: 10;
    pointer-events: none;">
        UNDER CONSTRUCTION
    </div>
    -->

    {{--END OF BANNER--}}

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center">
                    <p>We have a wide range of professional ancestral tourism service providers including: museums, heritage centres, family/local history societies, archive centres as well as historic attractions.
                        They work with us to ensure you can learn everything you want to know about your ancestral past in Scotland.</>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Visit our providers' profile pages to learn everything you could need to
                        know about them</h2>
                    <hr class="light">
                    <p>Start messaging with a representative of the provider and let them know who
                        you are searching for. <br>
                        You may get lucky and find out exciting new facts about your ancestors</p>
                    <a href="#services" class="page-scroll btn btn-default btn-xl sr-button">Get Started!</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">At Your Service</h2>
                    <hr>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 text-center">
                    <div class="service-box">
                        <a href="{{url('/profile/dashboard')}}"><span
                                    class="fa-5x glyphicon glyphicon-user text-primary sr-icons index-icon"></span></a>
                        <h3>My Ancestry Profile</h3>
                        <p class="text-muted">Create your own profile with all the information on your ancestors.
                            Use this profile to keep track of all the information you learn</p>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-center">
                    <span class="fa-3x glyphicon glyphicon glyphicon-arrow-right text-primary sr-icons connector-icon"></span>
                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <div class="service-box">
                        <a href="{{url('/search')}}"><span
                                    class="fa-5x glyphicon glyphicon-envelope text-primary sr-icons index-icon"></span></a>
                        <h3>Contact Providers</h3>
                        <p class="text-muted">Want to find out more about your ancestors?
                            You can search for different museums and heritage centres with relevant information</p>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 hidden-sm hidden-xs text-center">
                    <span class="fa-3x glyphicon glyphicon glyphicon-arrow-right text-primary sr-icons connector-icon"></span>
                </div>
                <div class="col-lg-3 col-md-3 text-center">
                    <div class="service-box">
                        <a href="#interactive-map" class="page-scroll"><i
                                    class="fa fa-5x fa-search text-primary sr-icons index-icon"></i></a>
                        <h3>Discover Your Roots</h3>
                        <p class="text-muted">Find information about your ancestors!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(\Illuminate\Support\Facades\DB::table('providers')->get()!=null)
    <section class="featured" style="padding-bottom: 0;padding-top: 5%;">
        <h2 class="text-center"> Featured Providers</h2>
        <hr>
        <br>
        @include('components.featured_providers')
    </section>


    @if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::User()->type !== 'provider')
        @if($providers!=null)
        <section id="visitAgain" style="padding-top: 5%;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        @include('components.visitSessionProvidersAgain', ['providers' => $providers])
                    </div>
                </div>
            </div>
        </section>
        @endif
    @endif
    @endif
    <section class="no-padding" id="interactive-map">
        @include('components.interactive_map')
    </section>


@endsection
