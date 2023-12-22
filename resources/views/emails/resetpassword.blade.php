@component('mail::message')

Dear {{ $details['name'] }}
# Request has been received to change the password of your HR360 account.
# تم استقبال طلب لتغيير كلمة السر الخاصة بحسابك
<br>
Your Employee Number is : رقمك الوظيفي : <strong>{{$details['employee']}}</strong>
<br>
<br>



@component('mail::button', ['url' => route('reset.password.get', $details['token'])])
Reset Password
@endcomponent
   

@endcomponent