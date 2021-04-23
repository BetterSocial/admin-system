var datatable;
$(document).ready(function () {
    console.log("SASASASAS")

  datatable=$('#tableDomain').DataTable( {
    "searching": false,
    "stateSave"	: true,
    "processing": true,
    "language": {
      'processing': 'Loading...',
      "emptyTable":     "No Data Domain"
    }, 
    "serverSide"	: true,
    "ajax": {
      url			: '/domain/data',
      type		: 'POST',
      headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
				data 		: function ( d ) {
            
            d.domainName = $('#domainName').val();
        },
      },
      columns		: [
        {
            "data" : 'action',
            "orderable":false,
            render : function(data, type, row) {
              return " <a href='/domain/form-logo?domain_page_id="+row.domain_page_id +"'> <button type='button' class='btn btn-primary'>Add Logo</button> </a>"
  
            }    
        },
        {
          
          "data" : 'domain_page_id',
          "visible": false,
        },
        {
          "data" : 'domain_name',
          "className" : 'menufilter textfilter',
        },
        {
          "data" : 'logo',
          "orderable":false,
          render : function(data, type, row) {
            if(data != "" || data !=" " || data != null){
              return '<img src="'+data+'" width="30" height="20" />';
            }
           
          },
          defaultContent: "No Icon",
        },
        {
            "data" : 'short_description',
            "className" : 'menufilter textfilter',
        },
        {
          "data" :'created_at',
          "className" : 'menufilter textfilter',
        
        },
       
       
		],
    
  } );

  $('#search').on('submit', function(e) {
    datatable.draw();
    e.preventDefault();
  });
  

});


// function showTopic(topicId){
//   var formData = new FormData();
//   formData.append('topic_id', topicId);
 
//   $.ajaxSetup({
//     headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
//   });
//   $.ajax({
//       type: 'POST',
//       dataType:'JSON',
//       data:formData,
//       contentType: false, 
//       processData: false,
//       url: '/show/topics',
//       success: function(data){
//           console.log(data);
//           if(data.success){
//               datatble.ajax.reload(null,false);
              
//           }else{
              
//               return Swal.fire({
//                   icon: 'error',
//                   title: 'Oops...',
//                   text: data.message,})
//           }
//       },
//       error: function(data){
//         console.log(data);
//           return Swal.fire({
//               icon: 'error',
//               title: 'Oops...',
//               text: data.message})

//      }
//   });   

// }
