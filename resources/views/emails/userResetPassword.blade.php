<!DOCTYPE html>
<html>
  <head>
    <title>Reset Password</title>
  </head>
  <body>
    <h2>Dear {{$user->name}},</h2>
    <br/>
    If you Forgot your password No Problem. We sent You Reset Password Link , Please click on the below link to Reset Password
    <br/>
    <a href="{{url('user/resetPassword', $user->resetPasswordToken->reset_token)}}">Reset Password</a>
  </body>
</html>