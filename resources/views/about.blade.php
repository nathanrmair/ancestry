@extends('layouts.mainLayout')

@section('content')

    <div class="container-fluid" style="padding-top: calc(2% + 50px); min-height: 80%;">
        <div class="row">
            <div class="col-lg-offset-2 col-md-8">
                <h1 style="font-weight: 700; color: #30aff0;">About Us</h1>
                <h2>Making connections with your ancestral past</h2>
                <br>

                <p style="font-size: large">
                Myancestralscotland was created by academics from University of Strathclyde in Glasgow.
                We heard about the growing ancestral tourism phenomena and wanted to find out more.
                Our research revealed a fascinating range of providers and some wonderful opportunities for visitors to Scotland.
                However, we also found a chronically underfunded sector and a huge amount of professional advice going unrewarded.
                That’s where myancestralscotland.com comes in. By creating a profile with us we can help you find ancestral tourism providers that can help you uncover your own ancestral past.
                By messaging our providers and booking searches you can ensure that these services are appropriately remunerated and that providers can go on providing this service in the future.
                </p>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-offset-2 col-md-8 col-lg-8" >
                <h3>Getting started with the website</h3>
                <iframe style="width: 100%; height: 40vh;" src="https://www.youtube.com/embed/RKo0WHQbBSU" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-2 col-md-8">
                <h3>Our Mission</h3>
                <p style="font-size: large">
                    Our mission is to make local Scottish ancestral services available to the Scottish diaspora around the world and ensure these professional services are appropriately rewarded.
                </p>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-offset-2 col-md-8 col-lg-8" >
                <h3>Mission Statement</h3>
                <iframe style="width: 100%; height: 40vh;" src="https://www.youtube.com/embed/kQraS4nE7KY" frameborder="0" allowfullscreen></iframe>
                <br>
                <br>
                <iframe style="width: 100%; height: 60vh;" id="iframe_container" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen src="https://prezi.com/embed/tm-lm0zwossm/?bgcolor=ffffff&amp;lock_to_path=0&amp;autoplay=0&amp;autohide_ctrls=0&amp;landing_data=bHVZZmNaNDBIWnNjdEVENDRhZDFNZGNIUE43MHdLNWpsdFJLb2ZHanI5Z1F6ZzlERmI1STBsV2NxOEtEUDBDVzRnPT0&amp;landing_sign=fwbAfqATz_kB7Aq-4FuoWyMieofkkcdnGEs4UAzzia0"></iframe>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-offset-2 col-md-8">
                <h3>Privacy Policy</h3>
                <p style="font-size: large">
                    Please have a look at our <a href="{{url('/').'/privacy_policy'}}">Privacy Policy</a> for more information.
                </p>
            </div>
        </div>

        <h2 class="text-center">The website is still under construction.</h2><br>
        <br>
    </div>

@endsection