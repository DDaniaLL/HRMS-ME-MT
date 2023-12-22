@component('mail::message')

Dear {{ $details['requestername'] }} 
# {{ $details['title'] }}
Line Manager: <strong>{{ $details['linemanagername'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Hours      | {{ $details['hours'] }}         
    | ------------- |:-------------:
    | Date:      | {{ $details['dayname'] }} {{ $details['date'] }}      
    | From:      |  {{ $details['start_hour'] }}
    | To:      |  {{ $details['end_hour'] }}
    | Overtime Comment:      | {{ $details['comment'] }}
    | Line Manager Comment:      | {{ $details['lmcomment'] }}
@endcomponent
<br>

@component('mail::panel')
    Current Status: {{ $details['status'] }}
@endcomponent

@component('mail::button', ['url' => 'https://nrchr360iq.nrc.no/overtimes'])
Check your overtime requests
@endcomponent

@endcomponent