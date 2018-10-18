@extends('layouts.dashboard')




@section('content')


    <!-- for datepicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="{{ url('/') }}/js/provider_gallery.js"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>
    <script src="{{ url('/') }}/js/highlight.js"></script>
    <body>
    <script type="application/javascript">
        highlight("gallery_dash");
    </script>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>Upload images to gallery</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-fluid" id="spinner" style="text-align: center; margin: 20px;">
                        <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                    </div>
                    @forelse($images as $image)
                        <div class="provider-image-thumbnail" style="visibility: hidden; display: none;"
                             id="image-{{$image->providers_gallery_images_id}}"><span
                                    style="height: 100%; vertical-align: middle; display: inline-block;"></span><img
                                    src="{{\App\Http\Controllers\ProvidersImagesController::getImageSrc($image, Auth::user()->user_id)}}"
                                    alt=\"\""/>
                            <div class="delete-bagde"><a onclick="prompt({{$image}})"><img
                                            src="{{url('/').'/img/delete.png'}}"></a></div>
                        </div>

                    @empty
                        <h3>You have not uploaded any images yet</h3>
                    @endforelse
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form name="add-images-form" id="add-images-form"
                          action="{{url('/profile/mygallery/add')}}" method="POST" enctype="multipart/form-data"
                          role="form">
                        {{ csrf_field() }}
                        <div class="attachments form-group{{ $errors->has('file') ? ' has-error' : '' }}">

                            <span class="attach-document-label">Attach an image: </span>
                            <label class="btn btn-default btn-file" id="choose-file-input">
                                Choose images <input type="file" id="fileinput" name="fileinput[]"
                                                     accept="image/*"
                                                     style="display: none;" multiple/>
                            </label>
                            <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>

                            <span class="bottom-message-buttons" style="margin: 0;" id="file-chosen"></span>
                            <button class="btn btn-primary btn-lg btn-block" id="upload-button"
                                    name="submit" type="submit">Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function prompt(file) {
            bootbox.confirm({
                message: 'Are you sure you want to delete this picture?',
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            url: base_url() + "profile/mygallery/delete/" + file.providers_gallery_images_id,
                            error: function (error) {
                                console.log(error);
                            },
                            dataType: 'json',
                            success: function () {
                                var toRemove = '#image-' + file.providers_gallery_images_id;
                                console.log(toRemove);
                                $(toRemove).animate({width: '0px', height: '0px', borderWidth: '0px', margin: '0px'});
                            },
                            type: 'GET'
                        });
                    }
                },

            });
        }

    </script>

    </body>

    <script>
        window.onload = function () {
            document.getElementById('spinner').style.display = 'none';

            var images = document.getElementsByClassName('provider-image-thumbnail');
            for (i = 0; i < images.length; i++) {
                images[i].style.display = 'inline-block';
                images[i].style.visibility = 'visible';
            }
        }
    </script>
@endsection