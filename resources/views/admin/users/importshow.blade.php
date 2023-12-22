@extends('layouts.app', ['activePage' => 'allstaffleaves', 'titlePage' => ('users create')])

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
                    
                        <h4 class="card-title "> <i class="mr-2 fas fa-file-pdf"></i>Create a report for staff leaves</h4>
                      </div>

                    <div class="card-body table-responsive-md">
                        <div class="container py-3 h-100">
                            <div class="row justify-content-center align-items-center h-100">
                              <div class="col-12 col-lg-10 col-xl-10">
                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                  <div class="card-body p-4 p-md-5">

                                  @if (session('status'))
                                  <div class="alert alert-success" role = "alert">
                                    {{$session('status')}}
                                  </div>
                                    @endif
                                  <form class="form-outline" autocomplete="off" action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" target="__blank">
                                      @csrf

                                      
                              
                                      <div class="row justify-content-between text-left">
                                            <div class="form-group {{ $errors->has('file') ? ' has-danger' : '' }} col-sm-6 flex-column d-flex">
                                                 <label class="form-control-label required px-1">File <small>(PDF only)</small></label>
                                                 <input class="form-control-file form-outline  {{ $errors->has('file') ? ' is-invalid' : '' }} " type="file" id="file"  name="file">
                                                 @if ($errors->has('file'))
                                                <span id="file-error" class="error text-danger" for="input-file">{{ $errors->first('file') }}</span>
                                               @endif
                                                </div>
                                        </div>


                                      {{-- MUST ADD requirepd for radio check --}}
                                       <br>
                                      <div class="row justify-content-center">
                                          <div class="form-group col-sm-3"> <button type="submit" class="btn bg-gradient-primary btn-block">submit</button> </div>
                                          <div class="form-group col-sm-3"> <a class="btn btn-outline-danger" href="{{route('admin.users.index')}}" >Cancel</a> </div>
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
