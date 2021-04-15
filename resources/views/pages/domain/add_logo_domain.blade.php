@extends('layouts.app')

@section('content')

<div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                            <a href="/domain/index"><button type='button' class='btn btn-primary btn-md'>Back</button></a>
                            <br><br>
                            <h4><b>Add Logo For Domain</b></h4>
                            <div class="widget-content widget-content-area br-6">
                                    <form id="addLogo" class="simple-example" enctype="multipart/form-data" action="javascript:void(0);" method="POST">
                                    <input type="text" id="domainPageId" value="{{$data->domain_page_id}}" hidden></label>
                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label>Domain Name</label>
                                        </div>
                                        <input id="name" type="text" class="form-control" placeholder="Name" aria-label="Name" value="{{$data->domain_name}}" readonly>
                                    </div>

                                    <div class="input-group mb-5">
                                        <div class="col-md-2">
                                            <label>Domain Short Description</label>
                                        </div>
                                        <textarea class="form-control" aria-label="With textarea" readonly>{{$data->short_description}}</textarea>
                                    </div>

                                    <div class="custom-file-container" data-upload-id="myFirstImage">
                                        <label>Add Logo <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input id=file type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/x-png">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Logo</button>    
                                    </form>
                
                            </div>
                        </div>
                </div>
            </div>
@endsection