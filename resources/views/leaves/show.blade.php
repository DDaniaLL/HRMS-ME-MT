@extends('layouts.app', ['activePage' => 'my-leaves', 'titlePage' => ('all leaves')])

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
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                      <div class="card-header card-header-primary">
                      
                        <h4 class="card-title "> <a href="{{ URL::previous() }}"> <i class="fas fa-arrow-alt-circle-left"></i> </a>   {{__('leaveShow.leaveDetails')}}</h4>
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
                            <strong>{{__('leaveShow.leaveId')}}: </strong> {{$leave->id}}
                                <br>
                                <strong>{{__('leaveShow.leaveStatus')}}: </strong> {{__("databaseLeaves.$leave->status")}}@if ($leave->status == "Pending LM Approval") - 
                                <small>{{$currentlm}}</small>
                              @endif
                                <br>
                                @php
                              $startdayname = Carbon\Carbon::parse($leave->start_date)->format('l');
                              $enddayname = Carbon\Carbon::parse($leave->end_date)->format('l');
                              @endphp
                                <strong>{{__('leaveShow.leaveStartDate')}}: </strong>{{__("databaseLeaves.$startdayname")}} {{$leave->start_date}}
                                <br>
                                <strong>{{__('leaveShow.leaveEndDate')}}: </strong>{{__("databaseLeaves.$enddayname")}} {{$leave->end_date}}
                              </div>
                              <div class="col">

                                <strong>{{__('leaveShow.leaveDays')}}: </strong> {{$leave->days}}
                                  <br>
                                  <strong>{{__('leaveShow.leaveHours')}}: </strong> {{$leave->hours}}
                                  <br>
                                  <strong>{{__('leaveShow.leaveType')}}: </strong> {{ __("databaseLeaves.{$leave->leavetype->name}") }}
                                  <br>
                                  <strong>{{__('leaveShow.leaveCreationDate')}}: </strong> {{$leave->created_at}}

                              </div>
                        </div>
                        {{-- <iframe src="{{url('/storage/files/0j7YmC2IIpwwkvLLhg23zidqXYRGwhYpSGNWZklb.pdf')}}" width="100%" height="600"></iframe> --}}
                      </div>
                    </div>
                    <div class="card">
                        <div class="card-header card-header-primary">
                          <h4 class="card-title ">{{__('leaveShow.leaveReason')}}</h4>
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
                                  <strong>{{$leave->reason}}</strong>
                                </div>

                          </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header card-header-primary">
                    {{-- <a href="/storage/files/{{$holiday->name}}.pdf" target="_blank">{{ $holiday->name }}</a> --}}
                  <h4 class="card-title ">
                    @php
                    if (isset($leave->path))
                    {
                        $variableee='1';

                    }

                    else
                    {
                        $variableee ='2';
                    }
                @endphp
                @if ($variableee=='1')

                <a href="/storage/leaves/{{basename($leave->path)}}" target="_blank">{{__('leaveShow.attachment')}}</a>
                @endif
                @if ($variableee == '2')
                {{__('leaveShow.noAttachment')}}
                @endif
                    </h4>
                  <p class="card-category"></p>
                </div>

    </div>

    <div class="card">
    <div class="card-header card-header-primary">
                          <h4 class="mr-2 card-title ">{{__('leaveShow.approvalWorlflowCurrentStatus')}}: <strong>{{__("databaseLeaves.$leave->status")}}</strong>@if ($leave->status == "Pending LM Approval") - 
                            <small>{{$currentlm}}</small>
                          @endif</h4>
                          
                          @php
                          $authuser = Auth::user();

                          if ($leave->user->linemanager == $authuser->name && $leave->status == "Pending LM Approval")
                          {
                            $showapproval = '1';
                          }
                          
                          elseif ($authuser->hradmin == "yes" && $authuser->office == $leave->user->office && $leave->status == "Pending HR Approval")
                          {
                            $showapproval = '2';
                          }

                          elseif ($authuser->hradmin == "yes" && $authuser->office == "CO-Erbil" && $leave->status == "Pending HR Approval")
                          {
                            $showapproval = '2';
                          }
                          
                          elseif ($authuser->hradmin == "yes" && $leave->status == "Approved")
                          {
                            $showapproval = '3';
                          }

                          elseif ($authuser->hradmin == "yes" && $leave->status == "Declined by LM")
                          {
                            $showapproval = '4';
                          }

                          else {
                            $showapproval = '0';
                          }
                          @endphp
                          @if ($showapproval == '1')

                          <button type="button" class="mx-1 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal1{{$leave->id}}"><i class="fas fa-check-square"></i> </button> <button type="button" class="mx-1 form-group btn btn-xs  btn-danger" data-toggle="modal" data-target="#myModal2{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button>
                          @endif
                          @if ($showapproval == '2')
                          <button type="button" class="mx-1 form-group btn btn-xs btn-success" data-toggle="modal" data-target="#myModal3{{$leave->id}}"><i class="fas fa-check-square"></i> </button> <button type="button" class="mx-1 form-group btn btn-xs  btn-danger" data-toggle="modal" data-target="#myModal4{{$leave->id}}"><i class="fas fa-minus-circle"></i> </button><button  type="button" class="mx-2 form-group btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal5{{$leave->id}}"><i class="fas fa-plus-square"></i> </button>
                          @endif
                          @if ($showapproval == '3')
                          <div class="col ml-3">
                    <div class="mr-2 text-right">
                     
                        


                                <a href="" role="button" data-toggle="modal" data-target="#myModal6{{$leave->id}}" class="btn btn-sm btn-outline-danger">{{__('showuser.delete')}}
                                <i class="fas fa-times-circle fa-lg"></i>
                                </a>

                            </b>
                                              
                    </div>
                </div>
                @endif
                @if ($showapproval == '4')
                          <div class="col ml-3">
                    <div class="mr-2 text-right">
                     
                        


                                <a href="" role="button" data-toggle="modal" data-target="#myModal7{{$leave->id}}" class="btn btn-sm btn-outline-warning">Revert back to LM
                                <i class="fas fa-backward"></i>
                                </a>

                            </b>
                                              
                    </div>
                </div>
                @endif
                        </div>
                        <div class="card-body">
                    
                          <div class="row">
                              <div class="col">
                              {{__('leaveShow.submittedBy')}}: <strong>{{$leave->user->name}}</strong>
                                  <br>
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.lineManager')}}: <strong>{{$leave->lmapprover}}</strong> -{{$leave->lmdate}}- "<i>{{$leave->lmcomment}}</i>"
                                  <br>
                                  @if ($leave->exapprover != null)
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.extra')}}: <strong>{{$leave->exapprover}}</strong> -{{$leave->exdate}}- "<i>{{$leave->excomment}}</i>"
                                  <br>
                                  @endif
                                  {{__('leaveShow.approved')}}/{{__('leaveShow.declined')}} {{__('leaveShow.by')}} {{__('leaveShow.hr')}}: <strong>{{$leave->hrapprover}}</strong> -{{$leave->hrdate}}- "<i>{{$leave->hrcomment}}</i>"
                                </div>

                          </div>
                          
                </div>
            </div>

            

<div id="myModal1{{$leave->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Approving leave: <strong>{{$leave->id}}</strong></p>
        <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
        <form method="POST" action="{{route('leaves.approved',$leave->id)}}" class="mb-0 text-center" >
        <div class="row justify-content-center text-center">
        <div class="form-group  col-sm-12 flex-column d-flex">
              <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
              <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

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


<div id="myModal2{{$leave->id}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body text-center">
        <p>Declining leave: <strong>{{$leave->id}}</strong></p>
        <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
        <form method="POST" action="{{route('leaves.declined',$leave->id)}}" class="mb-0 text-center" >
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

<div id="myModal3{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Approving leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.hrapproved',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                <label class="form-control-label px-1">{{__('createLeave.comment')}}</small></label>
                <input class="form-control form-outline" type="text" id="comment" autocomplete="off" name="comment" placeholder="Optional">

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


  <div id="myModal4{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Declining leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.hrdeclined',$leave->id)}}" class="mb-0 text-center" >
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


  <div id="myModal5{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Forwarding leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.forward',$leave->id)}}" class="mb-0 text-center" >
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

  <div id="myModal6{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Deleting leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.hrdelete',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                
                              <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>After deleting the leave, all days deducted will be added back to staff balance.</h5>
                                        </div>

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-danger" value="Delete">
            </div>
        </form>
        </div>
        <div class="modal-footer mt-0">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>

    </div>
  </div>

  <div id="myModal7{{$leave->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-body text-center">
          <p>Moving back to LM, the leave: <strong>{{$leave->id}}</strong></p>
          <p>Requested by: <strong>{{$leave->user->name}}</strong></p>
          <form method="POST" action="{{route('leaves.lmrevert',$leave->id)}}" class="mb-0 text-center" >
          <div class="row justify-content-center text-center">
          <div class="form-group  col-sm-12 flex-column d-flex">
                
                              <div class="row justify-content-center">
                                        <h5 style='border-radius: 7px; padding:5px; border:2px orange solid; font-size:17px; width:fit-content; width:-webkit-fit-content; width:-moz-fit-content;'>After moving the workflow back to Line Manager, the leave will be pending LM approval</h5>
                                        </div>

              </div>
              </div>

            {{ csrf_field() }}
          
            <div class="form-group">
                <input id="buttonSelector" type="submit" class="mb-0 mt-0 btn btn-warning" value="Revert back to LM">
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
