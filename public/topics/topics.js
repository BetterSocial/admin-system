$(document).ready(function () {

  var datatble =$('#tableTopics').DataTable( {
    "searching": false,
    "stateSave"	: true,
    "processing": true,
    "language": {
      'processing': 'Loading...',
      "emptyTable":     "No Data Topics"
    }, 
    "serverSide"	: true,
    "ajax": {
      url			: '/topics/data',
      type		: 'POST',
      headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
				data 		: function ( d ) {
            
            d.name = $('#name').val();
            d.category = $('#category').val();
        },
      },
      columns		: [
        {
          
          "data" : 'topic_id',
          "visible": false,
        },
        {
          "data" : 'name',
          "className" : 'menufilter textfilter',
        },
        {
          "data" : 'icon_path',
          "orderable":false,
          render : function(data, type, row) {
            if(data != "" || data !=" " || data != null){
              return '<img src="'+data+'" width="30" height="20" />';
            }
           
          },
          defaultContent: "No Icon",
        },
        {
          "data" : 'categories',
          "className" : 'menufilter textfilter',
        },
        {
          "data" :'created_at',
          "className" : 'menufilter textfilter',
        
        },
        {
          "data" : 'followers',
          render : function(data, type, row) {
            return " <a href='/follow-topics?topic_id="+row.topic_id +"'> <button type='button' class='btn btn-primary'>#Followers</button> </a>"

          }    
        },
        {
          "data" : "action",
					"orderable" : false,
			    	render : function(data, type, row) {
              return " <a href='http://www.facebook.com'> <button type='button' class='btn btn-primary'>Show</button> </a>"
			    	}
        }
			],
    
  } );

  $('#search').on('submit', function(e) {
    datatble.draw();
    e.preventDefault();
  });

  

});



