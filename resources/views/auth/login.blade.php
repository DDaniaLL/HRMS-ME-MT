@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Material Dashboard')])

@section('content')
    <div class="container" style="height: auto;">
        <div class="row align-items-center">

      <!-- /.login-logo -->
      <div style = "background-color: #ffffffbd; border-top: 3px solid #007bff;"class="card card-outline card-primary col-lg-4 col-md-6 col-sm-8 ml-2rem">
     
        <div class="card-header text-center">
          <p class="h1 mb-0" style="font-size:2.3rem;"> <img class="mb-0 ml-0" src="{{url('/hr360-3-noBG.png')}}"  alt="" style=" width:150px;height:50px;"></p>
          @if (session('success'))
          <br>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        </div>
        <div class="card-body text-center">
          
        {{-- <p class="h1 mb-0" style="font-size:2.3rem;"> <img class="mb-0 ml-0" src="{{url('/okta.png')}}"  alt="" style=" width:60px;height:20px;"></p> --}}
           {{-- <p class="login-box-msg pr-0 pb-3 pl-0">Sign in to start your session</p> --}}
  
         
            <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="bmd-form-group{{ $errors->has('employee_number') ? ' has' : '' }}">
                <div class="input-group mb-3">
                  <input type="text" name="employee_number"  class="form-control"
                    placeholder="{{ __('Employee Number') }}" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <i class="fas fa-id-badge"></i>
                      
                    </div>
                  </div>
                </div>
                
            </div>



            <div class="input-group mb-2">
              <input type="password" name="password" class="form-control pwd" placeholder="Password" required>


              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">
             
                <div class="container ">
                    <div class="check-primary text-left  pwd">
                      <input type="checkbox" class="reveal">
                      <label>
                        Show password
                      </label>
                      
                    </div>
                
                </div>
     
            </div>
            

                        
          
              
              <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn-1 mb-2">Sign in</button>
                  </div>
              </div>
              
          </form>
          

          
    @if($errors->any())
            <div class="alert " style="color:red; font-weight:bold; padding-bottom: 0.2rem;"  >{{$errors->first()}}</></div>
@endif

           <div class="social-auth-links text-center ">
            <a href="{{ route('login-okta') }}" id="btn-1"class="btn-lg btn-block btn-outline-primary">
              <i class="fab fa-faecebook"></i>Sign in with Okta
              <br> تسجيل الدخول باستخدام الأوكتا
            </a>
            
        
          </div> 
          {{-- <!-- /.social-auth-links

        </div>
        <!-- /.card-body --> --}}
      </div>
      <!-- /.card -->

      <style>
/* .btn-1 {
  border: none;
  width: 100%;
  height: 100%;
  color: white;
  background-color: #007bff;
  border-radius: 3px;
box-shadow: inset 0 0 0 0 #FF7602;
transition: ease-out 5s;

}
.btn-1.activate {
  box-shadow: inset 500px 0 0 0 #FF7602;
} */


#btn-1 {
  border: none;
  width: 100%;
  height: 100%;
  color: white;
  background-color: #007bff;
  border-radius: 3px;
box-shadow: inset 0 0 0 0 #FF7602;
transition: ease-out 5s;

}
#btn-1.activate {
  box-shadow: inset 500px 0 0 0 #FF7602;
}

          

          </style>



</div>
</div>









@endsection

@push('scripts')

<script>
  $(document).ready(function() {

    $(document).on('click', '#btn-1', function () {
$(this).addClass('activate');

});

$(document).on('click', '#buttonSelector', function () {
$(this).addClass('disabled');
});
$('form').submit(function(){
  $(this).find(':submit').attr('disabled','disabled');
});
});
  $(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
</script>

@endpush

