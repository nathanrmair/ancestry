@extends('layouts.adminLayout')
@section('content')
    <script src="{{ url('/') }}/js/form-mandatory-fields.js"></script>
    <script src="{{ url('/') }}/js/bootbox.min.js"></script>

    <h1>Edit Frequently Asked Questions</h1>
    <div>

        <div class="faq">
            @include('flash::message')
            <form id='edit' action="{{ url('/') }}/admin/FAQs/edit" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(isset($pair))
                    <input type="hidden" name="question_id"
                           value="{{$pair->question_id}}">
                @endif
                <div><h2 class="question-heading">Question:</h2>
                    <textarea maxlength="500" rows="5" cols="40" id="question" name="question"
                              class="form-control question">@if(isset($pair)){{$pair->question}}@endif</textarea>
                </div>
                <div><h3 class="answer-heading">Answer:</h3>
                    <textarea maxlength="2000" rows="5" cols="40" id="answer" name="answer"
                              class="form-control answer">@if(isset($pair)){{$pair->answer}}@endif</textarea>
                </div>
                <br>
                <input class=" btn btn-primary btn-lg " type="submit" name="submit" value="Submit">
            </form>
            @if(isset($pair)&&isset($pair->question))
                <form id="delete-faq-form" action="{{ url('/') }}/admin/FAQs/delete/{{$pair->question_id}}" mathod="GET">
                    <br>
                    <input class=" btn btn-primary btn-lg delete-button" id="delete-faq" name="delete" type="submit" value="Delete">
                </form>
            @endif
        </div>


    </div>
    <script type="text/javascript">

        $(document).load(init());

        function init() {

            var manFields = <?php echo json_encode($manFields)?>;
            setMandatoryFieldListeners(manFields);

            $("#edit").submit(function (e) {
                if (!allValid(manFields)) {
                    bootbox.alert("FAQ must contain a question");
                    e.preventDefault();
                    highlightInvalidFields(manFields);
                }
            });

            $("#delete-faq-form").submit(function(e) {
                var currentForm = this;
                e.preventDefault();
                bootbox.confirm("Are you sure you wish to delete this question?", function(result) {
                    if (result) {
                        currentForm.submit();
                    }
                });
            });

        }
    </script>
@endsection