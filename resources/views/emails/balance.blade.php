@component('mail::message')

# {{ $details['hrname'] }}
for <strong>{{ $details['staffaffected'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Time      | {{ $details['timeofchange'] }}         
    | ------------- |:-------------:
    | Reason:      | {{ $details['reason'] }}
@endcomponent
<br>


   

@endcomponent