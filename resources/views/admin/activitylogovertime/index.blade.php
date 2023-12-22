@extends('layouts.app', ['activePage' => 'overtimeactivities', 'titlePage' => ('overtimeactivities')])

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
                          <h4 class="card-title ">Overtimes HR Approval activity log:</h4>
                          {{-- <p class="card-category"> Here you can manage users</p> --}}
                        </div>
                        <div class="card-body table-responsive-md">



                        <table id="table_id" class="table table-responsive table-bordered table-hover text-nowrap table-Secondary table-striped">

                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Description</th>
                                <th class="text-center" scope="col">HR Name</th>
                                <th class="text-center" scope="col">Old Status</th>
                                <th class="text-center" scope="col">New Status</th>
                                <th class="text-center" scope="col">Leave/Overtime Requester</th>
                                <th class="text-center" scope="col">created at </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($allactivity as $activity)
                            <tr>
                            @if($activity->properties['old']['status'] == "Pending HR Approval" AND $activity->subject_type == "App\Models\Overtime")

                            <td class="text-center">{{ $activity->description }}</td>
                            <td class="text-center">{{ optional($activity->causer)->name }}</td>
                            <td class="text-center">{{ $activity->properties['old']['status'] }}</td>
                            <td class="text-center">{{ $activity->properties['attributes']['status'] }}</td>
                            <td class="text-center">{{ $activity->properties['attributes']['user.name']}}</td>
                            <td class="text-center">{{ $activity->created_at }}</td>

                            @endif


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

  <!-- DataTables  & Plugins -->


  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>


  <script>
     $(document).ready( function () {
    $('#table_id').DataTable(
        {
            "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "order": [[2, "desc" ]]
        }
    );
});
  </script>
@endpush
