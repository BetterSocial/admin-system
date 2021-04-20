$(document).ready(function () {
    $('#addLogo').on('submit', function(e) {
        var id = $('#domainPageId').val();
        var firstUpload = $("#file").prop('files')[0];
        var formData = new FormData();
        formData.append('file', firstUpload);
        formData.append('id', id);
        Swal.fire({
            title: 'Please Wait !',
            html: 'data uploading',
            showCancelButton: false, // There won't be any cancel button
            showConfirmButton: false,// There won't be any confirm button       
            allowOutsideClick: false,
            onBeforeOpen: () => {
                Swal.showLoading()
            },
        });
        $.ajaxSetup({
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
        });
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            data:formData,
            contentType: false, 
            processData: false,
            url: '/domain/add-logo',
            success: function(data){
                console.log(data);
                if(data.success){
                    Swal.hideLoading()
                    return Swal.fire({
                        title: "Success!",
                        text: "Icon Uploaded",
                        type: "success"
                    }, function() {
                        window.location.href = "{{URL::to('/domain/index')}}"
                    });
                    
                }else{
                    Swal.hideLoading()
                    return Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,})
                }
            },
            error: function(data){
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.responseJSON.errors.file[0],})

            }
        });   
      });
});