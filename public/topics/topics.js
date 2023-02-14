var datatble ;
$(document).ready(function () {

  datatble=$('#tableTopics').DataTable( {
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
          render: function(data, type, row) {
            let item = JSON.parse(row);
            return `
                <div class="btn-detail"  data-item="${item}">${data}</div>
                `;
          }
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
          "data" : "flg_show",
					"orderable" : false,
			    	render : function(data, type, row) {
              
              if(row.flg_show =='N'){
                return "<input type='checkbox' class='new-control-input' style='zoom:1.5;' onChange='showTopic("+row.topic_id+")'>"
              }
              else{
                return "<input type='checkbox' checked class='new-control-input' style='zoom:1.5;' onChange='showTopic("+row.topic_id+")'>"
              }
			    	}
        }
			],
    
  } );

  $('#search').on('submit', function(e) {
    datatble.draw();
    e.preventDefault();
  });
  

});


function showTopic(topicId){
  var formData = new FormData();
  formData.append('topic_id', topicId);
 
  $.ajaxSetup({
    headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
  });
  $.ajax({
      type: 'POST',
      dataType:'JSON',
      data:formData,
      contentType: false, 
      processData: false,
      url: '/show/topics',
      success: function(data){
          console.log(data);
          if(data.success){
              datatble.ajax.reload(null,false);
              
          }else{
            datatble.ajax.reload(null,false);
              return Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: data.message,})
          }
      },
      error: function(data){
        console.log(data);
        datatble.ajax.reload(null,false);
          return Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: data.message})

     }
  });   

}
