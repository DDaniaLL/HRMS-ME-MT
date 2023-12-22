@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

          <div class="content">
              <div class="container-fluid">


                <div class="row">
                    <div class="col-md-6 mb-6">
                        <div class="text">

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
                                    <h4 class="card-title">{{__('allUsers.allUsers')}}</h4>
                                        <div class="col-12 text-right">

                                          <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-primary">{{__('allUsers.createNewUser')}}</a>
                                          <a href="{{route('admin.alluserssearch.cond')}}" class="btn btn-sm ml-2 btn-success">{{__('allStaffLeaves.advancedSearch')}} <i class="ml-2 fas fa-search"></i> </a>
                                          <a href="{{route('admin.allusersbalanceexport.cond')}}" class="btn btn-sm ml-2 btn-info">{{__('allStaffLeaves.balanceexport')}} <i class="ml-2 fas fa-file-excel"></i> </a>
                                          @if ($user->name == "HR Test")
                                          {{-- <a href="{{route('admin.users.importshow')}}" class="btn btn-sm ml-2 btn-success">Import <i class="ml-2 fas fa-file-excel"></i> </a> --}}
                                          {{-- <a href="{{route('admin.users.createbalance')}}" class="btn btn-sm ml-2 btn-success">Create Balance <i class="ml-2 fas fa-file-excel"></i> </a>  --}}
                                          @endif
                                          <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn ml-2 btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Export <i class="ml-2 fas fa-file-excel"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                              <a class="dropdown-item" href="{{route('admin.users.export')}}">{{__('allUsers.allUsers')}}</i></a>
                                               {{-- <a class="dropdown-item" href="{{route('attendances.export')}}">All Attendances </i></a>  --}}
                                            </div>
                                        </div>

                                        </div>
                                    </div>


                                      <div class="card-body table-responsive-md">
                                          <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                                            <thead>
                                              <tr style=" background-color: #ffb678 !important;">
                                              
                                              <th style="width: 20%" scope="col">{{__('allUsers.name')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.employeeId')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.position')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.office')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.joinDate')}}</th>
                                              <th style="width: 20%" scope="col">{{__('allUsers.lineManager')}}</th>
                                         
                                             
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                <tr>
                                                  <td>
                                                      @if ($user->status == 'suspended')
                                                      <i class="fas fa-minus-circle"></i>
                                                      @endif
                                                      <a style = "color: #007bff;" href="{{ route('admin.users.show', $user) }}" >{{ $user->name }}</a>
                                                    </td>
                                                  <td>{{ $user->employee_number }}</td>
                                                  <td>{{ $user->position }}</td>
                                                  <td>{{ $user->office }}</td>
                                                  <td>{{ $user->joined_date }}</td>
                                                  <td>{{ $user->linemanager }}</td>
                                               
                                              

                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                              <th style="width: 20%" scope="col">{{__('allUsers.name')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.employeeId')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.position')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.office')}}</th>
                                              <th style="width: 10%" scope="col">{{__('allUsers.joinDate')}}</th>
                                              <th style="width: 20%" scope="col">{{__('allUsers.lineManager')}}</th>
                                              
                                            

                                              </tr>
                                            </tfoot>
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
      $('.list').hide();
      $(document).on('click', '.expand', function () {
$('.list').toggle('show');
});
      setTimeout(function() {
    $("div.successMsg").fadeOut('slow');
}, 6000); 


    $('#table_id').DataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "order": [[1, "desc" ]],
    });
});
  </script>


<script>

var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
});
</script>
@endpush



