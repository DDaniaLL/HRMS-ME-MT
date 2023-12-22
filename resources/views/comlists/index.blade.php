@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

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
                        
                        <h4 class="card-title ">
                        <a href="{{ URL::previous() }}"> <i style="font-size: 1.12em;" class="fas fa-arrow-alt-circle-left"></i> </a> 
                          {{__('comlists.mycomlists')}} - {{__('welcome.compensationLeaveDays')}}: <strong>{{$balance18}}</strong> days</h4>
                          
                        </div>
                        
                        
                      <div class="card-body table-responsive-md">

                      <table id="table_idd" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary ">
                      <thead>
                          <tr style=" background-color: #ffb678 !important;">
                          <th style="width: 10%"  class="text-center" scope="col">{{__('comlists.overtimeid')}}</th>
                              <th style="width: 20%"  class="text-center" scope="col">{{__('comlists.days')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('comlists.status')}}</th>
                              <th style="width: 10%" class="text-center" scope="col">{{__('comlists.expireddate')}}</th>
                              <th style="width: 10%"  class="text-center"scope="col">{{__('comlists.expiredvalue')}}</th>
                              <th style="width: 15%" class="text-center" scope="col">{{__('comlists.dateCreated')}}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($comlists as $comlist)
                          <tr>
                            <td class="text-center"><a href="{{ route('overtimes.show', encrypt($comlist->overtime->id)) }}" ><strong>{{ $comlist->overtime->id }}</strong></a></td>
                            <td class="text-center">{{ $comlist->hours}}</td>
                            <td class="text-center">{{ __("databaseLeaves.{$comlist->status}") }}</td>
                            <td class="text-center">{{ $comlist->autodate }}</td>
                            <td class="text-center">{{ $comlist->expired_value }}</td>
                            <td class="text-center"> {{ $comlist->created_at }}</td>
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

      $('form').submit(function(){
$(this).find(':submit').attr('disabled','disabled');
});


    $('#table_idd').DataTable({
        // "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        paging: false,
        searching: false,
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
