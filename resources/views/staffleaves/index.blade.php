@extends('layouts.app', ['activePage' => 'staffleaves', 'titlePage' => ('staffleaves')])

@section('content')

          <div class="content">
              <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 mb-6">
                        <div class="text">
                            {{-- @foreach ($users as $user) --}}
                            {{-- <h3>Welcome <b>{{$user->name}}</b> </h3> --}}
                            {{-- @endforeach --}}
                        </div>
                    </div>
                </div>
                <br>



                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('staffleaves.myStaff')}}</h4>
                          {{-- <div class="col-12 text-right">
                            <a href="{{route('leaves.create')}}" class="btn btn-sm btn-primary">Submit a new Leave</a>
                          </div> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                        
                      <table id="table_iddd" class="table w-100 d-block d-md-table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                      <thead>
                          <tr style=" background-color: #ffb678 !important;">
                            <th style="width: 20%" scope="col">{{__('staffleaves.name')}}</th>
                            <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.employeeNumber')}}</th>
                            <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.balance')}}</th>
                            <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.position')}}</th>
                            <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.joinedDate')}}</th>

                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                          <tr>
                            <td>
                                {{ $user->name }}
                            </td>

                            <td class="text-center">{{ $user->employee_number }} - {{$user->contract}}</td>
                            <td class="text-center">
                              @if ($user->contract == "International") 

                              {{ $user->balances->first()->value }}/{{ $user->balances->get(10)->value }}/{{ $user->balances->get(11)->value }}
                              @endif
                              @if ($user->contract !== "International")
                              {{ $user->balances->first()->value }}/{{ $user->balances->get(1)->value }}/{{ $user->balances->get(17)->value }}</td>
                              @endif
                            <td class="text-center">{{ $user->position }}</td>
                            <td class="text-center">{{ $user->joined_date }}</td>

                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                        <!-- </div> -->
                      </div>
                    </div>
                    <!-- Modal -->

                </div>
                
                
                <div class="container-fluid">
                  <div class="card">
                    <div id='calendar'></div>
                  </div>
              </div>
               



                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('staffleaves.myStaffLeaves')}}</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">

                        <table id="table_id"  class="table w-100 d-block d-md-table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr style=" background-color: #ffb678 !important;">
                                <th style="width: 5%" scope="col">{{__('staffleaves.id-Leave')}}</th>
                                <th style="width: 15%" scope="col">{{__('staffleaves.name')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.leaveType')}}</th>
                                <th style="width: 20%" class="text-center" scope="col">{{__('staffleaves.startDate')}}</th>
                                <th style="width: 20%"  class="text-center"scope="col">{{__('staffleaves.endDate')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.days')}}</th>
                                <th style="width: 100%" class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                                
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                                <td><a href="{{ route('leaves.show', encrypt($leave->id)) }}" >{{ $leave->id }}</a></td>
                              <td>{{ $leave->user->name }}</td>
                              <td class="text-center">{{ $leave->leavetype->name }}</td>
                              @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                              <td class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                              <td class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
                              
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                        </div>
                      </div>
                  </div>

                  <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('staffleaves.myStaffOvertime')}}</h4>
                        {{-- <p class="card-category"> Here you can manage users</p> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                      <table id="table_idd" class="table w-100 d-block d-md-table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                      <thead>
                          <tr style=" background-color: #ffb678 !important;">
                          <th style="width: 10%" scope="col">{{__('staffleaves.id-Overtime')}}</th>
                              <th style="width: 20%" scope="col">{{__('staffleaves.name')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.overtimeType')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.date')}}</th>
                              <th style="width: 10%"  class="text-center"scope="col">{{__('staffleaves.startHour')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.endHour')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('staffleaves.hours')}}</th>
                              <th style="width: 100%" class="text-center" scope="col">{{__('staffleaves.status')}}</th>
                              
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($overtimes as $overtime)
                          <tr>
                            <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" >{{ $overtime->id }}</a></td>
                            <td>{{ $overtime->user ? $overtime->user->name : 'Deleted User' }}</td>
                            <td class="text-center">{{ $overtime->type }}</td>
                            @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                            <td class="text-center">{{__("databaseLeaves.$dayname")}} {{ $overtime->date }}</td>
                            <td class="text-center">{{ $overtime->start_hour }}</td>
                            <td class="text-center">{{ $overtime->end_hour }}</td>
                            <td class="text-center">{{ $overtime->hours }}</td>
                            <td class="text-center">{{ $overtime->status }}</td>
                           
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                      </div>
                    </div>
                </div>
                <br>


              </div>
          </div>
 @endsection

 @push('scripts')
 
 <!-- DataTables  & Plugins -->
 
 @if (isset($events))

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: @json($events),
      aspectRatio: 2.5,
//         businessHours: {
//   // days of week. an array of zero-based day of week integers (0=Sunday)
//   daysOfWeek: [ 0, 1, 2, 3, 4 ], // Monday - Thursday

// },
      eventClick: function(info) {
  // alert('Event: ' + info.event.title);
  // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
  // alert('View: ' + info.view.type);

  // // change the border color just for fun
  // info.el.style.borderColor = 'red';
  info.jsEvent.preventDefault();
  if (info.event.url) {
    window.open(info.event.url);
  }
},
      hiddenDays: [ 5, 6 ],
      // allDayDefault:true
    //   events:[
    //     {
    //   title: 'Long Event',
    //   start: '2023-07-07',
    //   end: '2023-07-10'
    // },
    //   ]
    });
    calendar.render();
  });

</script>
@endif
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


<script>
  $(document).ready( function () {
  $('#table_id').DataTable(
      {
          "order": [[ 0, "desc" ]],
          
      }
  );

  $('#table_idd').DataTable(
      {
          "order": [[ 0, "desc" ]]
      }
  );
  $('#table_iddd').DataTable(
      {
          "order": [[ 4, "desc" ]],
          "pageLength": 50
      }
  );
} );
</script>
@endpush

 
