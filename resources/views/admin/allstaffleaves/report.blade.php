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

/* tr:nth-child(even) {
  background-color: #eaeaea;
} */
</style>
</head>
<body>

<!-- <img src="{{url('hr360-2.jpg')}}"  alt="" width="500" height="600"> -->


<div class="content">
        <div class="container ">
            <div class="row">
            
                <div class="col-xs-4 text-left">
                    <div class="text">
                    <h3>Leave Summary report</h3>
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
                                <th style="width: 3%" scope="col">ID</th>
                           
                                <th style="width: 10%" class="text-center" scope="col">Leave type</th>
                                <th style="width: 10%" class="text-center" scope="col">Start date</th>
                                <th style="width: 10%" class="text-center" scope="col">End date</th>
                                <th style="width: 3%" class="text-center" scope="col">Days</th>
                                <th style="width: 10%" class="text-center" scope="col">Status</th>
                                <th style="width: 10%" class="text-center" scope="col">Line Manager</th>
                             
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($leaves as $leave)
                            <tr>
                              <td>{{ $leave->id }}</a></td>
                         
                              <td class="text-center">{{ $leave->leavetype->name }}</td>
                              <td class="text-center">{{ $leave->start_date }}</td>
                              <td class="text-center">{{ $leave->end_date }}</td>
                              <td class="text-center">{{ $leave->days }}</td>
                              <td class="text-center">{{ $leave->status }}</td>
                              <td class="text-center">{{ $leave->user ? $leave->lmapprover : '-' }}</td>
                           
                              
                            </tr>
                            @endforeach
                          </tbody>
</table>

           


                <div class="col">
                  <div class="text">
                    <br>

                    <small><i>the info and calculations below are still experimental, please double check and inform System admin for any issue</i></small>
                  <br>
                  Number of submitted approved annual days before HR 360 + on HR 360: <strong>{{$sumofannual}}</strong>
                  <br>
                  {{-- Number of submitted annual leave days before HR 360: <strong>{{$numberofdays}}</strong>
                  <br> --}}
                  Accrual days from joined date until <strong>{{$end_date}}</strong> is: <strong>{{$accruedbalance}}</strong>
                  <br>
                  <h5 style="color:blue;">Result of Accrual - total Submitted is <strong>{{$result}}</strong></h5>
                  <br>
                  
                  </div>
              </div>

              <hr class="dashed">
              <style>hr.dashed {
                border-top: 3px dashed #bbb;
              }</style>

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

