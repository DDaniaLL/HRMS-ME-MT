@extends('layouts.app', ['activePage' => 'attendanceshrapproval', 'titlePage' => __('attendancesapproval')])

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
                        <h4 class="card-title ">Staff attendances <strong>{{$month}}</strong> pending approvals</h4>
                          {{-- <div class="col-12 text-right">
                            <a href="{{route('leaves.create')}}" class="btn btn-sm btn-primary">Submit a new Leave</a>
                          </div> --}}
                      </div>
                      <div class="card-body table-responsive-md">

                        <div class="row">
                      <table class="table table-hover text-nowrap table-Secondary">
                      <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Birth Date</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Employee Number</th>
                            <th class="text-center" scope="col">Position</th>
                            <th class="text-center" scope="col">Joined Date</th>

                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                          <tr>
                            <td>
                                <a href="{{route('attendances.approval.hr.staff.show',[$attendance,$user])}}" target="_blank">{{ $user->name }}</a>
                            </td>
                            <td>{{ $user->birth_date }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->employee_number }}</td>
                            <td class="text-center">{{ $user->position }}</td>
                            <td class="text-center">{{ $user->joined_date }}</td>

                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->

                </div>







              </div>
          </div>
 @endsection


 @push('scripts')

  <!-- DataTables  & Plugins -->



@endpush
