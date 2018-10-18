@extends('layouts.mainLayout')

@section('content')


    <body class="login-body" style="padding-top: calc(2% + 50px); height: 100%;">

    <div class="container" style="height: 80%;">

        <div class="row" style="height: 100%;">
            <div class="col-lg-8 col-lg-offset-2 text-center" >
                <div class="limited-message">
                    <h3>Sorry but we have reached the limit of registered users.
                        Unfortunately, there is no room for new users at the moment as we are still in our testing phase.
                        Please try coming later. We are sorry for the inconvenience caused and we thank you for visiting our website. </h3>
                    </div>

                <a href="{{url('/')}}/provider_reg"><button class="btn btn-default">Provider Sign up</button> </a>
            </div>
        </div>

    </div>


    </body>
@endsection
