$(document).ready(function () {
    var id = $('#topicId').val();
            var datatble =$('#tableUsers').DataTable( {
                "searching": false,
                "processing": true,
                "stateSave"	: true,
                "lengthMenu": [ 50, 100, 250],
                "pageLength":50,
                "language": {
                    'loadingRecords': '</br></br></br></br>;',
                    'processing': 'Loading...',
                    "emptyTable":     "No User Follow This Topic"
                }, 
                "serverSide"	: true,
                "ajax": {
                  url			: '/user/topic',
                  type		: 'POST',
                  headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
                            data 		: function ( d ) {
                        
                        d.topic_id = id
                    },
                  },
                  columns		: [
                        {
                    
                            "data" : 'user_id',
                            "visible": false,
                        },
                        {
                            "data" : 'username',
                            "className" : 'menufilter textfilter',
                        },
                        {
                            "data" : 'real_name',
                            "className" : 'menufilter textfilter',
                        },
                        {
                            "data" : 'country_code',
                            "orderable":true,
                        },
                        {
                            "data" : 'created_at',
                            "orderable":true,
                        },
                    
                    ],
                
              } );   
          
});