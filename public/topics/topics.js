$(document).ready(function () {
  console.log("MASKKK");

  var datatble =$('#tableTopics').DataTable( {
    "searching": false,
    "dom" 		: 'lrtp',
    "stateSave"	: true,
    "language": {
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
            console.log(d);
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
          render : function(data, type, row) {
            console.log(data);
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
            return " <div class='btn btn-warning > <a href='http://www.facebook.com'>#Followers</a></div>";
          }    
        },
        {
          "data" : "action",
					"orderable" : false,
			    	render : function(data, type, row) {
                  return "<div class='btn btn-xs btn-danger no-margin-action skeyF1' data-toggle='tooltip' data-placement='bottom' title='CheckBox' onclick='check()' data-tipe='header'><i class='fa fa-check'></i></div>";          
			    	}
        }
			],
    
  } );

  $('#search').on('submit', function(e) {
    datatble.draw();
    e.preventDefault();
  });

  

});



