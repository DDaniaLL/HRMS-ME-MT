@extends('layouts.app', ['activePage' => 'allstaffleaves', 'titlePage' => ('allstaffleaves')])

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

                @php

            
                            $hruser = Auth::user();
                            @endphp
                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">All <strong>{{$name}}</strong> leaves - Advanced Search Results</h4>
                          <div class="col-12 text-right">
                            Between <strong>{{$start_date}}</strong> and <strong>{{$end_date}}</strong>
                         
                            
                            
                          </div>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                        <table id="table_id" style="font-size: 14px;" class="table  table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                            <tr  style=" background-color: #ffb678 !important;">
                                <th style="width: 3%" class="text-center" scope="col">{{__('allStaffLeaves.id')}}</th>
                                <th style="width: 10%" scope="col">{{__('allStaffLeaves.name')}}</th>
                                @if ($hruser->office == "CO-Erbil")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.leaveType')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.startDate')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.endDate')}}</th>
                                <th style="width: 3%" class="text-center" scope="col">{{__('allStaffLeaves.days')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.status')}}</th>
                                <th style="width: 10%" class="text-center" scope="col">{{__('allStaffLeaves.lineManager')}}</th>
                            
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                              <td class="text-center"><a  style = "color: #007bff;" href="{{ route('leaves.show', encrypt($leave->id)) }}" target="_blank" >{{ $leave->id }}</a></td>
                              <td>{{ $leave->user ? $leave->user->name : 'Deleted User' }}</td>
                              @if ($hruser->office == "CO-Erbil")
                                  <td class="text-center">{{ $leave->user->office }}</td>
                                    @endif
                              <td class="text-center">{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                             
                              @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                              <td class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                              <td class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{__("databaseLeaves.$leave->status")}}</td>
                              <td class="text-center">{{ $leave->user ? $leave->lmapprover : '-' }}</td>
                             
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
 @endsection


 @push('scripts')

  <!-- DataTables  & Plugins -->


  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


  <script>
     $(document).ready( function () {
    $('#table_id').DataTable(
        {
            "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "order": [[0, "desc" ]]
        }
    );
} );
  </script>
@endpush
