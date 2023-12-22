@extends('layouts.app', ['activePage' => 'policies', 'titlePage' => ('policies')])

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
                          <h4 class="card-title ">{{__('hrPolicies.hrPolicies')}}</h4>
                          @php
                          $user = Auth::user()
                      @endphp
                      @if ($user->office == "CO-Erbil")
                      @if ($user->hradmin == 'yes')
                             <div   div class="col-12 text-right">
                                <a href="{{route('admin.policies.create')}}" class="btn btn-sm btn-primary">{{__('hrPolicies.addPolicy')}}</a>
                             </div>
                      @endif
                      @endif
                        </div>
                        <div class="card-body table-responsive-md">

                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr>
                              <th class="text-center" scope="col">{{__('hrPolicies.name')}}</th>
                              <th class="text-center" scope="col">{{__('hrPolicies.description')}}</th>
                              <th class="text-center" scope="col">{{__('hrPolicies.createdDate')}}</th>
                              <th class="text-center" scope="col">{{__('hrPolicies.lastUpdate')}}</th>
                              @if ($user->hradmin == 'yes')
                              <th class="text-center" scope="col">{{__('hrPolicies.action')}}</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($policies as $policy)
                            <tr>
                              <td class="text-center"><a href="/storage/files/{{$policy->name}}.pdf" target="_blank">{{ $policy->name }}</a></td>
                              <td class="text-center">{{ $policy->desc }}</td>
                              <td class="text-center">{{ $policy->created_date }}</td>
                              <td class="text-center">{{ $policy->lastupdate_date }}</td>
                              @if ($user->hradmin == 'yes')
                              @if ($user->office == "CO-Erbil")
                              <td class="text-center">
                                <div class="text-center"><button type="button" class=" form-group btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal{{$policy->id}}">Delete</button></div>
                            </td>
                            @endif
                            @endif
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                          </div>

                        </div>
                      </div>




                      @foreach ($policies as $policy)


                      <div id="myModal{{$policy->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 style="color: red" class="modal-title">Attention!</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <p>Are you sure you want to delete: <br><strong>{{$policy->name}}</strong>.</p>
                                <form method="POST" action="{{ route('admin.policies.destroy', $policy) }}" class="text-center" >
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <div class="form-group">
                                      <input type="submit" class="btn btn-danger" value="Delete">
                                  </div>
                              </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              </div>
                            </div>

                          </div>
                        </div>
                        @endforeach

                        <style>
                            table td {
                              font-size: 20px;
                            }
                           </style>
                  </div>
              </div>
          </div>
 @endsection
 @push('scripts')

 <script>

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus()
    })
    </script>
    @endpush
