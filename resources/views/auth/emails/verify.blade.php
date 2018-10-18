<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Please verify your email address</h2>

<div>
    Thanks for creating an account with MyAncestralScotland.

    <br><br> Please click on the 'Verify' button to verify your email address:<br>

    <div>
        <a href="{{ URL::to('register/verify/' . $confirmation_code) }}"><button style="
    margin: 5px;
    text-align: center;
    padding: 5px;
    border-radius: 5px;
    font-weight: bold;
    font-size: large;
    background-color: #30aff0;
    color: white;">Verify</button></a>
    </div>
    <br>

    OR
    <br>
    <br>

    Follow this link: {{ URL::to('register/verify/' . $confirmation_code) }}<br/><br>


    If you have problems, please paste the above URL into your web browser.
    <br><br>

    Thank you

</div>

</body>
</html>