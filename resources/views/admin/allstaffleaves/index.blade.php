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
                
                @if(Session::has('successMsg'))
    <div class="successMsg alert alert-success"> {{ Session::get('successMsg') }}</div>
  @endif
                @php
                            $hruser = Auth::user();
                            @endphp

                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('allStaffLeaves.allStaffLeaves')}}</h4>
                          <div class="col-12 text-right">
                            <a href="{{route('admin.allleavessearch.cond')}}" class="btn btn-sm ml-2 btn-success">{{__('allStaffLeaves.advancedSearch')}} <i class="ml-2 fas fa-search"></i> </a>
                            <a href="{{route('admin.leaves.pdf')}}" class="btn btn-sm ml-2 btn-primary">{{__('allStaffLeaves.pdfReport')}} <i class="ml-2 fas fa-file-pdf"></i> </a>
                            <a href="{{route('admin.leaves.export')}}" class="btn btn-sm ml-2 btn-secondary">{{__('allStaffLeaves.excel')}} <i class="ml-2 fas fa-file-excel"></i> </a>
                          </div>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                        <table id="table_id" style="font-size: 14px;" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
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
                            <td class="text-center"><a target="_blank" href="{{ route('leaves.show', encrypt($leave->id)) }}" ><strong>{{ $leave->id }}</strong></a></td>
                              <td>
                                
                              <div class="dropdown">
  <a style="color: #007bff;"  type="button" id="dropdownMenu1" data-toggle="dropdown">
  {{ $leave->user ? $leave->user->name : 'Deleted User' }}
  </a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a class="ml-2" target="_blank" role="menuitem"  href="{{ route('admin.users.show', $leave->user) }}">Staff Account </a></li>
  </ul>
</div>
</td>

                              
                              @if ($hruser->office == "CO-Erbil")
                                  <td class="text-center">{{ $leave->user->office }}</td>
                                    @endif
                              <td class="text-center">{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                             
                              @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                              <td data-order={{ $leave->start_date }} class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                              <td data-order={{ $leave->end_date }} class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
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
