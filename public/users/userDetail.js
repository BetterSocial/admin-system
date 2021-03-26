$(document).ready(function () {
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    var formData = new FormData();
    formData.append('user_id', id);
    Swal.fire({
        title: 'Please Wait !',
        html: 'Load Data',
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
        data:formData,
        contentType: false, 
        processData: false,
        dataType:'JSON',
        url: '/user-detail',
        success: function(data){
            
            $('#username').val(data.data.username);
            $('#profilePict').attr("src",data.data.profile_pic_path);
            $('#realName').val(data.data.real_name);
            $('#countryCode').val(data.data.country_code);
            $('#registeredAt').val(data.data.created_at);
            $('#lastActive').val(data.data.last_active_at);
            $('#status').val(data.data.status);
            Swal.close()

        },
        error:function(data){
            Swal.close();
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message,})
            
        }
        
    });   
})
    