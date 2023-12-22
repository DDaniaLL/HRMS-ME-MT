@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('creating leave')])

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
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif





                <div class="container-fluid">
                    <div class="card">
                      <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                        <h4 class="card-title "><a href="{{ URL::previous() }}"> <i  class="fas fa-arrow-alt-circle-left"></i> </a>{{__('createOvertime.newOvertime')}}</h4>
                    </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-1 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-4">
                                    
                                      <form action="{{ route('overtimes.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row justify-content-between text-left">
                                        <div id="type" class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label required px-1">{{__('createOvertime.overtimeType')}} 
                                           <a class="text" style="color: #5a8efc;" id="reset" href="" > {{__('createLeave.changetype')}} 
                                                    <i class="fas fa-sync-alt" style="color: #5a8efc;"></i> 
                                                     </a>
                                                  </label>
                                
                                        @php
                                        $user = Auth::user();
                                        if($user->contract == "National")
                                        {
                                          $contract='National';
                                        }
                                        else
                                        {
                                          $contract='notNational';
                                        }

                                        @endphp
                                        @if ($contract=='National')


                                        <div class="form-check">
                                          <input  class="btn-check"  type="radio" name="type" id="workday" Value="workday">
                                          <label class="form-check-label" id="workdaylabel" for="workday">
                                          {{__('createOvertime.workday')}} <small> {{__('createOvertime.suntothu')}}</small>
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input  class="btn-check" type="radio" name="type" id="weekend" Value="week-end"  >
                                          <label class="form-check-label" id="weekendlabel" for="weekend">
                                          {{__('createOvertime.Week-end')}} <small>{{__('createOvertime.friorsat')}}</small>
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input  class="btn-check" type="radio" name="type" id="holiday" Value="holiday"  >
                                          <label class="form-check-label" id="holidaylabel" for="holiday">
                                          {{__('createOvertime.Holiday')}}
                                          </label>
                                        </div>




                                        @endif




                                        
                                        @if ($contract=='notNational')
                                          
                                        <div class="form-check">
                                          <input  class="btn-check"  type="radio" name="type" id="workday" Value="workday">
                                          <label class="form-check-label" id="workdaylabel" for="workday">
                                          {{__('createOvertime.workday')}} <small> {{__('createOvertime.suntothu')}}</small>
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input  class="btn-check" type="radio" name="type" id="weekend" Value="week-end"  >
                                          <label class="form-check-label" id="weekendlabel" for="weekend">
                                          {{__('createOvertime.Week-end')}} <small>{{__('createOvertime.friorsat')}}</small>
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input  class="btn-check" type="radio" name="type" id="holiday" Value="holiday"  >
                                          <label class="form-check-label" id="holidaylabel" for="holiday">
                                          {{__('createOvertime.Holiday')}}
                                          </label>
                                        </div>

                                              @endif
                                         
                                             
                                            </div>
                                            <div class="col justify-content-between text-left">
                                              @if (count($userss))
                                              <div class="form-group col-sm-12 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('createLeave.substaff')}}</label>
                                                <input class="form-control form-outline" type="text" list="FavoriteColor" id="mystaff"  name="mystaff" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->employee_number}}">{{$userr->name}}</option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div>
                                              @endif
  
  
                                                  
                                          </div>

                                          <div class="form-group  {{ $errors->has('date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex" >
                                            
                                              <label for="date" class="form-control-label required px-1" >{{__('createOvertime.Date')}}</label>
                                              <div class="input-group">
                                              <input   onkeydown="event.preventDefault()" id="datepicker" placeholder="{{__('createOvertime.message')}}" name="date" type="text" autocomplete="off" class="form-control form-outline {{ $errors->has('date') ? ' is-invalid' : '' }}" />
                                              <div class="input-group-append">
                                                  <div class="input-group-text ">
                                                    <i class="fas fa-calendar-alt"></i>
                                                  </div>
                                                </div>
                                              </div>
                                              @if ($errors->has('date'))
                                                 <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                                                @endif
                                          </div>





                                          {{-- <div class="row justify-content-between text-left"> --}}
                                              <div class="form-group {{ $errors->has('start_hour') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                  <label class="form-control-label required px-1" >{{__('createOvertime.starthour')}}</label>
                                                  <input type="time" name="start_hour" class="form-control form-outline {{ $errors->has('start_hour') ? ' is-invalid' : '' }}" />
                                                  @if ($errors->has('start_hour'))
                                                 <span id="start_hour-error" class="error text-danger" for="input-start_hour">{{ $errors->first('start_hour') }}</span>
                                                @endif
                                              </div>
                                                <div class="form-group {{ $errors->has('end_hour') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label required px-1" >{{__('createOvertime.endhour')}}</label>
                                                    <input type="time" name="end_hour" class="form-control form-outline {{ $errors->has('end_hour') ? ' is-invalid' : '' }}" />
                                                    @if ($errors->has('end_hour'))
                                                 <span id="end_hour-error" class="error text-danger" for="input-end_hour">{{ $errors->first('end_hour') }}</span>
                                                @endif
                                                </div>
                                                {{-- new row --}}
                                                <div class="form-group {{ $errors->has('reason') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label required px-1" >{{__('createOvertime.reason')}}/{{__('createOvertime.comment')}}</label>
                                                    <input type="text" id="reason" autocomplete="off" name="reason" placeholder="" class="form-control form-outline {{ $errors->has('reason') ? ' is-invalid' : '' }} " />
                                                    @if ($errors->has('reason'))
                                                 <span id="reason-error" class="error text-danger" for="input-reason">{{ $errors->first('reason') }}</span>
                                                @endif
                                                </div>
                                                  <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                      <label class="form-control-label  px-1" >{{__('createOvertime.attachment')}} <small>(Image or PDF - 3 MB Max)</small></label>
                                                      <input  type="file" name="file" id="file" class="form-control-file form-outline {{ $errors->has('file') ? ' is-invalid' : '' }}" />
                                                      @if ($errors->has('file'))
                                                 <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                                @endif

                                                  </div>
                                                  
                                          {{-- </div> --}}
                                        </div>
                                        <br>
                                        {{-- <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> --> --}}
                                        <br>
                                        <div class="row justify-content-center">
                                            <div class="justify-content-center form-group col-sm-2"> <button type="submit" class="btn-1">{{__('createOvertime.submit')}}</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('overtimes.index')}}" >{{__('createOvertime.cancel')}}</a> </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <style>
                    .required:after {
                      content:" *";
                      color: red;
                    }
                    .btn-1 {
  border: none;
  width: 100%;
  height: 100%;
  color: white;
  background-color: #FF7602;
  border-radius: 4px;
  box-shadow: inset 0 0 0 0 #14489e;

}
.btn-1.activate {
  box-shadow: inset 500px 0 0 0 #14489e;
  transition: all 2s;

}
                    
                  
                  </style>
                  @if (App::isLocale('ar'))
          <style>         
      .datepicker {
        direction: rtl;
      }             
    .datepicker.dropdown-menu {
right: initial;             
      }     
    </style>
     @endif




    </div>
  </div>
@endsection

@push('scripts')




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
<script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
    ></script>
<script>



$(document).ready(function() {

  $(document).on('click', '.btn-1', function () {
$(this).addClass('activate');
$(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `
      );
});

  $('#reset').hide();
  

  $('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});

var weekday;
  
$("input[name=type]:radio").change(function(){
  $('#reset').show();
    if ($("#workday").prop("checked")) {
      $('#weekend').hide();
      $('#weekendlabel').hide();
      $('#holiday').hide();
      $('#holidaylabel').hide();
      weekday = "5,6";
      $('#datepicker').datepicker({ 
    format: 'yyyy-mm-dd',
    
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,
daysOfWeekDisabled: weekday

  });
    }
   else if ($("#weekend").prop("checked")) {
     weekday = "0,1,2,3,4";
     $('#workday').hide();
      $('#workdaylabel').hide();
      $('#holiday').hide();
      $('#holidaylabel').hide();
      $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,
daysOfWeekDisabled: weekday
  });
    }
    else if ($("#holiday").prop("checked"))
    {
      $('#workday').hide();
      $('#workdaylabel').hide();
      $('#weekend').hide();
      $('#weekendlabel').hide();
      $('#datepicker').datepicker({
    format: 'yyyy-mm-dd',
    weekStart: 0,
    clearBtn: true,
    autoclose: true,
    todayHighlight: true,
    
  });
    }

  });


});

    </script>

@endpush
