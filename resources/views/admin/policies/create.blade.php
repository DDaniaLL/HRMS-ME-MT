@extends('layouts.app', ['activePage' => 'policies', 'titlePage' => ('users create')])

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
                        <h4 class="card-title ">{{__('createHrPolicy.addPolicies')}}</h4>
                     </div>

                        <div class="card-body table-responsive-md">
                            <div class="container py-3 h-100">
                              <div class="row justify-content-center align-items-center h-100">
                                <div class="col-12 col-lg-10 col-xl-10">
                                  <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                    <div class="card-body p-4 p-md-5">
                                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">{{__('createHrPolicy.policyDetails')}}</h3>
                                      <form action="{{ route('admin.policies.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf




                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">{{__('createHrPolicy.name')}}</label>
                                                 <input class="form-control form-outline  {{ $errors->has('name') ? ' is-invalid' : '' }} " type="text" id="name"  name="name" placeholder="">
                                                 @if ($errors->has('name'))
                                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                                               @endif
                                                </div>
                                            <div class="form-group  {{ $errors->has('desc') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label px-1">{{__('createHrPolicy.description')}}</label>
                                                 <input class="form-control form-outline {{ $errors->has('desc') ? ' is-invalid' : '' }}" type="text" name="desc" id="desc" placeholder="" >
                                                 @if ($errors->has('desc'))
                                                 <span id="desc-error" class="error text-danger" for="input-desc">{{ $errors->first('desc') }}</span>
                                                @endif
                                                </div>
                                        </div>



                                        <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('created_date') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">{{__('createHrPolicy.createdDate')}}</label>
                                                 <input class="form-control form-outline  {{ $errors->has('created_date') ? ' is-invalid' : '' }} " type="date" id="created_date"  name="created_date" placeholder="">
                                                 @if ($errors->has('created_date'))
                                                <span id="created_date-error" class="error text-danger" for="input-created_date">{{ $errors->first('created_date') }}</span>
                                               @endif
                                                </div>
                                            <div class="form-group  {{ $errors->has('lastupdate_date') ? ' has-danger' : '' }}  col-sm-6 flex-column d-flex">
                                                <label class="form-control-label required px-1">{{__('createHrPolicy.lastUpdate')}}</label>
                                                 <input class="form-control form-outline {{ $errors->has('lastupdate_date') ? ' is-invalid' : '' }}" type="date" name="lastupdate_date" id="lastupdate_date" placeholder="" >
                                                 @if ($errors->has('lastupdate_date'))
                                                 <span id="lastupdate_date-error" class="error text-danger" for="input-lastupdate_date">{{ $errors->first('lastupdate_date') }}</span>
                                                @endif
                                                </div>
                                        </div>





                                       
                                          <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">{{__('createHrPolicy.file')}} <small>(PDF only)</small></label>
                                                 <input class="form-control-file form-outline  {{ $errors->has('file') ? ' is-invalid' : '' }} " type="file" id="file"  name="file">
                                                 @if ($errors->has('file'))
                                                <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                               @endif
                                                </div>
                                        </div>


                                          <br>


                                        <div class="row justify-content-center">
                                            <div class="form-group col-sm-2"> <button type="submit" class="btn bg-gradient-primary btn-block">Add</button> </div>
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

});

</script>

@endpush
