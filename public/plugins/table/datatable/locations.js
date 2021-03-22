$(document).ready(function () {
    console.log("MASUUKKK");
    $('#tableLocations').DataTable( {
        "searching": false,
        "dom" 		: 'lrtp',
        "stateSave"	: true,
        "serverSide"	: true,
        "ajax": {
            url			: '/locations/data',
            type		: 'POST',
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
            data 		: function ( d ) {
                console.log("ini parameter");
                console.log(d);
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
                "data" : 'slug_name',
                "className" : 'menufilter textfilter',
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
    } );
});
