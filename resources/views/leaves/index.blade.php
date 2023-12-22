@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('all leaves')])

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

                  <div class="container-fluid">
                      <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('leaves.myLeaves')}}</h4>
                            <div class="col-12 text-right">
                              <a href="{{route('leaves.create')}}" class="btn btn-md btn-primary"><strong>{{__('leaves.submitNewLeave')}}</strong></a>
                            </div>
                        </div>

                        <div class="card-body table-responsive-md">

                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr style=" background-color: #ffb678 !important;">
                            <th style="width: 3%" scope="col">{{__('leaves.id')}}</th>
                              <th style="width: 10%" scope="col">{{__('leaves.type')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.startDate')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.endDate')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.days')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.status')}}</th>
                              <th class="text-center" scope="col">{{__('leaves.action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            @if ($leave->status == "Approved")
                                <tr style=" background-color: #D9F8C4 !important;" >
                                @endif
                                @if ($leave->status  == "Declined by LM" OR $leave->status  == "Declined by HR" )
                                <tr style=" background-color: #FAD4D4 !important;" >
                                @endif
                              <td><a href="{{ route('leaves.show', encrypt($leave->id)) }}" ><strong>{{ $leave->id }}</strong></a></td>
                              <td>{{ __("databaseLeaves.{$leave->leavetype->name}") }}</td>
                              @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                              <td data-order={{ $leave->start_date }} class="text-center">{{__("databaseLeaves.$startdayname")}} {{ $leave->start_date }}</td>
                              <td data-order={{ $leave->end_date }} class="text-center">{{__("databaseLeaves.$enddayname")}} {{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{__("databaseLeaves.$leave->status")}}</td>
                              <td class="text-center">
                                  @php
                                  if ($leave->status == 'Approved' || $leave->status == 'Declined by extra Approval'  || $leave->status == 'Approved by extra Approval' || $leave->status == 'Declined by HR' || $leave->status == 'Pending extra Approval' || $leave->status == 'Cancelled' || $leave->status == 'Submitted by HR' || $leave->status == 'Declined by LM')
                                  {
                                      $variable='disabled';
                                  }
                                        else
                                        {
                                            $variable = 'notdisabled';
                                        }

                                  @endphp
                                  @if ($variable == 'notdisabled')

                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                  @endif

                                  {{-- @if ($variable = 'notdisabled')
                                  <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-secondary " data-toggle="modal" data-target="#myModal{{$leave->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                  @endif --}}



                                
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                        </div>
                      </div>
                      <!-- Modal -->
@foreach ($leaves as $leave)


<div id="myModal{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">{{__('leaves.attention')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>{{__('leaves.deletemessage')}} <strong>{{$leave->id}}</strong>.</p>
          <form method="POST" action="{{ route('leaves.destroy', $leave->id) }}" class="text-center" >
            {{-- @csrf
            @method('DELETE') --}}

            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete">
            </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('leaves.Cancel')}}</button>
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

 <!-- DataTables  & Plugins -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

 <script>



    $(document).ready( function () {

      setTimeout(function() {
    $("div.successMsg").fadeOut('slow');
}, 3000); 


      $('form').submit(function(){
$(this).find(':submit').attr('disabled','disabled');
});


    $('#table_id').DataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "order": [[0, "desc" ]],
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
