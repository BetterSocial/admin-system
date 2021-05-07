$(document).ready(function () {

    var datatble =$('#tableNews').DataTable( {
      "searching": false,
      "stateSave"	: true,
      "lengthMenu": [ 50, 100, 250],
      "pageLength":50,
      "language": {
        'loadingRecords': '</br></br></br></br>;',
        'processing': 'Loading...',
        "emptyTable":     "No News Link"
        }, 
      "serverSide"	: true,
      "ajax": {
        url			: '/news/data',
        type		: 'POST',
        headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
                  data 		: function ( d ) {
              
              d.siteName = $('#siteName').val();
              d.title = $('#title').val();
              d.keyword = $('#keyword').val();
          },
        },
        columns		: [
            {
                
                "data" : 'news_link_id',
                "visible": false,
            },
            {
                "data" : 'news_url',
                "orderable" :true,
                render : function(data, type, row) {
                  return " <a href="+row.news_url +"> <button type='button' class='btn btn-primary'>Open Page</button> </a>"
      
                }    
               
            },
            {
                "data" : 'domain_name',
                "orderable":true,
            },
            {
                "data" : 'site_name',
                "orderable":true,
            },
            {
                "data" : 'title',
                "orderable":true,
            
            },
            
            {
                "data" : 'author',
                "orderable":true,
                
            },
            {
                "data" : 'keyword',
                "orderable":true,
                
            },
            {
                "data" : 'created_at',
                "orderable":true,
                
            },
            
        ],
      
    } );
  
    $('#search').on('submit', function(e) {
        datatble.draw();
      e.preventDefault();
    });
  
  });
  




  
  
  
