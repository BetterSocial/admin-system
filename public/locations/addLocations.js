$(document).ready(function () {
    $('#createLocation').on('submit', function(e) {
        var country = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        var neighborhood = $('#neighborhood').val();
        var zip = $('#zip').val();
        var location_level = $('#location_level').val();

        /*
         *  Validation
         */
        if( country == null || country === '') {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Country must be filled'})
        }

        if( zip != null && zip !== '') {
            if( neighborhood == null || neighborhood === '') {
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Neighborhood must be filled if Zip Code is filled'})
            }
        }

        if( neighborhood != null && neighborhood !== '') {
            if( city == null || city === '') {
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'City must be filled if Neighborhood is filled'})
            }
        }

        if( city != null && city !== '') {
            if( state == null || state === '') {
                return Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'State must be filled if City is filled'})
            }
        }



        var formData = new FormData();
        formData.append('country', country);
        formData.append('state', state);
        formData.append('city', city);
        formData.append('neighborhood', neighborhood);
        formData.append('zip', zip);
        formData.append('location_level', location_level);

        Swal.fire({
            title: 'Please Stand By',
            html: 'new location is gonna created soon...',
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
            url: '/locations/add',
            success: function(data){
                        console.log(data);
                if(data.success){
                    $("#createLocation")[0].reset();
                    Swal.hideLoading()
                    return Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'New Location Created',})
                    
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
