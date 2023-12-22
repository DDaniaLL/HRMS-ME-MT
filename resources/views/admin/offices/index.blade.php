@extends('layouts.app', ['activePage' => 'offices', 'titlePage' => ('offices')])

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
                                <a href="{{route('admin.offices.create')}}" class="btn btn-sm btn-primary">{{__('systemoffices.addOffice')}}</a>
                             </div>
                    
                  
                        </div>
                        <div class="card-body table-responsive-md">

                          
                            <table id="table_iddd" class="table w-100 d-block d-md-table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">
                        <thead>
                          <tr style=" background-color: #ffb678 !important;">
                              <th class="text-center" style="width: 20%"  scope="col">{{__('systemoffices.name')}}</th>
                              <th class="text-center"style="width: 20%"  scope="col">{{__('systemoffices.description')}}</th>
                              <th class="text-center" style="width: 20%" scope="col">{{__('systemoffices.countryoffice')}}</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($offices as $office)
                            <tr>
                              <td class="text-center">{{ $office->name }}</a></td>
                              <td class="text-center">{{ $office->description }}</td>
                              <td class="text-center">{{ $office->isco }}</td>
                            
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
          "order": [[ 2, "desc" ]],
          
      }
  );

  
    </script>
    @endpush
