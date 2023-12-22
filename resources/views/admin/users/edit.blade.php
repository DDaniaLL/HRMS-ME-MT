@extends('layouts.app', ['activePage' => 'all-users', 'titlePage' => ('all users')])

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
                        <h4 class="card-title "> <a href="{{ URL::previous() }}"> <i  class="fas fa-arrow-alt-circle-left"></i> </a> {{__('edituser.editUser')}}</h4>
                      </div>


                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">{{$user->name}}</h3>
                                    <form class="form-card" action="{{ route('admin.users.update',$user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">{{__('edituser.fullName')}}</label>
                                                <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }} " type="text" id="name" value="{{$user->name}}" name="name" placeholder="">
                                                @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                            </div>
                                           
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">{{__('edituser.position')}}</label> <input class="form-control form-outline" type="text" id="position" value="{{$user->position}}" name="position" placeholder="" > </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            

                                            @php
                                            $authuser = Auth::user();
                                            @endphp

                                            @if ($authuser->office == "CO-Erbil")
                                            <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('office') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('joined_date') ? ' is-invalid' : '' }}">{{__('edituser.office')}}</label>
                                        <select class="form-control form-outline"  id="office" name="office" aria-label="Default select example" >
                                          
                                          <option value selected disabled ="">Choose office..</option>
                                        
                                          <option value="CO-Erbil" @if ($user->office == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option>
                                          <option value="NIAO" @if ($user->office == "NIAO") {{ 'selected' }} @endif>NIAO</option>
                                          <option value="KRAO" @if ($user->office == "KRAO") {{ 'selected' }} @endif>KRAO</option>
                                          <option value="CIAO" @if ($user->office == "CIAO") {{ 'selected' }} @endif>CIAO</option>
                                          <option value="SIAO" @if ($user->office == "SIAO") {{ 'selected' }} @endif>SIAO</option>
                                          
                                        </select>
                                        @if ($errors->has('office'))  
                                                <span id="office-error" class="error text-danger" for="input-office">{{ $errors->first('office') }}</span>
                                               @endif
                                        </div>
                                        @endif

                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">{{__('edituser.department')}}</label> <input class="form-control form-outline" type="text" id="department"  value="{{ $user->department }}" name="department" placeholder="" > </div>

                                        <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('grade') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('grade') ? ' is-invalid' : '' }}">{{__('createUser.grade')}}</label>
                                          
                                              <select class="form-control form-outline" id="grade" name="grade" aria-label="Default select example" >

                                              <option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.grade')}}..</option>

                                              <option value="1" @if ($user->grade == "1") {{ 'selected' }} @endif>1</option>
                                              <option value="2" @if ($user->grade == "2") {{ 'selected' }} @endif>2</option>
                                              <option value="3" @if ($user->grade == "3") {{ 'selected' }} @endif>3</option>
                                              <option value="4" @if ($user->grade == "4") {{ 'selected' }} @endif>4</option>
                                              <option value="5" @if ($user->grade == "5") {{ 'selected' }} @endif>5</option>
                                              <option value="6" @if ($user->grade == "6") {{ 'selected' }} @endif>6</option>
                                              <option value="7" @if ($user->grade == "7") {{ 'selected' }} @endif>7</option>
                                              <option value="8" @if ($user->grade == "8") {{ 'selected' }} @endif>8</option>
                                              <option value="9" @if ($user->grade == "9") {{ 'selected' }} @endif>9</option>
                                              <option value="10" @if ($user->grade == "10") {{ 'selected' }} @endif>10</option>
                                              <option value="11" @if ($user->grade == "11") {{ 'selected' }} @endif>11</option>
                                              <option value="12" @if ($user->grade == "12") {{ 'selected' }} @endif>12</option>
                                              <option value="13" @if ($user->grade == "13") {{ 'selected' }} @endif>13</option>
                                              </select>

                                          @if ($errors->has('grade'))
                                                <span id="grade-error" class="error text-danger" for="input-grade">{{ $errors->first('grade') }}</span>
                                               @endif
                                              </div>  
                                        </div>
                                        
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('joined_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">{{__('edituser.joinDate')}}</label>
                                                <input class="form-control form-outline {{ $errors->has('joined_date') ? ' is-invalid' : '' }}" type="date" id="joined_date" value="{{$user->joined_date}}" name="joined_date" placeholder="" >
                                                @if ($errors->has('joined_date'))
                                                <span id="joined_date-error" class="error text-danger" for="input-joined_date">{{ $errors->first('joined_date') }}</span>
                                               @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('employee_number') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">{{__('edituser.employeeId')}}</label>
                                                <input class="form-control form-outline {{ $errors->has('employee_number') ? ' is-invalid' : '' }}" type="text" id="employee_id"  value="{{$user->employee_number}}" name="employee_number" placeholder="" >
                                                @if ($errors->has('employee_number'))
                                                <span id="employee_number-error" class="error text-danger" for="input-employee_number">{{ $errors->first('employee_number') }}</span>
                                               @endif
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left">
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('edituser.lineManager')}}</label>
                                                <input class="form-control form-outline" type="text" list="FavoriteColor" id="linemanager"  value="{{$user->linemanager}}" name="linemanager" placeholder="" autocomplete="off">
                                                        <datalist id="FavoriteColor">
                                                            @foreach ($userss as $userr)
                                                                <option value="{{$userr->name}}"></option>
                                                            @endforeach
                                                        </datalist>
                                                        </p>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('edituser.email')}}</label>
                                                <input class="form-control form-outline {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" id="email" value="{{$user->email}}" name="email" autocomplete="off" placeholder=""  >
                                               @if ($errors->has('email'))
                                                 <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="row justify-content-between text-left">
                                       
                                        @php
                                        if ($user->hradmin == "yes") {
                                      $admin = "Admin";
                                    }

                                    else {
                                        $admin = "Not Admin";
                                    }
                                            @endphp

                                            @if ($hruser->superadmin == "yes")
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('edituser.permissionOnHrms')}} <small>({{__('edituser.Currently')}}: {{$admin}})</small></label>
                                                <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="no" id="test1" {{ $admin=='Not Admin' ? ' checked' : '' }}>
                                                    <label class="form-check-label" for="test1">
                                                      Not Admin
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" {{ $admin=='Admin' ? ' checked' : '' }} >
                                                    <label class="form-check-label" for="test2">
                                                      Admin
                                                    </label>
                                                  </div>
                                            </div>
                                            @endif
                                            @php
                                              if($user->isprob == "no")
                                              {
                                                $prob="no";
                                              }
                                              else
                                              {
                                                $prob="yes";
                                              }
                                            
                                            @endphp
                                            <div class="form-group col-sm-6 flex-column d-flex">
                                              <label class="form-control-label px-1">{{__('edituser.changeprob')}} </label>
                                              <div class="form-check">
                                                  <input class="btn-check" type="radio" name="isprob" Value="yes" id="test3" {{ $prob=='yes' ? ' checked' : '' }}>
                                                  <label class="form-check-label" for="test4">
                                                    Yes, Automatic probation
                                                  </label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="btn-check" type="radio" name="isprob" Value="no" id="test5" {{ $prob=='no' ? ' checked' : '' }} >
                                                  <label class="form-check-label" for="test6">
                                                    No, Manually remove from probation
                                                  </label>
                                                </div>
                                          </div>
                                            
                                            @php
                                        if ($user->contract == "National") {
                                      $contract = "National";
                                    }

                                    elseif ($user->contract == "International") {
                                        $contract = "International";
                                    }
                                    elseif ($user->contract == "NA") {
                                      $contract = "NA";
                                    }
                                    else {
                                      $contract = "undefiend";
                                    }
                                            @endphp
                                            <div class="form-group {{ $errors->has('contract') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex"> <label class="form-control-label  px-1">{{__('edituser.contractType')}}</label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="National" id="National" {{ $contract=='National' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="National">
                                            {{__('edituser.NationalContract')}}
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="International" id="International" {{ $contract=='International' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="International">
                                            {{__('edituser.InternationalContract')}}
                                            </label>
                                          </div> 
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="NA" id="na" {{ $contract=='NA' ? ' checked' : '' }}>
                                            <label class="form-check-label" for="na">
                                            {{__('edituser.notAvaillable')}}
                                            </label>
                                          </div> 
                                        </div>

                                        </div>
                                        {{-- @if ($user->email == null && $user->grade < 3) --}}
                                        {{-- <div class="row justify-content-between text-left"> --}}
                                          {{-- @if ($authuser->id == '1') --}}
                                              {{-- <div class="form-group  {{ $errors->has('password') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                  <label class="form-control-label  px-1">{{__('edituser.password')}} <small>({{__('edituser.changepassword')}})</small></label>
                                                  <div class="input-group">
                                                      <input class="form-control form-outline  {{ $errors->has('password') ? ' is-invalid' : '' }} "  type="password" id="password" autocomplete="off"
                                                      name="password"  autocomplete="new-password" placeholder="{{__('edituser.passwordnote')}}"> --}}
                                                      {{-- @if ($errors->has('password'))
                                                   <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                                  @endif --}}
                                                      {{-- <div class="input-group-append">
                                                       <div class="input-group-text  ">
                                                         <i class="fas fa-eye-slash" id="eye1"></i>
                                                       </div>
                                                     </div>
                                                   </div>
                                                   @if ($errors->has('password'))
                                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                               @endif
                                                  </div> --}}
                                                  {{-- @endif --}}
                                          {{-- </div> --}}
                                        {{-- @endif --}}
                                      
                                        {{-- MUST ADD requirepd for radio check --}}
                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block btn-1 ">{{__('edituser.update')}}</button> </div>
                                            <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >{{__('edituser.cancel')}}</a> </div>
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
                <style>
                    .required:after {
                      content:" *";
                      color: red;
                    }
                    i{
                                                        cursor:pointer;
                                                    }
                  </style>







    </div>
  </div>
@endsection
@push('scripts')

<script>


$(document).ready(function() {
  $('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});
$(document).on('click', '.btn-1', function ()
{

  $('.btn-1').html(
          `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `
        );
});
});

  $("#eye1").on('click',function() {

if($(this).hasClass('fa-eye-slash')){

  $(this).removeClass('fa-eye-slash');

  $(this).addClass('fa-eye');

  $('#password').attr('type','text');

}else{

  $(this).removeClass('fa-eye');

  $(this).addClass('fa-eye-slash');

  $('#password').attr('type','password');
}
});
</script>

@endpush
