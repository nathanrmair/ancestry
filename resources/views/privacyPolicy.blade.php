@extends('layouts.mainLayout')

@section('content')

    <div class="container-fluid" style="padding-top: calc(2% + 50px); min-height: 80%;">
        <div class="row">
            <div class="col-lg-offset-2 col-md-8">
                <h1 style="font-weight: 700; color: #30aff0;">Privacy Policy</h1>


                <div style="font-size: large">
                    <h3>What information do we collect?</h3>

                    <p>We collect personal information from you provided at the point of registration for myAncestralScotland
                        but it is important to note that you can provide as much or as little personal
                        details as you are comfortable with.</p>

                    <p>We collect information you provided on your ancestors</p>

                    <p>We also collect analytical data from the usage of the website.</p>

                    <h3>How we use your information?</h3>

                    <p>We use your personal information to contact you, to identify you as a customer and to personalise your experience.</p>

                    <p>We use cookies to improve the functionality of the website, full details on how we use cookies are contained in our <a href="{{url('/').'/cookiesPolicy'}}">cookies policy</a>.</p>

                    <p>We use the analytical data gathered from the usage of the site to improve the browsing experience for all users.</p>

                    <h3>How our third party information providers use your information?</h3>

                    <p>We provide your information to our approved information providers only when you contact them.
                        They will not share this information with any other third parties and the information will
                        only be used to track down your family tree and to contact you or for other academic purposes.</p>

                    <h3>How we protect your data?</h3>

                    <p>All of the data we store on you is held securely and is fully encrypted and we take every
                        reasonable precaution to ensure your data is protected at all times.</p>

                    <h3>Third Party Links</h3>

                    <p>Our website may contain links to the providers' websites.
                        We are not responsible for the content on these sites or liable for this content.
                        We still take every effort to ensure that the content of these sites match the ethos of MyAncestralScotland.
                        We welcome feedback if you feel one of our partner sites has content which is out of line with the content you were expecting.</p>

                   <h3>Do we disclose details to any other 3rd parties?</h3>

                    <p>We do not trade, sell or otherwise transfer your information to any other 3rd party companies other than our approved providers for the purposes details above.</p>
                </div>
            </div>
        </div>
    </div>

@endsection