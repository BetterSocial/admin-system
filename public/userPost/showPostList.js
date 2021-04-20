var dataPost;
$(document).ready(function () {
    console.log("MASUUKKK JS POST LIST");
    dataPost = $('#tableShowPostList').DataTable( {
        "searching": false,
        "stateSave"	: true,
        "serverSide": true,
        "processing": true,
        "language": {
            'loadingRecords': '</br></br></br></br>;',
            'processing': 'Loading...',
            "emptyTable":     "No Post List"
        },
        "ajax": {
            url			: '/user-show-post-list/data',
            type		: 'POST',
            headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") },
            data 		: function ( d ) {
                d.user_id = $('#userId').val();
                d.message = $('#message').val();

            },
        },
        columns		: [
            {
                "data" : 'id',
                "visible": false,
            },
            {
                "data" : 'message',
                render : function(data, type, row) {
                    console.log('kabeh sa row');

                    console.log(data);
                    console.log(type);
                    console.log(row);
                    console.log("_________________________");

                    let itemPosList = "";

                    var images_url = row.images_url;
                    var images_url_length = images_url.length;

                    var images_url_string = "<br>";

                    for (let i=0; i<images_url_length; i++) {
                        images_url_string += " &nbsp;&nbsp; <a href=\" " + images_url[i] + " \" target=\"_blank\"> " +
                            "  <img src=\"" + images_url[i] + "\" width=\"100\" height=\"100\">  ";
                            " </a> &nbsp;&nbsp;";
                    }

                    var object = JSON.parse(row.object);

                    let user_id = row.actor.substring(3);
                    let timestamp = new Date(Date.parse(row.time)).toString().substring(24,-1);

                    /*
                    1. pake variable tunggl untuk return
                    2. pake if untuk icon profile picture
                    3. redirect profile dan nama ke user detail
                    http://127.0.0.1:8000/user-detail-view?user_id=07b76370-243b-4e62-a9cb-9beee4c12580
                    4.
                     */



                    let aa = " <a href=\"/user-detail-view?user_id=" + user_id +" \" > ";

                    if(object.profile_pic_path == null)
                        aa += "  <img src=\"https://res.cloudinary.com/hpjivutj2/image/upload/v1618554083/icons/no-profile_mvjney.jpg\" width=\"50\" height=\"50\">  ";
                    else
                        aa += "  <img src=\"" + object.profile_pic_path + "\" width=\"60\" height=\"60\">  ";
                    aa += " </a> "

                    let bb = " <h6> <a href=\"/user-detail-view?user_id=" + user_id +" \" > " + object.username + " </a> </h6>  ";
                    let dd = " <b>" + timestamp.toString() + " </b> <br> ";
                    let jarak = "   " ;
                    // let cc = " <b> Post Content </b> &nbsp; : " + row.message + " <br> ";
                    let cc = " <p> " + row.message + " </p>";
                    // let dd = " <b> Timestamp </b> &nbsp; : " + timestamp.toString() + " <br> ";

                    let ee = " <b> Images URL </b> &nbsp; :" + images_url_string;
                    let ff =  row.count_upvote + " Upvote ";
                    let gg =  row.count_topicNamedownvote + " Downvote ";

                    // return aa + bb + dd + cc + ee +ff + gg;

                    return " " +
                        // "<div class=\"widget widget-card-one\">\n" +
                        "    <div class=\"widget-content\">\n" +
                        "        <div class=\"media\">\n" +
                        "            <div class=\"w-img\">\n" +

                        aa +

                        "            </div>\n" +
                        "            <div class=\"media-body\">\n" +
                        bb +
                        // "                <h6>Jimmy Turner</h6>\n" +
                        "                <p class=\"meta-date-time\">" + timestamp + " </p>\n" +
                        "            </div>\n" +
                        "        </div>\n" +

                        cc +
                        "        <div>    " +
                        images_url_string +
                        "        </div> <br> " +
                        "        <div class=\"w-action\">\n" +
                        "            <div class=\"card-like\">\n" +
                        "                <span> " +ff+ " </span>\n" +
                        "  &nbsp;&nbsp;&nbsp;&nbsp;   " +
                        "                <span> " +gg+ " </span>\n" +
                        "            </div>\n" +
                        "        </div>\n" +
                        "    </div>\n" +
                        // "</div> " +
                        " ";

                }
            },
            // {
            //     "data" : 'time',
            //     "className" : 'menufilter textfilter',
            // },
            // {
            //     "data" :'images_url[, ]',
            //     "orderable":false,
            //     // render : function(data, type, row) {
            //     //     console.log(row)
            //     //
            //     //     if (data == nutopicNamell) {
            //     //         return "No Images";
            //     //     }
            //     //
            //     //     console.log('url_gamber');
            //     //
            //     //     if(data != "" || data !=" " || data != null){
            //     //
            //     //         console.log(data);
            //     //
            //     //     }
            //     //
            //     // },
            //     // defaultContent: "No Images URL",
            // },
            // // {
            // //     "data" :'images_url[, ]',
            // //     render : function(data, type, row) {
            // //         console.log(row)
            // //
            // //         if (data == null) {
            // //             return "No Images";
            // //         }
            // //
            // //         console.log('url_gamber');
            // //
            // //         if(data != "" || data !=" " || data != null){
            // //
            // //             console.log(data);
            // //
            // //         }
            // //
            //
            // // },
            // {
            //     "data" : 'object',
            //     render : function(data, type, row) {
            //         console.log('objekk');
            //         console.log(data);
            //
            //         if(data != "" || data !=" " || data != null){
            //
            //
            //             return data;
            //
            //         }
            //
            //     },
            //     defaultContent: "No Images URL"
            // },
            // {
            //     "data" :'count_upvote',
            //     "className" : 'menufilter textfilter',
            // },
            // {
            //     "data" : 'count_downvote',
            //     "className" : 'menufilter textfilter',
            // }
            // {
            //     "data" :'status',
            //     "visible": false,
            // },
            // {
            //     "data" : 'location_icon',
            //     "orderable":false,
            //     render : function(data, type, row) {
            //         if(data != "" || data !=" " || data != null){
            //             if(data == 'City'){
            //                 return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/city-icon_oyltzy.png" width="30" height="30" />';
            //             }
            //
            //             if(data == 'Neighborhood'){
            //                 return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/neighboorhod_iwvmaf.png" width="30" height="30" />';
            //             }
            //
            //             if(data == 'State'){
            //                 return '<img src="https://res.cloudinary.com/hpjivutj2/image/upload/v1616639587/icons/state_uyxckp.png" width="30" height="30" />';
            //             }
            //

            //         }
            //
            //     },
            //     defaultContent: "No Icon",
            // },
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
            // {
            //     "data" : "flg_show",
            //     "orderable" : false,
            //     render : function(data, type, row) {
            //         if(row.flg_show =='N'){
            //             return "<input type='checkbox' class='new-control-input' style='zoom:1.5;' onChange='showTopic("+row.location_id+")'>"
            //         }
            //         else{
            //             return "<input type='checkbox' checked class='new-control-input' style='zoom:1.5;' onChange='showTopic("+row.location_id+")'>"
            //         }
            //     }
            // }
        ],
    });

    $('#search').on('submit', function(e) {
        dataPost.draw();
        e.preventDefault();
    });

});

// function showTopic(locationId){
//     var formData = new FormData();
//     formData.append('location_id', locationId);
//
//     $.ajaxSetup({
//         headers: { "X-CSRF-Token" : $("meta[name=csrf-token]").attr("content") }
//     });
//     $.ajax({
//         type: 'POST',
//         dataType:'JSON',
//         data:formData,
//         contentType: false,
//         processData: false,
//         url: '/show/location',
//         success: function(data){
//             if(data.success){
//                 datatableLocations.ajax.reload(null,false);
//
//             }else{
//
//                 return Swal.fire({
//                     icon: 'error',
//                     title: 'Oops...',
//                     text: data.message,})
//             }
//         },
//         error: function(data){
//             console.log(data);
//             return Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: data.message})
//
//         }
//     });
//
// }
