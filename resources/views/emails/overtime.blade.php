@component('mail::message')

Dear {{ $details['linemanagername'] }} 
# {{ $details['title'] }}
for <strong>{{ $details['requestername'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Hours      | {{ $details['hours'] }}         
    | ------------- |:-------------:
    | Date:      | {{ $details['dayname'] }} {{ $details['date'] }}      
    | From:      |  {{ $details['start_hour'] }}
    | To:      |  {{ $details['end_hour'] }}
    | Comment:      | {{ $details['comment'] }}
@endcomponent
<br>

@component('mail::button', ['url' => 'https://nrchr360iq.nrc.no/overtimes/approval'])
Approve/Decline
@endcomponent
   

@endcomponent