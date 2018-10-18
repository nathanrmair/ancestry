@extends('layouts.mainLayout')

@section('content')


    <body class="login-body">

    <div class="container" style="padding-top: calc(2% + 50px);">
        <div class="signup-row">

        <form class="signup-form" name="provider-signup-form" style="border: 1px solid black;" id="provider-signup-form"
              action="{{ url('/sendforapproval') }}" method="POST" role="form" onsubmit="buttonDisable('register-submit')">
            {{ csrf_field() }}
            <div class="legend" style="font-size:22px;">Provider Registration</div>

            <div id="provider_reg_desc">
                <p style="color: black;"><span style="color: red">IMPORTANT:</span> Please fill in the fields below with your details and send
                    your application for approval.
                    Once your application is approved instructions will be sent to your email address. Please note that
                    the more fields you fill in the better the chance for approval is.</p>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <div class="control-group">
                    <label class="control-label" for="name">Name</label>
                    <p>Please provide your organisation's name</p>
                    <div class="controls">
                        <input id="name" type="text" maxlength="50" class="form-control input-lg" name="name"
                               value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif

                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="control-group">
                    <label class="control-label" for="email">E-mail</label>
                    <div class="controls">
                        <input id="email" type="email" maxlength="254" class="form-control input-lg" name="email"
                               value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input id="password" type="password" class="form-control input-lg" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <div class="control-group">
                    <label class="control-label" for="password_confirm">Password (Confirm)</label>
                    <div class="controls">
                        <input id="password-confirm" type="password" class="form-control input-lg"
                               name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            <div class="control-group sep">
                <label class="control-label" for="type">Type</label>
                <div class="controls">
                    <select id="type" class="form-control" name="type">
                        <option value="">Type...</option>
                        <option value="Museum">Museum</option>
                        <option value="Heritage centre">Heritage Centre</option>
                        <option value="Archive Centre/Records Office">Archive Centre/Records Office</option>
                        <option value="Family History Society">Family History Society</option>
                        <option value="Library">Library</option>
                        <option value="Other">Other</option>
                    </select>

                    @if ($errors->has('type'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
                </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <div class="control-group  sep">
                <label class="control-label"
                       style="border-top-width:thick; margin-top:10px; margin-bottom:1px; border-top-width:thin;"
                       for="description">Desription</label>
                <p >A general description of your services. </p>
                <div class="controls">
                    <textarea rows="5" cols="40"  maxlength="2000"id="description" name="description" class="form-control"></textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
                </div>


            <div class="control-group sep">
                <label class="control-label" for="street_name">Street Name</label>
                <div class="controls">
                    <input type="text"  maxlength="50" id="street_name" name="street_name" placeholder=""
                           class="form-control input-lg"/>
                </div>
            </div>

            <div class="control-group sep">
                <label class="control-label" for="town">Town</label>
                <div class="controls">
                    <input type="text" id="town" maxlength="50" name="town" placeholder="" class="form-control input-lg"/>
                </div>
            </div>

            <div class="control-group sep">
                <label class="control-label" for="county">County</label>
                <div class="controls">
                    <select id="county" class="form-control" name="county">
                        <option value="">County...</option>
                        <option>Aberdeenshire</option>
                        <option>Angus</option>
                        <option>Argyll and Bute</option>
                        <option>Comhairle nan Eilean Siar</option>
                        <option>Clackmannanshire</option>
                        <option>Dumfries and Galloway</option>
                        <option>Dundee</option>
                        <option>East Ayrshire</option>
                        <option>East Dunbartonshire</option>
                        <option>Edinburgh</option>
                        <option>East Lothian</option>
                        <option>East Renfrewshire</option>
                        <option>Falkirk</option>
                        <option>Fife</option>
                        <option>Glasgow</option>
                        <option>Highland</option>
                        <option>Inverclyde</option>
                        <option>Midlothian</option>
                        <option>Moray</option>
                        <option>North Ayrshire</option>
                        <option>North Lanarkshire</option>
                        <option>Orkney</option>
                        <option>Perth and Kinross</option>
                        <option>Renfrewshire</option>
                        <option>Scottish Borders</option>
                        <option>Shetland Islands</option>
                        <option>South Ayrshire</option>
                        <option>South Lanarkshire</option>
                        <option>Stirling</option>
                        <option>West Dunbartonshire</option>
                        <option>West Lothian</option>
                    </select>
                </div>
            </div>

            <div class="control-group sep">
                <label class="control-label" for="historic_county">Historical County 1890 - 1975</label>
                <div class="controls">
                    <select id="historic_county" class="form-control" name="historic_county">
                    <option value="">Historic County...</option>
                    <option>Aberdeenshire</option>
                    <option>Angus (Forfarshire)</option>
                    <option>Argyll</option>
                    <option>Ayrshire</option>
                    <option>Banffshire</option>
                    <option>Berwickshire</option>
                    <option>Bute</option>
                    <option>Caithness</option>
                    <option>Clackmannanshire</option>
                    <option>Dunbartonshire</option>
                    <option>Dumfriesshire</option>
                    <option>East Lothian</option>
                    <option>Fife</option>
                    <option>Inverness-shire</option>
                    <option>Kincardineshire</option>
                    <option>Kinross-shire</option>
                    <option>Kirkcudbrightshire</option>
                    <option>Lanarkshire</option>
                    <option>Midlothian</option>
                    <option>Moray</option>
                    <option>Nairnshire</option>
                    <option>Orkney</option>
                    <option>Peebleshire</option>
                    <option>Perthshire</option>
                    <option>Renfrewshire</option>
                    <option>Ross and Cromarty</option>
                    <option>Roxburghshire</option>
                    <option>Selkirkshire</option>
                    <option>Shetland</option>
                    <option>Stirlingshire</option>
                    <option>Sutherland</option>
                    <option>West Lothian</option>
                    <option>Wigtonshire</option>
                    </select>
                </div>
            </div>


            <div class="control-group sep">
                <label class="control-label" for="region">Region</label>
                <div class="controls">
                    <select id="region" class="form-control" name="region">
                        <option value="">Region...</option>
                        <option>Argyll</option>
                        <option>Ayrshire</option>
                        <option>Borders</option>
                        <option>Central Scotland</option>
                        <option>Clyde Valley</option>
                        <option>Dumfries and Galloway</option>
                        <option>Fife</option>
                        <option>Grampian</option>
                        <option>Hebrides</option>
                        <option>Highlands</option>
                        <option>Lothian</option>
                        <option>Orkney Islands</option>
                        <option>Shetland Islands</option>
                        <option>Tayside</option>
                    </select>
                </div>
            </div>

            <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
            <div class="control-group sep">
                <label class="control-label" for="postcode">Post code</label>
                <div class="controls">
                    <input type="text" id="postcode" maxlength="50" name="postcode" placeholder="" class="form-control input-lg"/>
                    @if ($errors->has('postcode'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('postcode') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>
                </div>


            <div class="control-group sep">
                <!-- Button -->
                <div class="controls">
                    <button id="register-submit" class="btn btn-primary btn-lg btn-block">Send for approval</button>
                </div>
            </div>

        </form>

    </div>
    </div>
    </body>

@endsection
