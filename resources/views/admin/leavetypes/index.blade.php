@extends('layouts.app', ['activePage' => 'leavetypes', 'titlePage' => ('leavetypes')])

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
                          <h4 class="card-title ">{{__('systemoffices.offices')}}</h4>
                          @php
                          $user = Auth::user()
                      @endphp
                      @if ($user->office == "CO-Erbil")
                      @if ($user->hradmin == 'yes')
                             <div   div class="col-12 text-right">
                                <a href="{{route('admin.leavetypes.create')}}" class="btn btn-sm btn-primary">{{__('systemoffices.addOffice')}}</a>
                             </div>
                      @endif
                      @endif
                        </div>
                        <div class="card-body table-responsive-md">

                          <div class="row">
                        <table class="table table-hover text-nowrap table-Secondary">
                        <thead>
                            <tr>
                              <th class="text-center" scope="col">{{__('systemoffices.id')}}</th>
                              <th class="text-center" scope="col">{{__('systemoffices.name')}}</th>
                              <th class="text-center" scope="col">{{__('systemoffices.value')}}</th>
                              
                             
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leavetypes as $leavetype)
                            <tr>
                              <td class="text-center">{{ $leavetype->id }}</td>
                              <td class="text-center">{{ $leavetype->name }}</td>
                              <td class="text-center">{{ $leavetype->value }}</td>
                              
                            </tr>
                            @endforeach
                          </tbody>
                      </table>

                          </div>

                        </div>
                      </div>




                      @foreach ($leavetypes as $leavetype)


                      <div id="myModal{{$leavetype->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 style="color: red" class="modal-title">Attention!</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                <p>Are you sure you want to delete: <br><strong>{{$leavetype->name}}</strong>.</p>
                                <form method="POST" action="{{ route('admin.leavetypes.destroy', $leavetype) }}" class="text-center" >
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
