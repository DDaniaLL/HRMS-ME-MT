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
            
                             <div   div class="col-12 text-right">
                                <a href="{{route('admin.leavetypes.create')}}" class="btn btn-sm btn-primary">{{__('systemoffices.addOffice')}}</a>
                             </div>
                  
                        </div>
                        <div class="card-body table-responsive">

                         
                          <table id="table_iddd" class="table w-100 table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                          <tr style=" background-color: #ffb678 !important;">
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.id')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.name')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.value')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.active')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.accrualtype')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.national')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.international')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.service')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.custom')}}</th>
                              <th class="text-center" style="width: 10%" scope="col">{{__('systemoffices.order')}}</th>
                             
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leavetypes as $leavetype)
                            <tr>
                              <td class="text-center">{{ $leavetype->id }}</td>
                              <td class="text-center">{{ $leavetype->name }}</td>
                              <td class="text-center">{{ $leavetype->value }}</td>
                              <td class="text-center">{{ $leavetype->active }}</td>
                              <td class="text-center">{{ $leavetype->accrualtype }}</td>
                              <td class="text-center">{{ $leavetype->national }}</td>
                              <td class="text-center">{{ $leavetype->international }}</td>
                              <td class="text-center">{{ $leavetype->service }}</td>
                              <td class="text-center">{{ $leavetype->custom }}</td>
                              <td class="text-center">{{ $leavetype->order }}</td>
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

 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
 <script>
  $('#table_iddd').DataTable(
      {
          "order": [[ 0, "asc" ]],
          
      }
  );

  
    </script>
    @endpush
