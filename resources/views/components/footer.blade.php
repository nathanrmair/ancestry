<div id="footer">
    <div class="container-fluid footer-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center">
                        <h3 class="section-heading" style="padding-bottom: 30px;">Are you a provider and want to work with us?</h3>
                        <p><a href="{{url('/provider_reg/')}}" style="text-decoration: none;">
                                <button class="btn btn-default" style="border-radius: 5px;">Sign up here</button>
                            </a><br>
                            or<br>
                            Contact us now to find out more!
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 right-hand-side">
                <form action="{{url('/newsletter/signup')}}" method="POST" role="form" onsubmit="buttonDisable('newsletter_btn')">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-12 text-center">
                    <label for="email">Sign up for our newsletter:</label>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <span class="vertical-align-helper"></span>
                    <input type="email" maxlength="254" class="form-control newsletter" name="email" placeholder="Enter your email"/>
                            <button type="submit" id="newsletter_btn" class="btn btn-default">Sign up</button>
                        </div>
                        </div>
                </form>
                <div class="row" style="margin-top: 30px;">
                <div class="col-lg-6 text-center">
                    <i class="fa fa-phone fa-3x sr-contact"></i>
                    <p>123-456-6789</p>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fa fa-envelope-o fa-3x sr-contact"></i>
                    <p><a href="mailto:ancestryscot@gmail.com">support@myancestralscotland.com</a></p>
                </div>
                    </div>
            </div>
        </div>
    </div>

</div>