$(document).ready(function () {
    console.log("MASUUKKK");
    var datatableLocations = $('#tableLocations').DataTable( {
        "searching": false,
        "stateSave"	: true,
        "serverSide"	: true,
        "processing": true,
        "language": {
            'loadingRecords': '</br></br></br></br>;',
            'processing': 'Loading...',
            "emptyTable":     "No Data Locations"
        }, 
        "ajax": {
            url			: '/locations/data',
            type		: 'POST',
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
            data 		: function ( d ) {
                d.neighborhood = $('#neighborhood').val();
                d.city = $('#city').val();
                d.state = $('#state').val();
                d.country = $('#country').val();

            },
        },
        columns		: [
            {
                "data" : 'location_id',
                "visible": false,
            },
            {
                "data" : 'zip',
                "className" : 'menufilter textfilter',
            },
            {
                "data" : 'neighborhood',
                "className" : 'menufilter textfilter',
            },
            {
                "data" :'city',
                "className" : 'menufilter textfilter',
            },
            {
                "data" : 'state',
                "className" : 'menufilter textfilter',
            },
            {
                "data" :'country',
                "className" : 'menufilter textfilter',
            },
            {
                "data" : 'location_level',
                "className" : 'menufilter textfilter',
            },
            // {
            //     "data" :'status',
            //     "visible": false,
            // },
            {
                "data" : 'location_icon',
                "orderable":false,
                render : function(data, type, row) {
                    if(data != "" || data !=" " || data != null){
                        if(data == 'City'){
                            return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/city-icon_oyltzy.png" width="30" height="30" />';
                        }

                        if(data == 'Neighborhood'){
                            return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/neighboorhod_iwvmaf.png" width="30" height="30" />';
                        }

                        if(data == 'State'){
                            return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/state_uyxckp.png" width="30" height="30" />';
                        }

                        //TODO  icon Country
                    }

                },
                defaultContent: "No Icon",
            },
            // {
            //     "data" :'created_at',
            //     "className" : 'menufilter textfilter',
            // },
            // {
            //     "data" :'updated_at',
            //     "className" : 'menufilter textfilter',
            // },
            // {
            //     "data" : 'followers',
            //     render : function(data, type, row) {
            //         return "<a href='http://www.facebook.com'>#Followers</a>";
            //     }
            // },
            {
                "data" : "action",
                "orderable" : false,
                render : function(data, type, row) {
                    return "<div class='btn btn-xs btn-danger no-margin-action skeyF1' data-toggle='tooltip' data-placement='bottom' title='CheckBox' onclick='check()' data-tipe='header'><i class='fa fa-check'></i></div>";
                }
            }
        ],
    });

    $('#search').on('submit', function(e) {
        datatableLocations.draw();
        e.preventDefault();
    });

});
