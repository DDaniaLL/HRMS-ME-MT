@extends('layouts.app', ['activePage' => 'holidays', 'titlePage' => ('users create')])

@section('content')
  <div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title ">Holidays</h4>
                    <p class="card-category">Edit Holiday Calander</p>
                </div>
                    <div class="container py-5 h-100">
                      <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-10 col-xl-10">
                          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Holiday details</h3>
                              <form action="{{ route('admin.holidays.update', $holiday) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                  <div class="col-md-6 mb-6">
                                    <div class="form-outline">
                                      <input type="text" name="name" value="{{ $holiday->name }}" class="form-control form-control-lg" />
                                      <label class="form-label" >Name</label>
                                    </div>
                                  </div>
                                    <div class="col-md-6 mb-6">
                                      <div class="form-outline">
                                        <input type="text" name="desc" value="{{ $holiday->desc }}" class="form-control form-control-lg" />
                                        <label class="form-label" >Desc</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-6">
                                      <div class="form-outline">
                                        <input type="date" name="start_date" value="{{ $holiday->created_date }}" class="form-control form-control-lg" />
                                        <label class="form-label" >Start Date</label>
                                      </div>
                                    </div>
                                      <div class="col-md-6 mb-6">
                                        <div class="form-outline">
                                          <input type="date" name="end_date" value="{{ $holiday->lastupdate_date }}" class="form-control form-control-lg" />
                                          <label class="form-label" >End Date</label>
                                        </div>
                                      </div>
                                  </div>
                                <div class="row">
                                    <div class="form-outline">
                                        <input type="file" name="file" class="form-control">
                                      </div>
                                  </div>
                                  <br>
                                <div class="mt-4 pt-2">
                                  <input class="btn btn-primary btn-lg" type="submit" value="Add" />
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


    </div>
  </div>
@endsection
