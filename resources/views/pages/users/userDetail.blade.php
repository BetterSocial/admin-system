@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <a href="/view-users"><button type='button' class='btn btn-primary btn-md'>Back</button></a>
                    <h2><b>Detail Users</b></h2>
                        
                        <div class="widget-content widget-content-area br-6">
     
                                    <form id="detail" class="simple-example" enctype="multipart/form-data" action="javascript:void(0);" method="POST">
                                    <div class="input-group mb-12">
                                        <img src="" id='profilePict' width="150px" height="120px" alt="">
                                    </div>
                                    </br></br>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label>Username</label>
                                        </div>
                                        <input id="username" type="text" class="form-control"  disabled>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Real Name</label>
                                        </div>
                                        <input type="text" id="realName" class="form-control"  disabled>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Country Code</label>
                                        </div>
                                        <input type="text" id="countryCode" class="form-control"   disabled>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Registered At</label>
                                        </div>
                                        <input type="text" id="registeredAt" class="form-control"  disabled>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Last Active At</label>
                                        </div>
                                        <input type="text" id="lastActive" class="form-control"  disabled>
                                    </div>
                                    
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label >Status</label>
                                        </div>
                                        <input type="text" id="status" class="form-control"   disabled>
                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection