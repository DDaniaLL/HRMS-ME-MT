@extends('layouts.app', ['activePage' => 'attendanceshrapproval', 'titlePage' => __('attendanceshrapproval')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">

                        <br>
                        <h3>
                             <b>{{$user->first()->name}} </b>
                             <br>

                             <b>{{$user->first()->employee_number}}</b>
                         </h3>

                    </div>
                </div>


            </div>
            <br>
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">

                        {{-- <h4 class="card-title ">Attendance - <b>{{$attendances->month}}</b></h4> --}}
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="{{route('admin.users.edit', $user)}}" class="btn btn-sm btn-primary">Edit</a>
                              </div>
                          </div> --}}

                          <table class="table table-hover text-nowrap table-Secondary ">
                            <thead>
                                <tr>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Check in</th>
                                    <th class="text-center">Check out</th>
                                    <th class="text-center">Leave or Overtime ID</th>
                                    <th class="text-center">Comment</th>

                                </tr>
                              </thead>
                              <tbody>
                                  @foreach ($attendances as $attendance)

                                  <tr>
                                      <td class="text-center">
                                        {{ $attendance->sign }}
                                      </td>
                                      <td class="text-center" >
                                          {{ $attendance->day }}
                                        </td>
                                        <td class="text-center">

                                            {{ $attendance->start_hour }}



                                          </td>
                                          <td class="text-center">

                                            {{ $attendance->end_hour }}

                                           </td>
                                           <td class="text-center">

                                            {{ $attendance->leave_overtime_id }}

                                           </td>
                                           <td class="text-center">

                                            {{ $attendance->remarks }}


                                        </tr>


                                    @endforeach

                              </tbody>

                          </table>



                      </div>
                    </div>


                    <div class="card">
                        <div class="card-header card-header-primary ">
                            <h4 class="mt-1 card-text mr-2 text-center"> <a href="{{ route('attendances.hrapproved', ['user'=>$user->first(),'month'=>$attendance->month]) }}">Approve <strong>{{$attendance->month}}</strong> attendance</a> </h4>
                            <h4 class="mt-1 card-text mr-2 text-center"> <a href="{{ route('attendances.hrdeclined', ['user'=>$user->first(),'month'=>$attendance->month]) }}">Decline <strong>{{$attendance->month}}</strong> attendance</a> </h4>
                            {{-- <h4 class="mt-1 card-text mr-2 text-center"> <a href="{{ route('attendances.submit', ['user'=>$user,'month'=>$attendance->month]) }}">Submit <strong>{{$attendance->month}}</strong> attendance</a> </h4> --}}
                          <div class="col-12 text-left ">
                            {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="mb-0 btn btn-sm btn-outline-primary">Edit  <i class="ml-2  fas fa-lg fa-list-ol"></i></a> --}}
                          </div>
                          {{-- <a href="{{route('admin.users.balanceedit', $user)}}" role="button" class="btn btn-sm btn-outline-primary">Edit  <i class="ml-2 fas fa-lg fa-user-cog"></i></a> --}}
                        </div>
            </div>
                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')

@endpush
