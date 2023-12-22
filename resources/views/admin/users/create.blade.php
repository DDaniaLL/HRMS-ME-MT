@extends('layouts.app', ['activePage' => 'createuser', 'titlePage' => ('users create')])

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
            @if(Session::has('errorMsg'))
            <div class="errorMsg alert alert-danger"> {{ Session::get('errorMsg') }}</div>
          @endif


            <div class="container-fluid">

                <div class="card">
                    <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                        <h4 class="card-title ">{{__('createUser.createNewUser')}}</h4>
                        
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">{{__('createUser.userInformation')}}</h3>
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.users.store') }}" method="POST">
                                      @csrf

                                      <div class="row justify-content-between text-left">
                                          <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label class="form-control-label required px-1">{{__('createUser.fullName')}}</label>
                                              <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }} " type="text" id="name"  value="{{ old('name') }}" name="name" placeholder="">
                                               @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                            </div>
                                         
                                            <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">{{__('createUser.position')}}</label> <input class="form-control form-outline" type="text" id="position"  value="{{ old('position') }}" name="position" placeholder="" > </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                       
                   
                                        <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('office') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('office') ? ' is-invalid' : '' }}">{{__('createUser.office')}}</label>
                                        
@php
$authuser = Auth::user();
@endphp

@if ($authuser->office == "NIAO")
<select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >

<option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.office')}}..</option>

{{-- <!-- <option value="CO-Erbil" @if (old('office') == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option> --> --}}
<option value="NIAO" @if (old('office') == "NIAO") {{ 'selected' }} @endif>NIAO</option>
{{-- <!-- <option value="KRAO" @if (old('office') == "KRAO") {{ 'selected' }} @endif>KRAO</option>
<option value="CIAO" @if (old('office') == "CIAO") {{ 'selected' }} @endif>CIAO</option>
<option value="SIAO" @if (old('office') == "SIAO") {{ 'selected' }} @endif>SIAO</option> --> --}}

</select>

@endif

@if ($authuser->office == "KRAO")
<select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >

<option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.office')}}..</option>

{{-- <!-- <option value="CO-Erbil" @if (old('office') == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option> --> --}}
{{-- <!-- <option value="NIAO" @if (old('office') == "NIAO") {{ 'selected' }} @endif>NIAO</option> --> --}}
<option value="KRAO" @if (old('office') == "KRAO") {{ 'selected' }} @endif>KRAO</option>
{{-- <!-- <option value="CIAO" @if (old('office') == "CIAO") {{ 'selected' }} @endif>CIAO</option> --> --}}
{{-- <!-- <option value="SIAO" @if (old('office') == "SIAO") {{ 'selected' }} @endif>SIAO</option> --> --}}

</select>

@endif

@if ($authuser->office == "CIAO")
<select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >

<option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.office')}}..</option>

{{-- <!-- <option value="CO-Erbil" @if (old('office') == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option> --> --}}
{{-- <!-- <option value="NIAO" @if (old('office') == "NIAO") {{ 'selected' }} @endif>NIAO</option> --> --}}
{{-- <!-- <option value="KRAO" @if (old('office') == "KRAO") {{ 'selected' }} @endif>KRAO</option> --> --}}
<option value="CIAO" @if (old('office') == "CIAO") {{ 'selected' }} @endif>CIAO</option>
{{-- <!-- <option value="SIAO" @if (old('office') == "SIAO") {{ 'selected' }} @endif>SIAO</option> --> --}}

</select>

@endif
@if ($authuser->office == "SIAO")
<select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >

<option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.office')}}..</option>

{{-- <!-- <option value="CO-Erbil" @if (old('office') == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option> --> --}}
{{-- <!-- <option value="NIAO" @if (old('office') == "NIAO") {{ 'selected' }} @endif>NIAO</option> --> --}}
{{-- <!-- <option value="KRAO" @if (old('office') == "KRAO") {{ 'selected' }} @endif>KRAO</option> --> --}}
{{-- <!-- <option value="CIAO" @if (old('office') == "CIAO") {{ 'selected' }} @endif>CIAO</option> --> --}}
<option value="SIAO" @if (old('office') == "SIAO") {{ 'selected' }} @endif>SIAO</option>

</select>

@endif
@if ($authuser->office == "CO-Erbil")
<select class="form-control form-outline" id="office" name="office" aria-label="Default select example" >

<option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.office')}}..</option>

<option value="CO-Erbil" @if (old('office') == "CO-Erbil") {{ 'selected' }} @endif>CO-Erbil</option>
<option value="NIAO" @if (old('office') == "NIAO") {{ 'selected' }} @endif>NIAO</option>
<option value="KRAO" @if (old('office') == "KRAO") {{ 'selected' }} @endif>KRAO</option>
<option value="CIAO" @if (old('office') == "CIAO") {{ 'selected' }} @endif>CIAO</option>
<option value="SIAO" @if (old('office') == "SIAO") {{ 'selected' }} @endif>SIAO</option>

</select>

@endif
                                        @if ($errors->has('office'))
                                                <span id="office-error" class="error text-danger" for="input-office">{{ $errors->first('office') }}</span>
                                               @endif
                                        </div>

                                        <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">{{__('createUser.department')}}</label> <input class="form-control form-outline" type="text" id="department"  value="{{ old('department') }}" name="department" placeholder="" > </div>

                                        <div class="form-group col-sm-6 flex-column d-flex {{ $errors->has('grade') ? ' has-danger' : '' }}"> <label class="dropdown form-control-label required px-1 {{ $errors->has('grade') ? ' is-invalid' : '' }}">{{__('createUser.grade')}}</label>
                                          
                                              <select class="form-control form-outline" id="grade" name="grade" aria-label="Default select example" >

                                              <option value selected disabled ="">{{__('createUser.choose')}} {{__('createUser.grade')}}..</option>

                                              <option value="1" @if (old('grade') == "1") {{ 'selected' }} @endif>1</option>
                                              <option value="2" @if (old('grade') == "2") {{ 'selected' }} @endif>2</option>
                                              <option value="3" @if (old('grade') == "3") {{ 'selected' }} @endif>3</option>
                                              <option value="4" @if (old('grade') == "4") {{ 'selected' }} @endif>4</option>
                                              <option value="5" @if (old('grade') == "5") {{ 'selected' }} @endif>5</option>
                                              <option value="6" @if (old('grade') == "6") {{ 'selected' }} @endif>6</option>
                                              <option value="7" @if (old('grade') == "7") {{ 'selected' }} @endif>7</option>
                                              <option value="8" @if (old('grade') == "8") {{ 'selected' }} @endif>8</option>
                                              <option value="9" @if (old('grade') == "9") {{ 'selected' }} @endif>9</option>
                                              <option value="10" @if (old('grade') == "10") {{ 'selected' }} @endif>10</option>
                                              <option value="11" @if (old('grade') == "11") {{ 'selected' }} @endif>11</option>
                                              <option value="12" @if (old('grade') == "12") {{ 'selected' }} @endif>12</option>
                                              <option value="13" @if (old('grade') == "13") {{ 'selected' }} @endif>13</option>
                                              </select>

                                          @if ($errors->has('grade'))
                                                <span id="grade-error" class="error text-danger" for="input-grade">{{ $errors->first('grade') }}</span>
                                               @endif
                                              </div>                    
                                      </div>
                                      <div class="row justify-content-between text-left">
                                        <div class="form-group {{ $errors->has('joined_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('createUser.joinDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('joined_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('joined_date') }}" name="joined_date" id="joined_date" placeholder="" >
                                            @if ($errors->has('joined_date'))
                                                <span id="joined_date-error" class="error text-danger" for="input-joined_date">{{ $errors->first('joined_date') }}</span>
                                               @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('employee_number') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label required px-1">{{__('createUser.employeeId')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('employee_number') ? ' is-invalid' : '' }}" type="text" value="{{ old('employee_number') }}" name= "employee_number" autocomplete="Employee ID" id="employee_number"  placeholder="" >
                                            @if ($errors->has('employee_number'))
                                                <span id="employee_number-error" class="error text-danger" for="input-employee_number">{{ $errors->first('employee_number') }}</span>
                                               @endif
                                        </div>
                                      </div>
                                      <div class="row justify-content-between text-left">
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label px-1">{{__('createUser.lineManager')}}</label><input class="form-control form-outline" type="text" list="FavoriteColor" id="color" placeholder="Choose Manager Name.."
                                            name="linemanager" value="{{ old('linemanager') }}" autocomplete="off">
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                     </div>

                                     <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label class="form-control-label px-1">{{__('createUser.email')}} <small>({{__('createUser.emailforgrades')}})</small></label>
                                               <input class="form-control form-outline {{ $errors->has('email') ? ' is-invalid' : '' }}"  type="email" id="email"  name="email" autocomplete="off" value="{{ old('email') }}" placeholder="" >
                                                @if ($errors->has('email'))
                                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                               @endif 
                                             </div>
                                     @php
                                $authuser = Auth::user();
                                @endphp
                                @if ($authuser->superadmin == "yes")
                                          <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label  px-1">{{__('createUser.hrAdmin')}} <small>({{__('createUser.permissionOnHrms')}})</small></label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="no" id="test1" checked>
                                            <label class="form-check-label" for="test1">
                                            {{__('createUser.notAdmin')}}
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="hradmin" Value="yes" id="test2" >
                                            <label class="form-check-label" for="test2">
                                              Admin
                                            </label>
                                          </div> 
                                        </div>
                                        @endif

                                        <div class="form-group {{ $errors->has('contract') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex"> <label class="form-control-label required px-1">{{__('createUser.contractType')}}</label> <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="National" id="national" @if (old('contract') == "National") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="national">
                                            {{__('createUser.NationalContract')}}
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="International" id="International" @if (old('contract') == "International") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="International">
                                            {{__('createUser.InternationalContract')}}
                                            </label>
                                          </div> 
                                          <div class="form-check">
                                            <input  class="btn-check" type="radio" name="contract" Value="NA" id="na" @if (old('contract') == "NA") {{ 'checked' }} @endif>
                                            <label class="form-check-label" for="na">
                                            {{__('createUser.notAvaillable')}}
                                            </label>
                                          </div> 
                                        </div>
                                       

                                      </div>
                                      <div class="row justify-content-between text-left">
                                         
                                           {{-- <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                              <label class="form-control-label required  px-1">{{__('createUser.password')}} <small>({{__('createUser.whenSigningUsingEmployeeId')}})</small></label>
                                               <div class="input-group">
                                                   <input class="form-control form-outline  {{ $errors->has('password') ? ' is-invalid' : '' }} "  type="password" readonly onfocus="this.removeAttribute('readonly');" id="password" autocomplete="off"
                                                   name="password" autocomplete="new-password" placeholder="">
                                                    @if ($errors->has('password'))
                                                <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                               @endif 
                                                   <div class="input-group-append">
                                                    <div class="input-group-text ">
                                                      <i class="fas fa-eye-slash" id="eye1"></i>
                                                    </div>
                                                  </div>
                                                </div>
                                                @if ($errors->has('password'))
                                              <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                             @endif
                                        </div>  --}}
                                      </div>
                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block btn-1">{{__('createUser.create')}}</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >{{__('createUser.cancel')}}</a> </div>
                                      </div>
                                  </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    
                </div>
                <br>
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

  setTimeout(function() {
    $("div.errorMsg").fadeOut('slow');
}, 7000); 

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
