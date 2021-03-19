$(document).ready(function () {
    $('#createTopic').on('submit', function(e) {
        var name = $('#name').val();
        var category = $('#category').val();
        if(name == null || name == ''){
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Name must be fill',})

        }
        if(category == null || category == ''){
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'category must be fill',})

        }
        var firstUpload = $("#file").prop('files')[0];
        console.log(firstUpload);
        var formData = new FormData();
        formData.append('file', firstUpload);
        formData.append('name', name);
        formData.append('category', category);
        $.ajaxSetup({
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
        });
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            data:formData,
            contentType: false, 
            processData: false,
            url: '/add/topics',
            success: function(data){
                console.log(data);
                if(data.status == 'success'){
                    return Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Topid Created',})
                    
                }else{
                    return Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something Wrong..',})
                }
            },
            error: function(data){
                console.log(data);
            }
        });   
      });


    

});