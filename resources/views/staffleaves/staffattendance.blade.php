@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col ml-3">
                    <div class="text">
                        {{-- @foreach ($users as $user) --}}
                        <br>
                        <h3>
                             <b>{{$user->name}} </b>
                             <br>
                             <b>{{$user->employee_number}}</b>
                         </h3>
                        {{-- @endforeach --}}
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        {{-- @foreach ($users as $user) --}}

                        <h2>
                            {{$month}}
                        </h2>
                        {{-- @endforeach --}}
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

                                    <th>Day</th>
                                    <th class="text-center">Check in</th>
                                    <th class="text-center">Check out</th>
                                    <th class="text-center">Leave or Overtime ID</th>
                                    <th class="text-center">Comment</th>

                                </tr>
                              </thead>
                              <tbody>
                                  @foreach ($attendances as $attendance)

                                  <tr>
                                      <td >
                                          {{ $attendance->day }}
                                        </td>
                                        <td class="text-center">
                                            @if (isset($attendance->start_hour))
                                            {{ $attendance->start_hour }}
                                            @endif
                                            {{-- @if (!isset($attendance->start_hour))
                                            <input class="form-control form-outline" type="time" id="start_hour"  name="start_hour" placeholder="">
                                            @endif --}}
                                          </td>
                                          <td class="text-center">
                                            @if (isset($attendance->end_hour))
                                            {{ $attendance->end_hour }}
                                            @endif
                                            {{-- @if (!isset($attendance->end_hour))
                                             <input class="form-control form-outline" type="time" id="end_hour"  name="end_hour" placeholder="">
                                             @endif --}}
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->leave_overtime_id))
                                            {{ $attendance->leave_overtime_id }}
                                            @endif
                                            {{-- @if (!isset($attendance->leave_overtime_id))
                                             <input class="form-control form-outline" type="text" id="leave_overtime_id"  name="leave_overtime_id" placeholder="">
                                             @endif --}}
                                           </td>
                                           <td class="text-center">
                                            @if (isset($attendance->remarks))
                                            {{ $attendance->remarks }}
                                            @endif
                                            {{-- @if (!isset($attendance->remarks))
                                             <input class="form-control form-outline" type="text" id="remarks"  name="remarks" placeholder="">
                                             @endif --}}
                                           </td>

                                        </tr>
                                    </form>
                                    @endforeach

                              </tbody>

                          </table>



                      </div>
                    </div>




                </div>
            </div>
        </div>
    </div>





@endsection

@push('scripts')

@endpush
