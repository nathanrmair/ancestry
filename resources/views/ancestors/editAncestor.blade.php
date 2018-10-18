@extends('layouts.dashboard')

@section('content')
    <?php $data = new \App\Ancestor ?>
    @if(isset($ancestorId))
        <?php $data = App\Http\Controllers\AncestorController::getAncestor($ancestorId);?>
    @endif



    <!-- for datepicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <body class="profile-img-body" id="contentM" onload="init()">
    <div class="panel panel-default">
        <div class="panel-heading">
            @if(isset($ancestorId))
                <div class="pull-left"><b>Edit Ancestor Profile</b></div>
            @else
                <div class="pull-left"><b>Create Ancestor Profile</b></div>
            @endif
            <div class="clearfix"></div>
        </div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="container-fluid">

            <div class="col-md-6 col-md-offset-3">
                <div class="pbody">

                    <form class="edit-form" name="ancestor-edit-form" id="ancestor-edit-form"
                          action="{{url('/ancestor/edit')}}" method="POST" enctype="multipart/form-data" role="form">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if(isset($ancestorId))
                            <input type="hidden" name="ancestor_id" value="{{$ancestorId}}">
                        @endif
                        <br>

                        <!--Forename-->
                        <div class="control-group">
                            <label class="control-label" for="forename">Forename*</label>
                            <div class="controls">
                                <input type="text" id="forename" maxlength="50" name="forename"
                                       placeholder="{{$data->forename}}"
                                       class="form-control input-lg"/>
                            </div>
                        </div>

                        <!--Surname-->
                        <div class="control-group">
                            <label class="control-label" for="surname">Surname*</label>
                            <div class="controls">
                                <input type="text" id="surname" maxlength="50" name="surname"
                                       placeholder="{{$data->surname}}"
                                       class="form-control input-lg"/>
                            </div>
                        </div>

                        <!--Date of Birth-->
                        <div class="control-group">
                            <label class="control-label" for="dob">Date of Birth</label>
                            <div class="controls">
                                <input type="text" id="dob" name="dob"
                                       value="{{$data->dob}}"
                                       class="form-control input-lg"/>
                            </div>
                            <noscript>
                                <p>Format: dd-mm-yyyy</p>
                            </noscript>
                        </div>

                        <!--Date of Death-->
                        <div class="control-group">
                            <label class="control-label" for="dod">Date of Death</label>
                            <div class="controls">
                                <input type="text" id="dod" name="dod"
                                       value="{{$data->dod}}"
                                       class="form-control input-lg"/>
                            </div>
                            <noscript>
                                <p>Format: dd-mm-yyyy</p>
                            </noscript>
                        </div>

                        <!--Gender-->
                        <div class="control-group">
                            <label class="control-label" for="gender">Gender</label>
                            <div class="controls">
                                <input type="radio" name="sex" id="male" value="male"/> Male
                                <br/>
                                <input type="radio" name="sex" id="female" value="female"/> Female
                                <br/>
                                <p class="help-block"></p>
                                @if(isset($data->gender))
                                    <noscript>@if(isset($data->gender))<p class="alert alert-info">Activate Javascript
                                            to see
                                            this saved field</p>@endif</noscript>
                                @endif
                            </div>
                        </div>

                        <!--Description-->
                        <div class="control-group">
                            <label class="control-label" for="description">Description</label>
                            <div class="controls">
                                <textarea id="description" maxlength="2000" name="description"
                                       class="form-control input-lg">{{$data->description}}</textarea>
                            </div>
                        </div>

                        <!--Clan-->
                        <div class="control-group">
                            <label class="control-label" for="clan">Clan</label>
                            <div class="controls">
                                <input type="text" id="clan" maxlength="50" name="clan" value="{{$data->clan}}"
                                       class="form-control input-lg"/>
                            </div>
                        </div>

                        <!--Place of Birth-->
                        <div class="place_of_birth">
                            <label class="control-label" for="clan">Place of Birth</label>
                            <div class="controls">
                                <input type="text" maxlength="150" id="place_of_birth" name="place_of_birth"
                                       value="{{$data->place_of_birth}}"
                                       class="form-control input-lg"/>
                            </div>
                        </div>

                        <!--Place of Death-->
                        <div class="place_of_death">
                            <label class="control-label" for="clan">Place of Death</label>
                            <div class="controls">
                                <input type="text" id="place_of_death" maxlength="150" name="place_of_death"
                                       value="{{$data->place_of_death}}"
                                       class="form-control input-lg"/>
                            </div>
                        </div>
                        <br>

                        <div class="attachments">
                            <span class="attach-document-label">Attach a document: </span>
                            <label class="btn btn-default btn-file" id="choose-file-input">
                                Choose file <input type="file" id="fileinput" name="fileinput[]"
                                                   accept="image/*, application/pdf, application/vnd.ms-powerpoint,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.slideshow,
                                                                   application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain, .docx, .doc"
                                                   style="display: none;" multiple/>
                            </label><br>
                            <span class="bottom-message-buttons" style="margin: 0;" id="file-chosen"></span>
                        </div>
                        <br><br>
                        <!-- Submit Button -->
                        <div class="control-group">
                            <div class="controls">
                                <button class="btn btn-primary btn-lg btn-block" id="save-btn-ancestors" name="submit"
                                        type="submit"
                                        style="margin-bottom:2%">Save Changes
                                </button>
                            </div>
                        </div>

                    </form>
                    @if(isset($ancestorId))
                        <form class="edit-form" name="ancestor-delete-form" id="ancestor-delete-form"
                              action="{{url('/ancestor/delete')}}" method="POST">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="ancestor_id" value="{{$ancestorId}}">

                            <button class="btn btn-primary btn-lg btn-block delete-button" id="delete-anc"
                                    name="submit" type="submit"
                            >Delete Ancestor
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </body>


    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/edit_ancestor.js"></script>
    <script src="{{ url('/') }}/js/form-mandatory-fields.js"></script>

    <script>

        var manFields = <?php echo(json_encode($manFields))?>;

        function init() {
            highlight();
            setMandatoryFieldListeners(manFields);

            $("#ancestor-edit-form").submit(function (e) {

                if (!allValid(manFields)) {
                    bootbox.alert("Please fill out the mandatory fields.");
                    e.preventDefault();
                    highlightInvalidFields(manFields);
                }
                else {

                    buttonDisable('save-btn-ancestors');
                    buttonDisable('delete-anc');

                }

            });

            setDefaults();

        }


        function setDefaults() {

                    @if(isset($ancestorId))
            var gender = "<?php echo $data->gender ?>";
            var element = document.getElementById("gender");
            if (gender) {
                document.getElementById(gender).checked = true;
            }
            @endif

        }

        function highlight() {

            holder = document.getElementById('ancestors_dash');
            holder.className = holder.className + ' blueholder';
            holder.style.paddingLeft = '15%';
        }
    </script>
@endsection
