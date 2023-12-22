@extends('layouts.app', ['activePage' => 'leavesapproval', 'titlePage' => ('leavesapproval')])

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
                @if(Session::has('success'))
                <div class="success alert alert-success"> {{ Session::get('success') }}</div>
              @endif
                  <div class="container-fluid">
                          <div class="card">
                            <div class="card-header card-header-primary">
                              <h4 class="card-title ">{{__('leaveApproval.leavesPendingYourApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-responsive table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                <th style="width: 3%" scope="col">{{__('leaveApproval.id')}}</th>
                                    <th style="width: 3%" scope="col">{{__('leaveApproval.name')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.leaveType')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.startDate')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.endDate')}}</th>
                                    <th  class="text-center"scope="col">{{__('leaveApproval.days')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.status')}}</th>
                                    <th class="text-center" scope="col ">{{__('leaveApproval.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('leaveApproval.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($leaves as $leave)
                                @if ($leave->status == "Pending extra Approval")
                                <tr style=" background-color: #feefc1 !important;" >
                                @endif
                                @if ($leave->status  == "Pending LM Approval")
                                <tr >
                                @endif
                                    <td><a href="{{ route('leaves.show', encrypt($leave->id)) }}" ><strong>{{ $leave->id }}</strong></a></td>
                                  <td>{{ $leave->user->name }}</td>
                                  <td class="text-center">{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                                  @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                                  <td class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                                  <td class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                                  <td class="text-center">{{ $leave->days }}</td>
                                  <td class="text-center">{{__("databaseLeaves.$leave->status")}}</td>
                                  @if ($leave->status == "Pending extra Approval")
                                  <td class="text-center">
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal3{{$leave->id}}"><i class="fas fa-check-square"></i> </button></div>
                                    </td>
                                    <td class="text-center">
                                    <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal4{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                        {{-- <a id="buttonSelector" class="btn btn-danger" href="{{route('leaves.declined',$leave->id)}}">{{__('leaveApproval.decline')}}</a> --}}
                                    </td>
                                  @endif 
                                  @if ($leave->status  == "Pending LM Approval")
                                  <td class="text-center">
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-block btn-success" data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-check-square"></i> </button></div>
                                    </td>
                                    <td class="text-center">
                                    <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-block btn-danger" data-toggle="modal" data-target="#myModal2{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                        {{-- <a id="buttonSelector" class="btn btn-danger" href="{{route('leaves.declined',$leave->id)}}">{{__('leaveApproval.decline')}}</a> --}}
                                    </td>
                                  @endif
                                  
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                              </div>
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
          <form method="POST" action="{{route('leaves.approved',$leave->id)}}" class="mb-0 text-center" >
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
          <form method="POST" action="{{route('leaves.declined',$leave->id)}}" class="mb-0 text-center" >
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
          <p>Extra Approving leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.exapproved',$leave->id)}}" class="mb-0 text-center" >
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


  <div id="myModal4{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Extra Declining leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.exdeclined',$leave->id)}}" class="mb-0 text-center" >
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
  @endforeach

                  </div>
              </div>
          </div>
 @endsection
 @push('scripts')

<script>

$(document).ready(function() {

  setTimeout(function() {
    $("div.success").fadeOut('slow');
}, 1500); 

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
