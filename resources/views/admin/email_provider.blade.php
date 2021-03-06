@extends('layouts.adminLayout')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
            integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
            crossorigin="anonymous"></script>
    <script src='{{ url('js/tinymce/js/tinymce') }}/jquery.tinymce.min.js'></script>
    <script src='{{ url('js/tinymce/js/tinymce') }}/tinymce.min.js'></script>

    <script>
        tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
            plugins:["link image lists charmap print preview hr anchor pagebreak"],
            plugin: 'a_tinymce_plugin',
            a_plugin_option: true,
            a_configuration_option: 400,
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | mybutton',
            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
            skin: 'skin',
            setup: function (editor) {
                editor.addButton('mybutton', {
                    text: 'Add Footer',
                    icon: false,
                    onclick: function () {
                        editor.insertContent('&nbsp;<p>Kind Regards, <br> The MyAncestralScotlandTeam</p> ' +
                                '<p>Website: <a href="http://www.myancestralscotland.com/">www.myancestralscotland.com</a></p> ' +
                                '<p>Email: <a href="mailto:ancestryscot@gmail.com">ancestryscot@gmail.com</a></p> &nbsp;');
                    }
                });
            }
        });
    </script>

    <div class="container-fluid container-position">
        <form method="post" action="{{url('/admin/emailProvider/send')}}">
            {{ csrf_field() }}
            <input type="text" class="form-control input-lg" name="subject" placeholder="Enter a subject..."/>
            <br>
            <input type="hidden" value="{{ $user_id }}" name="user_id" />
            <textarea id="mytextarea" name="message" placeholder="Type your message here!"></textarea>

            <input type="submit" class="btn btn-info btn-lg" value="Submit" style="margin-top: 10px;"/>
        </form>
    </div>

    @endsection