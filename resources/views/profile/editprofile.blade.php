@extends('layouts.dashboard')


@section('content')
    <script src="{{ url('/') }}/js/form-mandatory-fields.js"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/highlight.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>




    <!-- for datepicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <link rel="{{ url('/') }}/css/datepicker.css"/>
    <noscript><?php $selectWarning = "<strong>Warning!</strong> With Javascript disabled this field will be cleared if unset" ?></noscript>

    <body class="profile-img-body" id="contentM">

    <script type="application/javascript">
        highlight("profile_dash");
    </script>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>Edit Profile</b></div>
            <div class="clearfix"></div>
        </div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="container-fluid">
            <div class="col-md-6 col-md-offset-3 infosection">
                <div class="pbody">

                    <div class="col-md-10 col-md-offset-1 text-center">
                        @if($data->avatar_id == 0)
                            @if($user->type=='visitor')
                                <img src="{{ url('/') }}/img/avatar/default_visitor.png"
                                     class="user-avatar avatar-edit blue-shadowed">
                            @else
                                <img src="{{ url('/') }}/img/avatar/default_provider.png"
                                     class="user-avatar  avatar-edit blue-shadowed">
                            @endif
                        @else
                            <img src="{{json_decode($source)}}" class="user-avatar  avatar-edit blue-shadowed">
                        @endif
                    </div>


                    <div class="col-md-10 col-md-offset-1 ">
                        <noscript>
                            <div class="alert alert-warning"><strong>Warning!</strong> Javascript is currently disabled,
                                please enable it for a superior
                                user experience
                            </div>
                        </noscript>
                        <form class="edit-form" name="provider-edit-form" id="provider-edit-form"
                              action="{{url('/profile/submit')}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <noscript><input type="hidden" name="noscript" value="true"></noscript>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="email">Email*</label>
                                <div class="controls">
                                    <input type="email" id="email" maxlength="254" name="email"
                                           placeholder="{{$user->email}}"
                                           autocomplete="off"

                                           class="form-control input-lg" oninput="passwordBoxVisibility()"/>
                                </div>
                                <div id="paswordContainer">
                                    <p id="email-help" class="help-block">Login password required to change email</p>
                                    <label class="control-label" for="email">Password*</label>
                                    <div class="controls">
                                        <input type="password" id="password" name="password"
                                               class="form-control input-lg" autofill="off"/>
                                    </div>
                                </div>
                            </div>

                            @if($user->type == 'provider')
                                <div class="control-group">
                                    <label class="control-label" for="name">Name*</label>
                                    <div class="controls">
                                        <input type="text" maxlength="50" id="name" name="name"
                                               @if(isset($data->name)) value="{{$data->name}}"
                                               placeholder="{{$data->name}}"
                                               @endif class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="type">Type*</label>
                                    <div class="controls select-container">
                                        <select class="form-control" name="type" id="type">
                                            <option value=" ">Type...</option>
                                            <option>Museum</option>
                                            <option>Heritage Centre</option>
                                            <option>Archive Centre/Records Office</option>
                                            <option>Family History Society</option>
                                            <option>Library</option>
                                            <option>Other</option>
                                        </select>
                                        <p class="help-block"></p>

                                        <noscript>@if(isset($data->gender))
                                                <div class="alert alert-info">Activate Javascript to see this saved
                                                    field
                                                </div>@endif</noscript>

                                    </div>
                                </div>

                                <div class="control-group des">
                                    <label class="control-label"
                                           style="border-top-width:thick; margin-top:10px; margin-bottom:1px; border-top-width:thin;">Desription</label>
                                    <p class="form-helpers">A general description of your services. Will be displayed on
                                        your profile
                                        page. </p>
                                    <div class="controls">
                                        <textarea maxlength="2000" rows="5" cols="40" id="description"
                                                  name="description"
                                                  class="form-control">@if(isset($data->description)){{$data->description}}@endif</textarea>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group des">
                                    <label class="control-label"
                                           style="border-top-width:thick; margin-top:10px; margin-bottom:1px; border-top-width:thin;"
                                           for="keywords">Keywords</label>
                                    <p class="form-helpers">These words will help users navigate to your profile. You
                                        can list specific clans,
                                        areas, families, events or any other words that you are associated with. <span
                                                style="color:red">Please separate words with comas. Spaces will be omitted.</span>
                                    </p>
                                    <div class="controls">
                                        <textarea maxlength="2000" rows="5" cols="40" id="keywords" name="keywords"
                                                  placeholder="Keywords separated by comas.."
                                                  class="form-control">@if(isset($data->keywords)){{$data->keywords}}@endif</textarea>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="street_name">Street Name*</label>
                                    <div class="controls">
                                        <input type="text" maxlength="50" id="street_name" name="street_name"
                                               @if(isset($data->street_name))value="{{$data->street_name}}"
                                               placeholder="{{$data->street_name}}"
                                               @endif class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="town">Town*</label>
                                    <div class="controls">
                                        <input type="text" maxlength="50" id="town" name="town"
                                               @if(isset($data->town)) value="{{$data->town}}"
                                               placeholder="{{$data->town}}" @endif
                                               class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="county">County*</label>
                                    <div class="controls select-container">
                                        <select class="form-control" name="county" id="county">
                                            <option value=" ">County...</option>
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
                                        <p class="help-block"></p>
                                        <noscript>
                                            <div class="alert alert-info">Activate Javascript to see saved county</div>
                                        </noscript>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="historic_county">Historical County 1890 -
                                        1975</label>
                                    <div class="controls select-container">
                                        <select class="form-control" name="historic_county" id="historic_county">
                                            <option value=" ">Historic County...</option>
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
                                        <p class="help-block"></p>
                                        <noscript>
                                            <div class="alert alert-warning"><?php echo($selectWarning)?></div>
                                        </noscript>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="region">Region</label>
                                    <div class="controls select-container">
                                        <select class="form-control" name="region" id="region">
                                            <option value=" ">Region...</option>
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
                                        <p class="help-block"></p>
                                        <noscript>
                                            <div class="alert alert-warning"><?php echo($selectWarning)?></div>
                                        </noscript>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="postcode">Post code*</label>
                                    <div class="controls">
                                        <input type="text" maxlength="10" id="postcode" name="postcode"
                                               @if(isset($data->postcode)) value="{{$data->postcode}}"
                                               placeholder="{{$data->postcode}}" @endif
                                               class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <label class="control-label">Add Extra information to your profile:</label>

                                <div class="control-group">
                                    <label class="control-label" for="hours">Opening Hours</label>
                                    <div class="controls">
                                        <textarea maxlength="1000" rows="2" cols="40" id="hours" name="open_hour"
                                                  class="form-control">@if(isset($data->open_hour)){{$data->open_hour}}@endif</textarea>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="closed">Days Closed</label>
                                    <div class="controls">
                                        <textarea maxlength="1000" rows="2" cols="40" id="closed" name="close_hour"
                                                  class="form-control">@if(isset($data->close_hour)){{$data->close_hour}}@endif</textarea>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="prices">Prices</label>
                                    <div class="controls">
                                        <textarea maxlength="1000" rows="3" cols="40" id="prices" name="prices"
                                                  class="form-control">@if(isset($data->prices)){{$data->prices}}@endif</textarea>
                                        <p class="help-block"></p>
                                    </div>
                                </div>


                                <!--Visitor form-->
                            @else
                                <div class="control-group">
                                    <label class="control-label" for="name">First name</label>
                                    <div class="controls">
                                        <input type="text" maxlength="50" id="name" name="forename"
                                               value="{{$data->forename}}"
                                               class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="surname">Surname</label>
                                    <div class="controls">
                                        <input type="text" maxlength="50" id="surname" name="surname"
                                               value="{{$data->surname}}"
                                               class="form-control input-lg"/>
                                        <p class="help-block"></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="dob">Date of Birth (optional)</label>
                                    <div class="controls">
                                        <input data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                               value="{{$data->dob}}" name="dob" id="dob"
                                               readonly="readonly"
                                               placeholder="Click to choose.."
                                               class="datepicker form-control input-lg">
                                        <p class="help-block"></p>
                                        <noscript>
                                            <p>Format: dd-mm-yyyy</p>
                                        </noscript>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="gender">Gender (optional)</label>
                                    <div class="controls">
                                        <label><input type="radio" name="sex" id="male" value="male"/> Male</label>
                                        <br/>
                                        <label><input type="radio" name="sex" id="female" value="female"/>
                                            Female</label>
                                        <br/>
                                        <p class="help-block"></p>
                                        <noscript>@if(isset($data->gender))
                                                <div class="alert alert-info ">Activate Javascript to see saved gender
                                                </div>@endif</noscript>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="origin">Country of Residence</label>
                                    <div class="controls select-container">
                                        <select class="form-control" name="country" id="country">
                                            <option value=" ">Country...</option>
                                            <option value="Afganistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="American Samoa">American Samoa</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bermuda">Bermuda</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bonaire">Bonaire</option>
                                            <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                            <option value="Brunei">Brunei</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Canary Islands">Canary Islands</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <option value="Cayman Islands">Cayman Islands</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Channel Islands">Channel Islands</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Christmas Island">Christmas Island</option>
                                            <option value="Cocos Island">Cocos Island</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <option value="Cook Islands">Cook Islands</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cote DIvoire">Cote D'Ivoire</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Curaco">Curacao</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="East Timor">East Timor</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Falkland Islands">Falkland Islands</option>
                                            <option value="Faroe Islands">Faroe Islands</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="French Guiana">French Guiana</option>
                                            <option value="French Polynesia">French Polynesia</option>
                                            <option value="French Southern Ter">French Southern Ter</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Gibraltar">Gibraltar</option>
                                            <option value="Great Britain">Great Britain</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Greenland">Greenland</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guadeloupe">Guadeloupe</option>
                                            <option value="Guam">Guam</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Hawaii">Hawaii</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hong Kong">Hong Kong</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Isle of Man">Isle of Man</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Korea North">Korea North</option>
                                            <option value="Korea Sout">Korea South</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Macau">Macau</option>
                                            <option value="Macedonia">Macedonia</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Martinique">Martinique</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mayotte">Mayotte</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Midway Islands">Midway Islands</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Nambia">Nambia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherland Antilles">Netherland Antilles</option>
                                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                            <option value="Nevis">Nevis</option>
                                            <option value="New Caledonia">New Caledonia</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Niue">Niue</option>
                                            <option value="Norfolk Island">Norfolk Island</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau Island">Palau Island</option>
                                            <option value="Palestine">Palestine</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Phillipines">Philippines</option>
                                            <option value="Pitcairn Island">Pitcairn Island</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                                            <option value="Republic of Serbia">Republic of Serbia</option>
                                            <option value="Reunion">Reunion</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="St Barthelemy">St Barthelemy</option>
                                            <option value="St Eustatius">St Eustatius</option>
                                            <option value="St Helena">St Helena</option>
                                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                            <option value="St Lucia">St Lucia</option>
                                            <option value="St Maarten">St Maarten</option>
                                            <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                            <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines
                                            </option>
                                            <option value="Saipan">Saipan</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="Samoa American">Samoa American</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia">Serbia</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Tahiti">Tahiti</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tokelau">Tokelau</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Erimates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States of America">United States of America</option>
                                            <option value="Uraguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vatican City State">Vatican City State</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                            <option value="Wake Island">Wake Island</option>
                                            <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zaire">Zaire</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                        <p class="help-block"></p>
                                        <noscript>
                                            <div class="alert alert-warning"><?php echo($selectWarning)?></div>
                                        </noscript>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="description">Description (optional)</label>
                                    <div class="controls">
                                        <textarea maxlength="2000" rows="5" cols="40" id="description"
                                                  name="description"
                                                  class="form-control">{{$data->description}}</textarea>
                                        <p class="help-block">Add a description of yourself and what you are looking for
                                            to display on your profile</p>
                                    </div>
                                </div>

                        @endif

                        <!-- Picture update -->

                            <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                                <label class="control-label" for="profilepic">Change your profile picture</label>
                                <div class="controls">
                                    <input type="file" name="avatar" id="avatar" accept="image/*">
                                    <p class="help-block">Browse to add a new profile picture then save your choice
                                        below</p>
                                </div>
                                <span class="help-block">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>

                            </div>


                            <div class="control-group">
                                <!-- Button -->
                                <div class="controls">
                                    <button id="btn-edit" name="submit" class=" btn btn-primary btn-lg btn-block"
                                            type="submit">Save
                                        changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var max_file_size = 3145728; // 3 MB (this size is in bytes)
        $(document).load(init());
        function init() {
            var manFields = <?php echo json_encode($manFields)?>;
            setDefaults();
            setMandatoryFieldListeners(manFields);
            $("form").submit(function (e) {
                var ok = true;
                if (!allValid(manFields)) {
                    bootbox.alert("Please fill in the required fields");
                    e.preventDefault();
                    highlightInvalidFields(manFields);
                    ok = false;
                } else {
                    var files = document.getElementById('avatar').files;
                    for (var file = 0; file < files.length; file++) {
                        if (files[file] && files[file].size < max_file_size) {
                        } else {
                            //Prevent default and display error
                            bootbox.alert('Your profile avatar should not exceed 3MB! Please try another image.');
                            e.preventDefault();
                            ok = false;
                        }
                    }
                }
                if (ok) {
                    buttonDisable('btn-edit');
                }

            });
            $("#dob").datepicker({dateFormat: 'dd-mm-yy', yearRange: '-100:+0', changeYear: true, changeMonth: true});
        }
        function setDefaults() {
            document.getElementById("paswordContainer").style = "display:none";
                    @if ($user->type == 'provider')
            var typeElement = document.getElementById("type");
            var type;
            @if (isset ($data->type))
                    type = "<?php echo $data->type ?>";
            @endif
            if (type) {
                typeElement.value = type;
            }
            else {
                typeElement.value = " ";
            }
            typeElement = document.getElementById("county");
            var county;
            @if (isset ($data->county))
                    county = "<?php echo $data->county ?>";
            @endif
            if (county) {
                typeElement.value = county;
            }
            else {
                typeElement.value = " ";
            }
            typeElement = document.getElementById("historic_county");
            var historic_county;
            @if (isset ($data->historic_county))
                    historic_county = "<?php echo $data->historic_county ?>";
            @endif
            if (historic_county) {
                typeElement.value = historic_county;
            }
            else {
                typeElement.value = " ";
            }
            typeElement = document.getElementById("region");
            var region;
            @if (isset ($data->region))
                    region = "<?php echo $data->region ?>";
            @endif
            if (region) {
                typeElement.value = region;
            }
            else {
                typeElement.value = " ";
            }
                    @else
            var typeElement = document.getElementById("country");
            var origin;
            @if (isset ($data->origin))
                    origin = "<?php echo $data->origin ?>";
            @endif;
            if (origin) {
                typeElement.value = origin;
            }
            else {
                typeElement.value = " ";
            }
            var gender;
            @if (isset ($data->gender))
                    gender = "<?php echo $data->gender ?>";
            @endif
            if (gender) {
                document.getElementById(gender).checked = true;
            }
            @endif
        }
        function passwordBoxVisibility() {
            var box = document.getElementById('paswordContainer');
            var email = document.getElementById('email').value;
            var password = document.getElementById('password')
            if (email !== "" && email !== document.getElementById('email').placeholder) {
                box.style.display = "inline";
            }
            else {
                box.style.display = "none";
            }
        }

    </script>
    </body>

@endsection('content')