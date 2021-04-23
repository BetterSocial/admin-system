@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <a href="/polling/index"><button type='button' class='btn btn-primary btn-md'>Back</button></a>
                    <h2><b>Polling Detail</b></h2>
                        
                        <div class="widget-content widget-content-area br-6">
     
                                    <form id="detail" class="simple-example" enctype="multipart/form-data" action="javascript:void(0);" method="POST">
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label>Username</label>
                                        </div>
                                        <input id="username" type="text" class="form-control"  value="{{$data->username}}" disabled>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Question</label>
                                        </div>
                                        <input type="text" id="realName" class="form-control" value="{{$data->question}}"  disabled>
                                    </div>
                                    
                                    @foreach ($dataOption as  $key => $option)
                                        <div class="input-group mb-5">
                                            <div class="col-md-2">
                                                <label >Option {{$key+1}}</label>
                                            </div>
                                            <div>
                                                <div class="input-group mb-5">
                                                    <input type="text" class="form-control" value="{{$option->option}}"  disabled>
                                                    <div class="col-md-2">
                                                        <label >Score Polling</label>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{$option->counter}}"  disabled>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection