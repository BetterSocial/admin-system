@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row layout-top-spacing">
                <div id="basic" class="col-lg-12 layout-spacing">
                    <h4><b>Create Topics</b></h4>
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="" class="simple-example" enctype="multipart/form-data"
                                action="{{ route('create.topics') }}" method="POST">
                                @csrf
                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Name</label>
                                    </div>
                                    <input id="name" type="text" class="form-control" placeholder="Name"
                                        name="name" aria-label="Name" required>
                                </div>

                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Category</label>
                                    </div>
                                    <input type="text" id="category" class="form-control" placeholder="Category"
                                        name="category" aria-label="Category" required>
                                </div>
                                <div class="input-group mb-5">
                                    <div class="col-md-2">
                                        <label>Sort</label>
                                    </div>
                                    <input type="text" id="sort" class="form-control" placeholder="0"
                                        aria-label="sort" name="sort" required>
                                    <span id="sort-error" style="color: red;"></span>
                                </div>


                                <div class="custom-file-container" data-upload-id="myFirstImage">
                                    <label>Icon <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                            title="Clear Image">x</a></label>
                                    <label class="custom-file-container__custom-file">
                                        <input id=file type="file"
                                            class="custom-file-container__custom-file__custom-file-input"
                                            accept="image/x-png">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
