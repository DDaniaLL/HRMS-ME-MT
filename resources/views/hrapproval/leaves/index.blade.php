@extends('layouts.app', ['activePage' => 'hrleavesapproval', 'titlePage' => ('hrleavesapproval')])

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
                @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
                  <div class="container-fluid">
                          <div class="card">
                            <div class="card-header card-header-primary">
                              <h4 class="card-title ">{{__('hrApprovalLeave.leavesPendinHrApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>

                            @php
                            $hruser = Auth::user();
                            @endphp
                            <div class="card-body table-responsive-md ">
                              <!-- <div class="row"> -->
                              <table id="table_id"  style="font-size: 15px;" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                            <thead>
                                <tr style=" background-color: #ffb678 !important;">
                                <th style="width: 10%" scope="col">{{__('hrApprovalLeave.id')}}</th>
                                    <th style="width: 20%" scope="col">{{__('hrApprovalLeave.name')}}</th>
                                    @if ($hruser->office == "CO-Erbil")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                    <th style="width: 20%" class="text-center" scope="col">{{__('hrApprovalLeave.leaveType')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.startDate')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.endDate')}}</th>
                                    <th  style="width: 10%" class="text-center"scope="col">{{__('hrApprovalLeave.days')}}</th>
                                    <th style="width: 20%" class="text-center" scope="col">{{__('hrApprovalLeave.status')}}</th>
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.action')}}</th>
                                    <!-- <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.decline')}}</th> -->
                                    <!-- <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.forward')}}</th> -->
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                <tr>
                                  <td class="text-center"><a href="{{ route('leaves.show', encrypt($leave->id)) }}" ><strong>{{ $leave->id }}</strong></a></td>
                                  <td>
                                    
                                   
                              <div class="dropdown">
  <a style="color: #007bff;"  type="button" id="dropdownMenu1" data-toggle="dropdown">
  {{ $leave->user->name }}
  </a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a class="ml-2" target="_blank" role="menuitem"  href="{{ route('admin.users.show', $leave->user) }}">Staff Account </a></li>
  </ul>
</div>
                                  
                                  <!-- <a style = "color: #007bff;" href="{{ route('admin.users.show', $leave->user) }}" >{{ $leave->user->name }}</a> -->
                                
                                
                                </td>
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
                                  <td class="text-center">
                                  <div class="text-center">
                                    <button type="button" class="mx-1 mb-0 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-check-square"></i> </button>
                                    <button type="button" class="mx-1 mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal2{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button>
                                    @if ($leave->exapprover == null)
                                    <button  type="button" class="mx-1 mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal3{{$leave->id}}"><i class="fas fa-plus-square"></i> </button>
                                    @endif
                                </div>
                                    </td>
                                    <!-- <td class="text-center">
                                      <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal2{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                    </td> -->
                                   
                                    <!-- <td class="text-center">
                                      <div class="text-center"><button  type="button" class="mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal3{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                    </td> -->
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                              <!-- </div> -->
                            </div>
                          </div>


                          
                          @foreach ($leaves as $leave)

  <div id="myModal{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Approving leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.hrapproved',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-success" value="Approve">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>


  <div id="myModal2{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Declining leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.hrdeclined',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-danger" value="Decline">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>


  <div id="myModal3{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Forwarding leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.forward',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.extra')}}</small></label>
                <input class="form-control form-outline" type="text" list="FavoriteColor" id="color" placeholder="Choose Staff Name.."
                                            name="extra" value="{{ old('extra') }}" autocomplete="off">
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-warning" value="Forward">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>
  @endforeach

                  </div>
              </div>
          </div>
 @endsection

 @push('scripts')
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

<script>

$(document).ready(function() {

    $('#table_id').DataTable(
        {
            "order": [[ 0, "desc" ]],
            
        }
    );

    $('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});

    $(document).on('click', '#buttonSelector', function () {
    $(this).addClass('disabled');
});

});

</script>
<script>

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
 myInput.focus()
})
</script>

@endpush

