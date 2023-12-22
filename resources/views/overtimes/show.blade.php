@extends('layouts.app', ['activePage' => 'overtime', 'titlePage' => ('overtime')])

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
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                        <h4 class="card-title "><a href="{{ URL::previous() }}"> <i class="fas fa-arrow-alt-circle-left"></i> </a>{{__('overtimeshow.overtimeDetails')}}</h4>
                        <p class="card-category"></p>
                      </div>
                      <div class="card-body">
                          {{-- <div class="row">
                              <div   div class="col-12 text-right">
                                <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                              </div>
                          </div> --}}
                        <div class="row">
                            <div class="col">
                                <strong>{{__('overtimeshow.overtimeId')}}: </strong> {{$overtime->id}}
                                <br>
                                <strong>{{__('overtimeshow.overtimeStatus')}}: </strong> {{__("databaseLeaves.$overtime->status")}}@if ($overtime->status == "Pending LM Approval") - 
                                <small>{{$currentlm}}</small>
                              @endif
                                <br>
                                @php
                              $dayname = Carbon\Carbon::parse($overtime->date)->format('l');
                              @endphp
                                <strong>{{__('overtimeshow.overtimeDate')}}: </strong>{{__("databaseLeaves.$dayname")}} {{$overtime->date}}
                                <br>
                                <strong>{{__('overtimeshow.overtimestarthour')}}: </strong> {{$overtime->start_hour}}
                                <br>
                                <strong>{{__('overtimeshow.overtimeendhour')}}: </strong> {{$overtime->end_hour}}
                              </div>
                              <div class="col">

                                <strong>{{__('overtimeshow.overtimeHours')}}: </strong> {{$overtime->hours}}
                                  <br>
                                  <strong>{{__('overtimeshow.overtimevalue')}}: </strong> {{$overtime->value}}
                                  <br>
                                  <strong>{{__('overtimeshow.overtimeType')}}: </strong> {{__("databaseLeaves.$overtime->type")}}
                                  <br>
                                  <strong>{{__('overtimeshow.overtimeCreationDate')}}: </strong> {{$overtime->created_at}}

                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('overtimeshow.overtimeReason')}}</h4>
                          <p class="card-category"></p>
                        </div>
                        <div class="card-body">
                            {{-- <div class="row">
                                <div   div class="col-12 text-right">
                                  <a href="#" class="btn btn-sm btn-primary">Add Holiday</a>
                                </div>
                            </div> --}}
                          <div class="row">
                              <div class="col">
                                  <strong>{{$overtime->reason}}</strong>
                                </div>

                          </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header card-header-primary">
                    {{-- <a href="/storage/files/{{$holiday->name}}.pdf" target="_blank">{{ $holiday->name }}</a> --}}
                  <h4 class="card-title ">
                    @php
                    if (isset($overtime->path))
                    {
                        $variableee='1';

                    }

                    else
                    {
                        $variableee ='2';
                    }
                @endphp
                @if ($variableee=='1')

                <a href="/storage/overtimes/{{basename($overtime->path)}}" target="_blank">{{__('overtimeshow.attachment')}}</a>
                @endif
                @if ($variableee == '2')
                {{__('overtimeshow.noAttachment')}}
                @endif
                    </h4>
                  <p class="card-category"></p>
                </div>

    </div>

    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="mr-2 card-title ">{{__('overtimeshow.approvalWorlflowCurrentStatus')}} <strong>{{__("databaseLeaves.$overtime->status")}}</strong>@if ($overtime->status == "Pending LM Approval") - 
                            <small>{{$currentlm}}</small>
                          @endif</h4>
                          @php
                          $authuser = Auth::user();

                          if ($overtime->user->linemanager == $authuser->name && $overtime->status == "Pending LM Approval")
                          {
                            $showapproval = '1';
                          }
                          
                          elseif ($authuser->hradmin == "yes" && $authuser->office == $overtime->user->office && $overtime->status == "Pending HR Approval")
                          {
                            $showapproval = '2';
                          }

                          elseif ($authuser->hradmin == "yes" && $authuser->office == "CO-Erbil" && $overtime->status == "Pending HR Approval")
                          {
                            $showapproval = '2';
                          }

                      

                          else {
                            $showapproval = '0';
                          }
                          @endphp
                          @if ($showapproval == '1')

                          <button type="button" class="mx-1 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal1{{$overtime->id}}"><i class="fas fa-check-square"></i> </button> <button type="button" class="mx-1 form-group btn btn-xs  btn-danger" data-toggle="modal" data-target="#myModal2{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button>
                          @endif
                          @if ($showapproval == '2')
                          <button type="button" class="mx-1 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal3{{$overtime->id}}"><i class="fas fa-check-square"></i> </button> <button type="button" class="mx-1 form-group btn btn-xs  btn-danger" data-toggle="modal" data-target="#myModal4{{$overtime->id}}"><i class="fas fa-minus-circle"></i> </button><button  type="button" class="mx-2 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal5{{$overtime->id}}"><i class="fas fa-plus-square"></i> </button>
                          @endif
                        
                        </div>
                        <div class="card-body">
                            
                          <div class="row">
                              <div class="col">
                              {{__('overtimeshow.submittedBy')}}: <strong>{{$overtime->user->name}}</strong>
                                  <br>
                                  {{__('overtimeshow.approved')}}/{{__('overtimeshow.declined')}} {{__('overtimeshow.by')}} {{__('overtimeshow.lineManager')}}: <strong>{{$overtime->lmapprover}}</strong> -{{$overtime->lmdate}}- "<i>{{$overtime->lmcomment}}</i>"
                                  <br>
                                  @if ($overtime->exapprover != null)
                                  {{__('overtimeshow.approved')}}/{{__('overtimeshow.declined')}} {{__('overtimeshow.by')}} {{__('overtimeshow.extra')}}: <strong>{{$overtime->exapprover}}</strong> -{{$overtime->exdate}}- "<i>{{$overtime->excomment}}</i>"
                                  <br>
                                  @endif
                                  {{__('overtimeshow.approved')}}/{{__('overtimeshow.declined')}} {{__('overtimeshow.by')}} {{__('overtimeshow.hr')}}: <strong>{{$overtime->hrapprover}}</strong> -{{$overtime->hrdate}}- "<i>{{$overtime->hrcomment}}</i>"
                                </div>
                                

                          </div>
                          <br>
                          {{-- <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> --> --}}
                </div>
            </div>

         

<div id="myModal1{{$overtime->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Approving overtime: <strong>{{$overtime->id}}</strong></p>
        <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
        <form method="POST" action="{{route('overtimes.approved',$overtime->id)}}" class="mb-0 text-center" >
        <div class="row justify-content-center text-center">
        <div class="form-group  col-sm-12 flex-column d-flex">
              <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
              <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">
              <br>
                {{-- <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> --> --}}
            </div>
            </div>

          {{ csrf_field() }}
        
          <div class="form-group">
              <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-success" value="Approve">
          </div>
      </form>
      </div>
      <div class="modal-footer mt-0">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>


<div id="myModal2{{$overtime->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Declining overtime: <strong>{{$overtime->id}}</strong></p>
        <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
        <form method="POST" action="{{route('overtimes.declined',$overtime->id)}}" class="mb-0 text-center" >
        <div class="row justify-content-center text-center">
        <div class="form-group  col-sm-12 flex-column d-flex">
              <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
              <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

            </div>
            </div>

          {{ csrf_field() }}
        
          <div class="form-group">
              <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-danger" value="Decline">
          </div>
      </form>
      </div>
      <div class="modal-footer mt-0">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>

<div id="myModal3{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Approving overtime: <strong>{{$overtime->id}}</strong></p>
          <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
          <form method="POST" action="{{route('overtimes.hrapproved',$overtime->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">
                <br>
                {{-- <!-- <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>{{__('createOvertime.note')}}</h5>
                                        </div> --> --}}
              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-success" value="Approve">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>


  <div id="myModal4{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Declining overtime: <strong>{{$overtime->id}}</strong></p>
          <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
          <form method="POST" action="{{route('overtimes.hrdeclined',$overtime->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-danger" value="Decline">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>


  <div id="myModal5{{$overtime->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Forwarding overtime: <strong>{{$overtime->id}}</strong></p>
          <p>Requested by: <strong>{{$overtime->user->name}}</strong></p>
          <form method="POST" action="{{route('overtimes.forward',$overtime->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.extra')}}</small></label>
                <input class="form-control form-outline" type="text" list="FavoriteColor" id="color" placeholder="Choose Staff Name.."
                                            name="extra" value="{{ old('extra') }}" autocomplete="off">
                                        <datalist id="FavoriteColor">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"> </option>
                                            @endforeach
                                        </datalist>

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-warning" value="Forward">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>

            {{-- <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Leaves - Taken</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">

                  <div class="row">
                      <div class="col">
                          <strong>Annual Leave:</strong> {{$balance1}}
                          <br>
                          <strong>Sick leave:</strong> {{$balance2}}

                        </div>

                  </div>
        </div>
    </div> --}}
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')

<script>

  $(document).ready(function() {
  

      $('form').submit(function(){
    $(this).find(':submit').attr('disabled','disabled');
  });
      $(document).on('click', '#buttonSelector', function () {
      $(this).addClass('disabled');
      
  });
  
  });
  
  </script>

@endpush
