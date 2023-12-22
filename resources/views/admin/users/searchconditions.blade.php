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


@php
$hruser = Auth::user();
@endphp
            <div class="container-fluid">

                <div class="card">
                    <div style=" background-color: #ffb678 !important;" class="card-header card-header-primary">
                    
                        <h4 class="card-title "> <i class="mr-2 fas fa-search"></i>{{__('advancedSearchuser.advancedSearchForStaffLeaves')}}</h4>
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">
                                    
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.users.search') }}" method="POST" target="__blank">
                                      @csrf
                                      <a class="text-danger" id="reset" href="">
                                      <i class="fas fa-sync-alt"></i> <strong>Reset filters</strong>
                                                    </a>
                                                    <br>
                                      <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchuser.staffName')}}</label>
                                        <input class="form-control form-outline {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" list="FavoriteColor" id="color" placeholder="Choose Staff Name.."
                                            name="name" value="{{ old('name') }}" autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                     </div>

                                    @if ($hruser->office == "CO-Erbil")    
                                     <div class="form-group col-sm-6 flex-column d-flex">
                                        <label  class=" form-control-label  px-1">{{__('advancedSearchuser.staffoffice')}}</label>
                                        <select
                                                    class="test form-control form-outline   selectpicker" data-size="5" data-style="btn btn-outline-secondary"
                                                    name="office[]" id="stafffoffice" type="text" multiple>
                                                   

                                                    <option value="CO-Erbil">CO-Erbil</option>
                                                    <option value="NIAO">NIAO</option>
                                                    <option value="KRAO">KRAO</option>
                                                    <option value="CIAO">CIAO</option>
                                                    <option value="SIAO">SIAO</option>


                                                </select>
                                     </div>
                                     @endif
                                     
                                      </div>


                                      <div class="row justify-content-between text-left">
                                      <div class="form-group col-sm-6 flex-column d-flex">
                                        <label  class=" form-control-label  px-1">{{__('advancedSearchuser.staffstatus')}}</label>
                                        <select
                                                    class="test form-control form-outline   selectpicker" data-size="3" data-style="btn btn-outline-secondary"
                                                    name="staffstatus[]" id="stafffstaff" type="text" multiple>
                                                  
                                                    <option value="active">Active</option>
                                                    <option value="suspended">Suspended</option>
                                                  
                                                </select>
                                     </div>


                                     
                                      </div>
<hr class="solid">
<style>
  hr.solid {
    border-top: 3px dashed #bbb;
  border-color: orange;
}
</style>



                              <div class="row justify-content-between text-left">
                                      <div class="form-group {{ $errors->has('linemanager') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchuser.linemanager')}}</label>
                                        <input class="form-control form-outline {{ $errors->has('linemanager') ? ' is-invalid' : '' }}" type="text" list="FavoriteColorlm" id="colorlm" placeholder="Choose Line Manger Name.."
                                            name="linemanager" value="{{ old('linemanager') }}" autocomplete="off">
                                            @if ($errors->has('linemanager'))
                                                <span id="linemanager-error" class="error text-danger" for="input-linemanager">{{ $errors->first('linemanager') }}</span>
                                               @endif
                                        <datalist id="FavoriteColorlm">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>
                                     </div>

                                    
                                     
                                      </div>

<hr class="solid">

                                      <div class="row justify-content-between text-left">
                                      <div class=" form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                        <label class="form-control-label  px-1">{{__('advancedSearchuser.leavetype')}}</label>
                                        <select
                                                    class="form-control form-outline   selectpicker" data-size="7" data-style="btn btn-outline-secondary"
                                                    name="contract[]" id="contract" type="text" multiple>
                                                   

                                                    <option value="National">{{__('createUser.NationalContract')}}</option>
                                                    <option value="International">{{__('createUser.InternationalContract')}}</option>
                                                    <option value="NA">{{__('createUser.notAvaillable')}}</option>
                                                    


                                                </select>
                                     </div>

                                     
                                     
                                     
                                      </div>
                                      



                              
                                      <div class="row justify-content-between text-left">
                                        <div  class="  form-group {{ $errors->has('start_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-1">{{__('advancedSearchuser.leaveStartDate')}}</label>
                                            <input class="form-control form-outline {{ $errors->has('start_date') ? ' is-invalid' : '' }}" type="date" value="{{ old('start_date') }}" name="start_date" id="start_date" placeholder="" >
                                            @if ($errors->has('start_date'))
                                                <span id="start_date-error" class="error text-danger" for="input-start_date">{{ $errors->first('start_date') }}</span>
                                               @endif
                                        </div>
                                    
                                      </div>


                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" name="action" value="view" class="btn bg-gradient-primary btn-block">{{__('advancedSearchuser.view')}}</button> </div>
                                          <div class="form-group col-sm-3"> <button type="submit" name="action" value="excel" class="btn btn-secondary btn-block">{{__('advancedSearchuser.excel')}}</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >{{__('advancedSearchuser.cancel')}}</a> </div>
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
<script src="{{ asset('select/js/bootstrap-select.min.js')}}"></script>
<script>

$(document).ready(function() {

  $('#reset').hide();
  
  $("input, select").change(function(){
    $('#reset').show();
    
});
    

  $('#color').on('change',function(){

    
if ($('#color').val().length !== 0)
{
  $(".test").prop('disabled',true);
  $(".test").selectpicker('deselectAll');
  $(".test").css("background-color", "#d3d3d3");
  $("#colorlm").prop('disabled',true);
  $("#colorlm").val("");

}
else if ($('#color').val().length == 0) {
  $(".test").prop('disabled',false);
  $(".test").css("background-color", "#FFFFFF");
  $("#colorlm").prop('disabled',false);
}



  

  });

  $('#colorlm').on('change',function(){


    if ($('#colorlm').val().length !== 0)
{
  $(".test").prop('disabled',true);
  $(".test").selectpicker('deselectAll');
  $(".test").css("background-color", "#d3d3d3");
  $("#color").prop('disabled',true);
  $("#color").val("");
}


else if ($('#colorlm').val().length == 0) {
  $(".test").prop('disabled',false);
  $(".test").css("background-color", "#FFFFFF");
  $("#color").prop('disabled',false);
}

  });

});
</script>

@endpush
