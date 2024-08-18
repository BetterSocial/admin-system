@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
            <div class="row layout-top-spacing">
                <div id="basic" class="col-lg-12 layout-spacing">

                    <div class="mb-3">
                        <a href="{{ route('topic') }}">
                            <button type='button' class='btn btn-primary btn-md'>Back</button>
                        </a>
                    </div>
                    <h4><b>Create Topics</b></h4>
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="createTopic" class="simple-example" enctype="multipart/form-data"
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
                                        name="category" aria-label="Category">
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
                                        <input id="file" type="file"
                                            class="custom-file-container__custom-file__custom-file-input"
                                            accept="image/x-png" name="file">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1024" />
                                        <span class="custom-file-container__custom-file__custom-file-control"></span>
                                    </label>
                                    <div class="custom-file-container__image-preview"></div>
                                    <p id="imageDimensions" style="margin-top: 10px;">Dimensions: N/A</p>
                                </div>

                                <!-- Hidden input to store cropped image data -->
                                <input type="hidden" id="croppedImageData" name="cropped_image_data">

                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="cropImage" style="max-width: 100%;">
                    </div>
                    <div class="mt-3">
                        <h5>Resize Area:</h5>
                        <div class="form-group">
                            <label for="resizeWidth">Width:</label>
                            <input type="number" id="resizeWidth" class="form-control" value="150" min="150">
                        </div>
                        <div class="form-group">
                            <label for="resizeHeight">Height:</label>
                            <input type="number" id="resizeHeight" class="form-control" value="150" min="150">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="cropButton" class="btn btn-primary">Crop</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script>
        var firstUpload = new FileUploadWithPreview('myFirstImage')
    </script>
    <script>
        $(document).ready(function() {
            let cropper;
            let croppedCanvas;

            document.getElementById('file').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const image = document.getElementById('cropImage');
                        image.src = e.target.result;
                        $('#cropperModal').modal('show');
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#cropperModal').on('shown.bs.modal', function() {
                const image = document.getElementById('cropImage');
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Rasio 1:1 untuk icon
                    viewMode: 2,
                    autoCropArea: 1,
                    crop(event) {
                        // Sinkronisasi input width dan height dengan crop area yang sedang aktif
                        document.getElementById('resizeWidth').value = Math.round(event.detail
                            .width);
                        document.getElementById('resizeHeight').value = Math.round(event.detail
                            .height);

                        // Update dimensions real-time
                        document.getElementById('imageDimensions').textContent =
                            `Dimensions: ${Math.round(event.detail.width)}px x ${Math.round(event.detail.height)}px`;
                    }
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });


            // Update cropper ketika nilai width atau height diubah
            document.getElementById('resizeWidth').addEventListener('input', function() {
                const width = parseInt(this.value, 10);
                const height = document.getElementById('resizeHeight').value;
                cropper.setData({
                    width: width,
                    height: height
                });
            });

            document.getElementById('resizeHeight').addEventListener('input', function() {
                const height = parseInt(this.value, 10);
                const width = document.getElementById('resizeWidth').value;
                cropper.setData({
                    width: width,
                    height: height
                });
            });

            document.getElementById('cropButton').addEventListener('click', function() {
                if (cropper) {
                    croppedCanvas = cropper.getCroppedCanvas({
                        width: parseInt(document.getElementById('resizeWidth').value, 10),
                        height: parseInt(document.getElementById('resizeHeight').value, 10),
                    });

                    // Tampilkan hasil crop di preview
                    const croppedImagePreview = document.querySelector(
                        '.custom-file-container__image-preview');
                    croppedImagePreview.style.backgroundImage = `url(${croppedCanvas.toDataURL()})`;
                    croppedImagePreview.style.display = 'block';

                    // Simpan hasil crop ke input hidden untuk di-submit ke server
                    document.getElementById('croppedImageData').value = croppedCanvas.toDataURL();

                    // Close modal
                    $('#cropperModal').modal('hide');
                }
            });

            // Form submission logic
            $("#createTopic").on("submit", function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var category = $("#category").val();
                let sort = $("#sort").val();
                let croppedImageData = $("#croppedImageData").val();

                if (name == null || name == "") {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Name must be fill",
                    });
                }
                if (category == null || category == "") {
                    return Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Category must be fill",
                    });
                }

                var formData = new FormData();
                formData.append("name", name);
                formData.append("category", category);
                formData.append("sort", sort);
                formData.append("cropped_image_data", croppedImageData);

                Swal.fire({
                    title: "Please Wait !",
                    html: "Data uploading",
                    showCancelButton: false, // There won't be any cancel button
                    showConfirmButton: false, // There won't be any confirm button
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-Token": $("meta[name=csrf-token]").attr("content")
                    },
                });

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    contentType: false,
                    processData: false,
                    url: "{{ route('create.topics') }}",
                    success: function(data) {
                        console.log(data);
                        Swal.close();
                        if (data.status == "success") {
                            $("#createTopic")[0].reset();
                            $("#myFirstImage").val("");
                            return Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Topic Created",
                            });
                        } else {
                            return Swal.fire({
                                icon: "error",
                                title: "error",
                                text: data.message,
                            });
                        }
                    },
                    error: function(data, xhr, message) {
                        Swal.close();
                        console.log(data);
                        console.log(xhr);
                        console.log(message);
                        return Swal.fire({
                            icon: "error",
                            title: "Internal Server Error",
                            text: data.responseJSON.errors.file[0],
                        });
                    },
                });
            });

            document.getElementById('cropButton').addEventListener('click', function() {
                if (cropper) {
                    const cropData = cropper.getData(true); // Mendapatkan data crop dalam bentuk pixel asli

                    // Perbarui dimensi berdasarkan ukuran crop yang baru
                    document.getElementById('imageDimensions').textContent =
                        `Dimensions: ${Math.round(cropData.width)}px x ${Math.round(cropData.height)}px`;

                    croppedCanvas = cropper.getCroppedCanvas({
                        width: parseInt(document.getElementById('resizeWidth').value, 10),
                        height: parseInt(document.getElementById('resizeHeight').value, 10),
                    });

                    // Tampilkan hasil crop di preview
                    const croppedImagePreview = document.querySelector(
                        '.custom-file-container__image-preview');
                    croppedImagePreview.style.backgroundImage = `url(${croppedCanvas.toDataURL()})`;
                    croppedImagePreview.style.display = 'block';

                    // Simpan hasil crop ke input hidden untuk di-submit ke server
                    document.getElementById('croppedImageData').value = croppedCanvas.toDataURL();

                    // Close modal
                    $('#cropperModal').modal('hide');
                }
            });




        });
    </script>
@endpush
