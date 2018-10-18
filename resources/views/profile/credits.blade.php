@extends('layouts.dashboard')


@section('content')
    <script src="{{ url('/') }}/js/creditsFunctions.js"></script>

    <body onload="init({{$credits->credits}})">
    <script type="application/javascript">
        highlight();
    </script>
    @include('flash::message')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left"><b>My Credits</b></div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        {{--text--}}

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-lg-offset-1 col-md-offset-1">
                    <div class="container-fluid" style="text-align: center; margin: 15px;">
                        @if($credits->credits == 0)
                            <span style="color: #a94442"><b>You have no credits!</b></span><br>
                        @endif
                        Credits:
                        <div id="credit_holder" class="credits_holder" style="display:inline-block;">
                            <div id="credit">{{$credits->credits}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    @if($user->type == "visitor")

                        <div class="row" style="margin: 10px; margin-bottom: 0;">
                            <div style="margin: 10px; margin-bottom: 18px; font-weight: 700;">
                                You can choose between our promotional packages or use the box below to buy as many
                                credits as you want! Then click "BUY CREDITS" to advance.
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <a id="btn-package-30" class="thumbnail" onclick="buy(30)">
                                    <span class="package-credits">30</span><br>credits<br>for <b>£25</b>
                                </a>
                                <div class="info-box">£5 off</div>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <div id="package-col">
                                    <a id="btn-package-50" class="thumbnail" onclick="buy(50)">
                                        <div id="popular-badge">Top</div>
                                        <span class="package-credits">50</span><br>credits<br> for <b>£40</b>
                                    </a>
                                    <div class="info-box">£10 off</div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <a id="btn-package-80" class="thumbnail" onclick="buy(80)">
                                    <span class="package-credits">80</span><br>credits<br>for <b>£60</b>
                                </a>
                                <div class="info-box">£20 off</div>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <a id="btn-package-100" class="thumbnail" onclick="buy(100)">
                                    <span class="package-credits">100</span><br>credits<br>for <b>£75</b>
                                </a>
                                <div class="info-box">£25 off</div>
                            </div>
                        </div>

                        <div class="container-fluid">
                        <form name="buycredits" id="buycredits" action="{{ url('/profile/buycredits') }}" method="post"
                              class="signup-form full-width-form" role="form" onsubmit="buttonDisableBuy()">
                            {{ csrf_field() }}
                            <div class="container-fluid">
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                    <div class="input-group credits_input">
                                        <label for="quantity" class="control-label">Amount of credits:</label>
                                        <input id="quantity" type="number" class="form-control" placeholder="Credits"
                                               oninput="getPrice()" autofocus name="quantity">
                                        @if ($errors->has('quantity'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                        @endif

                                    </div>
                                </div>

                                <div class="form-group">
                                    <span> Total cost: £</span><b><span id="cost">0</span></b><span id="deal"
                                                                                                    style="color: green; padding-left: 5px;"></span>
                                </div>

                                <button id="btn-credits" class="btn btn-primary btn-block" type="submit">Buy credits
                                </button>
                            </div>
                        </form>
                            </div>
                    @else
                        <div class="container-fluid">
                        <form name="buycredits" id="buycredits" action="{{ url('/profile/withdrawcredits') }}"
                              method="post" class="signup-form full-width-form" role="form" onsubmit="buttonDisableWithdraw()">
                            {{ csrf_field() }}
                            <div class="container-fluid">
                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                    <div class="input-group credits_input">
                                        @if($credits->credits < 10)
                                            <label class="control-label">You need to have at least 10 credits for a
                                                withdrawal!</label><br>
                                        @endif
                                        <label for="quantity" class="control-label">Amount of credits:</label>
                                        <input id="quantity" type="number" class="form-control" placeholder="Credits"
                                               autofocus name="quantity"
                                               @if($credits->credits < 10)
                                               disabled
                                                @endif
                                        >
                                        @if ($errors->has('quantity'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                        @endif

                                    </div>
                                </div>

                                <button id="btn-credits" class="btn btn-primary btn-block" type="submit"
                                        @if($credits->credits < 10)
                                        disabled
                                        @endif
                                >Withdraw credits
                                </button>
                            </div>
                        </form>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </br>
    <div class="panel panel-default" style="margin-bottom: 0">
        <div class="panel-heading">
            @if($user->type == "provider")
                <div class="pull-left"><b>Withdrawals history</b></div>
            @else
                <div class="pull-left"><b>Payments history</b></div>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        <div class="container" style="padding: 0; width: 100%; max-height: 400px; overflow: auto;">
            @if (!$payments->isEmpty())
                <div class="results">
                    <table class="table table-bordered table-hover" id="results-table" style="margin: 0">
                        <thead>
                        <tr>
                            <th>
                                Credits
                            </th>
                            <th>
                                Date and Time
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{$payment->credit}}</td>
                                <td>{{$payment->created_at}}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else

                <div style="margin: 15px; font-size: 150%;">
                    You do not have any credit history yet.
                </div>

            @endif

        </div>
    </div>
    <br>
    </body>

@endsection