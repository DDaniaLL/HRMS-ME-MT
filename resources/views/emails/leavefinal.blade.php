@component('mail::message')

Dear {{ $details['requestername'] }} 
# {{ $details['title'] }}
Line Manager: <strong>{{ $details['linemanagername'] }}</strong> 
<br>
HR: <strong>{{ $details['hrname'] }}</strong> 
  <br>
  <br>


  @component('mail::table')
    | Days      | {{ $details['days'] }}         
    | ------------- |:-------------:
    | From:      | {{ $details['startdayname'] }} {{ $details['start_date'] }}      
    | To:      | {{ $details['enddayname'] }} {{ $details['end_date'] }}
    | Leave Comment:      | {{ $details['comment'] }}
    | Line Manager Comment:      | {{ $details['lmcomment'] }}
    | HR Comment:      | {{ $details['hrcomment'] }}
@endcomponent
<br>

@component('mail::panel')
    New Balance: {{ $details['newbalance'] }}
@endcomponent

@component('mail::button', ['url' => 'https://nrchr360iq.nrc.no/leaves'])
Check your leave requests
@endcomponent

@endcomponent