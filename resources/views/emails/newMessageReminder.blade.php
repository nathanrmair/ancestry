<html>
<body>
    <div class="header">
        {{--<img src="{{ url('/') }}/img/mail-logo.png" />--}}
    </div>
    <h2> You just received a message from <b>{{ $user }}</b></h2>

    <p>Here is the message:</p>

    <p>{{ $userMessage }}</p>

    <p> <a href="{{ url('profile/dashboard/messages') }}">Click here to access your messages</a> </p>


<h3>Kind Regards,<br>
The MyAncestralScotland Team</h3>
    <p>
    <h5>Do you have any questions? Head over to our <a href="{{ url('FAQs') }}">FAQ</a> page to find the answer, or contact a member of our team. </h5></p>

</body>
</html>