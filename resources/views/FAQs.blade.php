@extends('layouts.mainLayout')
@section('content')
    @include('flash::message')

    <script src="{{ url('/') }}/js/bootbox.min.js"></script>


    <?php $unanswered = "This question has yet to be answered."?>
    <div class="container" style="padding-top: calc(2% + 50px);">
    <h1> Frequently Asked Questions</h1>
    <br>
    <div>
        <div>
            <?php $i = 0 ?>
        @foreach($questions as $q)
                    <?php $i++ ?>
            <p><a href = "#question-{{$i}}" class="page-scroll" style="color: #30aff0">{{$q->question}}</a></p>
        @endforeach
                <br>
                <?php $i = 0 ?>
        </div>
        @foreach($questions as $pair)
            <?php $i++ ?>
            <div class="faq" id="question-{{$i}}">
                <div><h3 class="question-heading" >Question: </h3>
                    <p class="question">{{$pair->question}}</p></div>
                <div><h3 class="answer-heading">Answer: </h3>
                    @if(isset($pair->answer))
                        <p class="answer">{{$pair->answer}}</p>
                    @else
                        <p class="answer" style="color: #a0a0a0">{{$unanswered}}</p>
                    @endif
                </div>
                @if(isset($edit))
                    <a id="edit-faq-{{$pair->question_id}}"
                       href="{{ url('/') }}/admin/FAQs/edit/{{$pair->question_id}}"><button class="btn btn-primary">Edit</button></a>
                    <form id="delete-faq-form" action="{{ url('/') }}/admin/FAQs/delete/{{$pair->question_id}}"
                          method="GET">
                        <br>
                        <input class=" btn btn-primary btn-lg delete-button" id="delete-faq" name="delete" type="submit"
                               value="Delete">
                    </form>
                @endif

            </div>

        @endforeach

        @if(isset($edit))
            <a href="{{ url('/') }}/admin/FAQs/create"><button class="btn btn-primary" style="margin: 5px;">Create</button></a>

        @endif
    </div>
        </div>

    <script>
        $(document).load(init());

        function init() {

            $("#delete-faq-form").submit(function (e) {
                var currentForm = this;
                e.preventDefault();
                bootbox.confirm("Are you sure you wish to delete this question?", function (result) {
                    if (result) {
                        currentForm.submit();
                    }
                });
            });

        }
    </script>

@endsection