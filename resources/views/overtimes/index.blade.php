@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

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
                          <h4 class="card-title ">{{__('overtimesIndex.myOvertimes')}}</h4>
                          {{-- <p class="card-category">Here you can see the history of overtimes</p> --}}
                          <div class="col-12 text-right">
                          <a href="{{route('overtimes.create')}}" class="btn btn-md btn-primary"><strong>{{__('overtimesIndex.submitNewOvertime')}}</strong></a>
                          </div>
                        </div>
                        <div class="card-body table-responsive-md">


                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary">
                            <thead>
                            <tr style=" background-color: #ffb678 !important;">
                            <th  style="width: 3%"  scope="col">{{__('overtimesIndex.id')}}</th>
                              <th  style="width: 10%"  scope="col">{{__('overtimesIndex.type')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.date')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.starthour')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.endhour')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.hours')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.value')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.status')}}</th>
                              <th class="text-center" scope="col">{{__('overtimesIndex.action')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            @if ($overtime->status == "Approved")
                                <tr style=" background-color: #D9F8C4 !important;" >
                                @endif
                                @if ($overtime->status  == "Declined by LM" OR $overtime->status  == "Declined by HR" )
                                <tr style=" background-color: #FAD4D4 !important;" >
                                @endif
                                <td><a href="{{ route('overtimes.show', encrypt($overtime->id)) }}" ><strong>{{ $overtime->id }}</strong></a></td>
                              <td>{{__("databaseLeaves.$overtime->type")}}</td>
                              @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                              <td data-order={{ $overtime->date }} class="text-center">{{__("databaseLeaves.$dayname")}} {{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->value }}</td>
                              <td class="text-center">{{__("databaseLeaves.$overtime->status")}}</td>
                              <td class="text-center">
                                @php
                                if ($overtime->status == 'Approved' || $overtime->status == 'Declined by extra Approval'  || $overtime->status == 'Approved by extra Approval' || $overtime->status == 'Declined by HR' || $overtime->status == 'Pending extra Approval' || $overtime->status == 'Cancelled' || $overtime->status == 'Submitted by HR' || $overtime->status == 'Declined by LM')
                                {
                                    $variable='disabled';
                                }
                                      else
                                      {
                                          $variable = 'notdisabled';
                                      }

                                @endphp
                                @if ($variable == 'notdisabled')

                                <div class="text-center"><button type="button" class="mb-0 form-group btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal{{$overtime->id}}"><i class="fas fa-minus-circle "></i> </button></div>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                        </div>
                      </div>

                      @foreach ($overtimes as $overtime)


<div id="myModal{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 style="color: red" class="modal-title">{{__('leaves.attention')}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>{{__('leaves.deletemessage')}} <strong>{{$overtime->id}}</strong>.</p>
          <form method="POST" action="{{ route('overtimes.destroy', $overtime->id) }}" class="text-center" >
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
