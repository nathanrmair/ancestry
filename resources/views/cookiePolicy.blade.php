@extends('layouts.mainLayout')



@section('content')

    <!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
    <script type="text/javascript">
        window.cookieconsent_options = {
            "message": "Once you have read the following details and are happy please dismiss this message as we will keep advising you of this until you do.",
            "dismiss": "Got it!",
            "theme": "dark-top"
        };
    </script>

    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
    <!-- End Cookie Consent plugin -->


    <div class="container-fluid" style="padding-top: calc(2% + 50px); min-height: 80%;">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h1>MyAncestralScotland Cookies Policy</h1>

                <hr>

            </div>

        </div>

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h2>Cookies</h2>

                <p>To make this site work properly, we sometimes place small data files called cookies on your device.
                    Most big websites do this too.</p>

            </div>

        </div>

        <br>

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h2>What are cookies</h2>

                <p>A cookie is a small text file that a website saves on your computer or mobile device when you visit
                    the site.
                    It enables the website to remember your actions and preferences (such as login, language, font size
                    and other display preferences)
                    over a period of time, so you don’t have to keep re-entering them whenever you come back to the site
                    or browse from one page to another. </p>

            </div>

        </div>


        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h2>How we use cookies?</h2>

                <p>We use cookies to improve and speed up the user experience remembering details such as auto complete
                    logins. Enabling these cookies is not strictly necessary for the website to work but it will provide
                    you with a better browsing experience. You can delete or block these cookies, but if you do that
                    some
                    features of this site may not work as intended. If any of the cookies used require informed consent
                    you will be asked this specifically and will have the ability to reject their use.</p>

            </div>

        </div>

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h2>How to control cookies?</h2>

                <p>You can control and/or delete cookies as you wish – for details, see <a
                            href="http://www.aboutcookies.org/"> aboutcookies.org </a> You can delete
                    all cookies that are already on your computer and you can set most browsers to prevent them from
                    being
                    placed. If you do this, however, you may have to manually adjust some preferences every time you
                    visit
                    a site and some services and functionalities may not work.</p>
                <a href="{{url('/') }}">
                    <button type="button" class="btn btn-primary">Back to Home</button>
                </a>
                <br>
                <br>
            </div>

        </div>


    </div>

@endsection