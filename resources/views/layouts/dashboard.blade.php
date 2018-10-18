<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!--important line for IE-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="Ancestral Scotland, Ancestry, Clan, Scotland, Museum, Battle">
    <link rel='shortcut icon' type='image/x-icon' href={{url('img/favicon.ico')}}/>

    <title>@if(!isset($title))
            MyAncestralScotland
        @else
            {{$title}}
        @endif
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
            integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!--external css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/lightbox/lightbox.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/messages.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/ancestry.css">
    <link rel="stylesheet" href="{{ url('/') }}/css/app.css">


</head>

<body>


@include('components.top_navbar')

<?php $user = Illuminate\Support\Facades\Auth::User(); ?>
<?php
$ismember = 1;
if ($user->type == 'visitor') {
    $visitor = App\Visitor::where('user_id', $user->user_id)->first();
    $ismember = $visitor->member;
}
?>

<div class="container-fluid" style="padding-top: calc(2% + 50px);">
    <div class="row">
        <div class="col-md-2">
            <div class="list-group list-unstyled">
                <a id="dashboard_dash" href="{{ url('/profile/dashboard/') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-user pull-right" aria-hidden="true"></i>  Overview</a>
                @if($ismember)
                    <a id="messages_dash" href="{{ url('/profile/dashboard/messages') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-envelope pull-right" aria-hidden="true"></i>My
                        messages</a>
                @endif
                <a id="profile_dash" href="{{ url('/profile/edit/') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-edit pull-right" aria-hidden="true"></i>Edit Profile</a>
                @if($user->type == 'visitor')
                    <a id="ancestors_dash" href="{{ url('/ancestors') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-group pull-right" aria-hidden="true"></i>Ancestors</a>
                @endif
                @if($ismember)
                    <a id="credits_dash" href="{{ url('/profile/credits/') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-credit-card pull-right" aria-hidden="true"></i>Credits</a>
                @endif
                @if($user->type == 'visitor')
                    <a id="membership_dash" href="{{url('/profile/membership/')}}"
                       class="list-group-item"><i style="color: #30aff0;" class="fa fa-star pull-right" aria-hidden="true"></i>Membership</a>
                    @elseif($user->type == 'provider')
                        <a id="gallery_dash" href="{{url('/profile/mygallery/')}}"
                           class="list-group-item"><i style="color: #30aff0;" class="fa fa-picture-o pull-right" aria-hidden="true"></i>Gallery</a>
                @endif
                @if($ismember)
                    <a id="searches_dash" href="{{ url('/profile/searches/') }}" class="list-group-item"><i style="color: #30aff0;" class="fa fa-folder-open pull-right" aria-hidden="true"></i>Searches</a>

                @endif
                {{--@if($ismember && $user->type == 'provider')--}}
                    {{--<a id="reports_dash" href="{{ url('/reports/user/') }}" class="list-group-item">Reports</a>--}}

                {{--@endif--}}
            </div>
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {
        "message": "This website uses cookies to ensure you get the best experience on our website",
        "dismiss": "Got it!",
        "learnMore": "More info",
        "link": "{{url('/cookiePolicy')}}",
        "theme": "dark-bottom"
    };
</script>

<script type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->

{{--Helper js--}}
<script src="{{ url('/') }}/js/helpers.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-82907550-1', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>