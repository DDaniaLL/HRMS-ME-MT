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


                          <div class="container-fluid">
                                <div class="card">
                                <div class="card-header card-header-primary">
                          <h4 class="card-title ">All <strong>{{$name}}</strong> User details</h4>
                          <div class="col-12 text-right">
                          
                         
                            
                            
                          </div>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
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



