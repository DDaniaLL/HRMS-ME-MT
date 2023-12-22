@extends('layouts.app', ['activePage' => 'hrovertimesapproval', 'titlePage' => ('hrovertimesapproval')])

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
                              <h4 class="card-title ">{{__('hrApprovalOvertime.overtimesPendingHrApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            @php
                            $hruser = Auth::user();
                            @endphp
                            <div class="card-body table-responsive-md ">
                              <!-- <div class="row"> -->
                              <table id="table_id" style="font-size: 15px;"  class="table  table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                            <thead>
                                <tr style=" background-color: #ffb678 !important;">
                                  <th style="width: 3%" scope="col">{{__('hrApprovalOvertime.id')}}</th>
                                    <th style="width: 3%" scope="col">{{__('hrApprovalOvertime.name')}}</th>
                                    @if ($hruser->office == "CO-Erbil")
                                    <th style="width: 10%" class="text-center" scope="col">{{__('hrApprovalLeave.office')}}</th>
                                    @endif
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.type')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.date')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.startHour')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.endHour')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.hours')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimesIndex.value')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalOvertime.status')}}</th>
                                    <th class="text-center" scope="col">{{__('hrApprovalLeave.action')}}</th>
                                    <!-- <th class="text-center" scope="col ">{{__('hrApprovalOvertime.approve')}}</th> -->
                                    <!-- <th class="text-center" scope="col">{{__('hrApprovalOvertime.decline')}}</th> -->
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($overtimes as $overtime)
                                <tr>
                                    <td class="text-center"><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" ><strong>{{ $overtime->id }}</strong></a></td>
                                    <td>
                                      
                                      
                              <div class="dropdown">
  <a style="color: #007bff;"  type="button" id="dropdownMenu1" data-toggle="dropdown">
  {{ $overtime->user->name }} 
  </a>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a class="ml-2" target="_blank" role="menuitem"  href="{{ route('admin.users.show', $overtime->user) }}">Staff Account </a></li>
  </ul>
</div>
                                    
                                    <!-- <a style = "color: #007bff;" href="{{ route('admin.users.show', $overtime->user) }}" >{{ $overtime->user->name }} -->
                                  
                                  
                                  </td>
                                    @if ($hruser->office == "CO-Erbil")
                                  <td class="text-center">{{ $overtime->user->office }}</td>
                                    @endif
                                    <td class="text-center">{{ $overtime->type }}</td>
                                    @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                                  <td class="text-center">{{__("databaseLeaves.$dayname")}} {{ $overtime->date }}</td>
                                  <td class="text-center">{{ $overtime->start_hour }}</td>
                                  <td class="text-center">{{ $overtime->end_hour }}</td>
                                  <td class="text-center">{{ $overtime->hours }}</td>
                                  <td class="text-center">{{ $overtime->value }}</td>
                                  <td class="text-center">{{__("databaseLeaves.$overtime->status")}}</td>
                                  <td class="text-center">
                                  <div class="text-center">
                                    <button type="button" class="mb-0 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal{{$overtime->id}}"><i class="fas fa-check-square"></i> </button>
                                    <button type="button" class="mx-1 mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal2{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button>
                                    @if ($overtime->exapprover == null)
                                    <button  type="button" class=" mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal3{{$overtime->id}}"><i class="fas fa-plus-square"></i> </button>
                                    @endif
                                  </div>
                                    </td>
                                    <!-- <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal2{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                    <td class="text-center">
                                    </td> -->
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                              <!-- </div> -->
                            </div>
                          </div>



                          


    @foreach ($overtimes as $overtime)

<div id="myModal{{$overtime->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Approving overtime: <strong>{{$overtime->id}}</strong></p>
        <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
        <form method="POST" action="{{route('overtimes.hrapproved',$overtime->id)}}" class="mb-0 text-center" >
        <div class="row justify-content-center text-center">
        <div class="form-group  col-sm-12 flex-column d-flex">
              <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
              <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">
              <br>
                {{-- <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> --> --}}
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


<div id="myModal2{{$overtime->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Declining overtime: <strong>{{$overtime->id}}</strong></p>
        <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
        <form method="POST" action="{{route('overtimes.hrdeclined',$overtime->id)}}" class="mb-0 text-center" >
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


<div id="myModal3{{$overtime->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Forwarding overtime: <strong>{{$overtime->id}}</strong></p>
        <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
        <form method="POST" action="{{route('overtimes.forward',$overtime->id)}}" class="mb-0 text-center" >
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

$(document).ready(function() {

  

    $(document).on('click', '#buttonSelector', function () {
    $(this).addClass('disabled');
});

});

</script>

@endpush
