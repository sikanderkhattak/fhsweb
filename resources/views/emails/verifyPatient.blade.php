<!DOCTYPE html>
<html>
  <head>
    <title>Verification Email</title>
  </head>
  <body>
    <h2>Welcome to IMC</h2>
    <br/>
    Your registered email-id is {{$patient['email']}} , Please click on the below link to verify your email account
    <br/>
    <a href="{{url('patient/verify', $patient->verifyPatient->token)}}">Verify Email</a>
  </body>
</html>