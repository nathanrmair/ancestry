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

    <!--external css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
            integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ url('/') }}/css/app.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    {{--Helpers js--}}
    <script src="{{ url('/') }}/js/helpers.js" defer></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <meta name="google-site-verification" content="e4Di22bbkh7N_gVJinYe_J1R27ei5pc2-OWVOPvOudc" />
</head>

<body>

@include('components.top_navbar')

@yield('content')

<footer>
    @include('components.footer')
</footer>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.js"></script>--}}

<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
<script type="text/javascript">
    window.cookieconsent_options = {
        "message": "This website uses cookies to ensure you get the best experience on our website",
        "dismiss": "Got it!",
        "learnMore": "More info",
        "link": "{{ url('/cookiePolicy') }}",
        "theme": "dark-bottom"
    };
</script>

<script type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
<!-- End Cookie Consent plugin -->
<link rel="stylesheet" href="{{ url('/') }}/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ url('/') }}/css/lightbox/lightbox.css">
<link rel="stylesheet" href="{{ url('/') }}/css/ancestry.css">

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    var clientId = "{{\Illuminate\Support\Facades\Auth::check()? \Illuminate\Support\Facades\Auth::user()->user_id : \Illuminate\Support\Facades\Auth::Guest()}}";
    ga('create', 'UA-82907550-1', 'auto');
    ga('send', 'pageview');
    ga('set', 'userId', clientId ); // Set the user ID using signed-in user_id.

</script>



</body>

</html>