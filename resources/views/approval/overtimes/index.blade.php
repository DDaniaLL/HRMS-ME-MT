@extends('layouts.app', ['activePage' => 'overtimesapproval', 'titlePage' => ('overtimesapproval')])

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
                              <h4 class="card-title ">{{__('overtimeApproval.overtimesPendingYourApproval')}}</h4>
                              {{-- <p class="card-category"> Here you can manage users</p> --}}
                            </div>
                            <div class="card-body table-responsive-md ">
                              <div class="row">
                            <table class="table table-responsive  table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th style="width: 3%" scope="col">{{__('overtimeApproval.id')}}</th>
                                    <th style="width: 3%" scope="col">{{__('overtimeApproval.name')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.overtimeType')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.date')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.startHour')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.endHour')}}</th>
                                    <th  class="text-center"scope="col">{{__('overtimeApproval.hours')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimesIndex.value')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.status')}}</th>
                                    <th class="text-center" scope="col ">{{__('overtimeApproval.approve')}}</th>
                                    <th class="text-center" scope="col">{{__('overtimeApproval.decline')}}</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($overtimes as $overtime)
                                @if ($overtime->status == "Pending extra Approval")
                                <tr style=" background-color: #feefc1 !important;" >
                                @endif
                                @if ($overtime->status  == "Pending LM Approval")
                                <tr >
                                @endif
                                    <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" ><strong>{{ $overtime->id }}</strong></a></td>
                                  <td>{{ $overtime->user->name }}</td>
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
                                  @if ($overtime->status == "Pending extra Approval")
                                  <td class="text-center">
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal3{{$overtime->id}}"><i class="fas fa-check-square"></i> </button></div>
                                    </td>
                                    <td class="text-center">
                                    <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal4{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                        
                                    </td>
                                  @endif 
                                  @if ($overtime->status  == "Pending LM Approval")
                                  <td class="text-center">
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs  btn-block btn-success" data-toggle="modal" data-target="#myModal{{$overtime->id}}"><i class="fas fa-check-square"></i> </button></div>
                                    </td>
                                    <td class="text-center">
                                    <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-block btn-danger" data-toggle="modal" data-target="#myModal2{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button></div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                              </div>
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
          <form method="POST" action="{{route('overtimes.approved',$overtime->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

                <br>
                <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> -->
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
          <form method="POST" action="{{route('overtimes.declined',$overtime->id)}}" class="mb-0 text-center" >
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
          <p>Extra Approving overtime: <strong>{{$overtime->id}}</strong></p>
          <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
          <form method="POST" action="{{route('overtimes.exapproved',$overtime->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

                <br>
                {{-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div>  --}}
                                        
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

  <div id="myModal4{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Extra Declining overtime: <strong>{{$overtime->id}}</strong></p>
          <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
          <form method="POST" action="{{route('overtimes.exdeclined',$overtime->id)}}" class="mb-0 text-center" >
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
