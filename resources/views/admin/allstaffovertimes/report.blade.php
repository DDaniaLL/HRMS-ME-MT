<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>

  
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #eaeaea;
}
</style>
</head>
<body>

<!-- <img src="{{url('hr360-2.jpg')}}"  alt="" width="500" height="600"> -->




<div class="content">
        <div class="container ">
            <div class="row">
            
                <div class="col-xs-4 text-left">
                    <div class="text">
                    <h3>Overtime Summary report</h3>
                    <br>
                    Staff: <strong>{{$name}}</strong> - <strong>{{$userpeopleid}}</strong>
                    <br>
                    Period: <strong>{{$start_date}}</strong> to <strong>{{$end_date}}</strong>
                    <br>
                    
                    </div>
                </div>
                <div class="col-xs-7 text-right">
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/hr360-2.jpg'))) }}"  alt="" width="200" height="100">

</div>

                
       


            </div>
            </div>
            </div>

<br>

                                
<table>
<thead>
                            <tr>
                                <th style="width: 3%"scope="col">ID</th>
                                
                                <th style="width: 10%" class="text-center" scope="col">Type</th>
                                <th style="width: 10%" class="text-center" scope="col">Date</th>
                                <th style="width: 10%" class="text-center" scope="col">Start Hour</th>
                                <th style="width: 10%" class="text-center" scope="col">End Hour</th>
                                <th style="width: 5%" class="text-center" scope="col">Hours</th>
                                <th style="width: 5%" class="text-center" scope="col">Hours <small>(Value)</small></th>
                                <th style="width: 10%" class="text-center" scope="col">Status</th>
                                <th style="width: 10%" class="text-center" scope="col">Line Manager</th>
                                
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($overtimes as $overtime)
                            <tr>
                              <td>{{ $overtime->id }}</a></td>
                            
                              <td class="text-center">{{ $overtime->type }}</td>
                              <td class="text-center">{{ $overtime->date }}</td>
                              <td class="text-center">{{ $overtime->start_hour }}</td>
                              <td class="text-center">{{ $overtime->end_hour }}</td>
                              <td class="text-center">{{ $overtime->hours }}</td>
                              <td class="text-center">{{ $overtime->value }}</td>
                              <td class="text-center">{{ $overtime->status }}</td>
                              <td class="text-center">{{ $overtime->lmapprover }}</td>
                             
                              {{-- <td>edit</td> --}}
                            </tr>
                            @endforeach
                          </tbody>
</table>

<div class="col">
                    <div class="text">
        
                    <br>
                    Requested by: <strong>{{$hruser->name}}</strong>
                    <br>
                    Date of request: <strong>{{$date}}</strong>
                    <br>
                    
                    </div>
                </div>

</body>
</html>

