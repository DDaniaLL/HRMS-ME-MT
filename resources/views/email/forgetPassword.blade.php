<h1>Forget Password Email</h1>
   
You can reset password from bellow link:
<a href="{{ route('reset.password.get', $token) }}">Reset Password</a>


@component('mail::message')

Dear {{ $name }} 
# Request has been received to change the password of your HR360 account.
  <br>

@component('mail::button', ['url' => \URL::to('/subscriptions/'.$recipient->id.'/'.$recipient->email.'?action=subscribe')])
Approve/Decline
@endcomponent
   

@endcomponent