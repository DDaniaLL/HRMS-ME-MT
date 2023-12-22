@extends('layouts.app', ['activePage' => 'allstaffbalances', 'titlePage' => ('all users')])

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
                          <h4 class="card-title ">All Staff balances</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">
                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondar">
                }
                        <thead>
                            <tr>
                                <th scope="col">Name</th>

                                <th class="text-center" scope="col">Annual leave</th>
                                <th class="text-center" scope="col">Sick leave</th>
                                <th class="text-center" scope="col">Welfare leave</th>
                                <th class="text-center" scope="col"> </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $user)
                            <tr>
                              <td>{{ $user->name }}</td>
                              <td class="text-center">{{ $user->balances->value->where('leavetype_id' , '1') }}</td>
                              <td class="text-center">{{ $user->name }}</td>
                              <td class="text-center">{{ $user->name }}</td>
                              <td class="text-center">{{ $user->name }}</td>
                              {{-- <td>edit</td> --}}
                            </tr>
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
