/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* Global JavaScript File for working with jQuery library */

// execute when the HTML file's (document object model: DOM) has loaded
$(document).ready(function () {
     var path = $('#usercheck' ).attr( 'action' );
    $('#getuser').click(function (e) {
        e.preventDefault();
        //ajax get call to query users
        var username = $('#username').val();
        //get handle
        //user handle data
        var datahandle = gethandle(username);
         getFollowers(username,1);
        //get followers
          

    });
   function gethandle(usr){
             $.get(path+"/"+usr,
                function (data, status) {
                    if (status === 'success') {
                       // $('#notification-bar').text('The page has been successfully loaded');
                        //get followers;
                        $('#userhandle').html(data);
                      
                    } else {
                        $('#notification-bar').text('An error occurred');
                    }
                    // alert("Data: " + data + "\nStatus: " + status);
                });
        } 
function getFollowers(usr, pg) {
            var folUrl = path +'/'+usr+'/'+ pg;
           // alert(folUrl);
            $.get(folUrl,
                    function (data, status) {
                        if (status === 'success') {
                            //get followers;
                           // console.log(data.length);
                            var followerCount = '';
                            if (data.length < 99) {
                                followerCount = data.length;
                            }
                        $('.followers_avatar').html(data);
                          
                        } else {
                            $('#notification-bar').text('An error occurred');
                        }
                        
                    });
        }
  //more button

  $('#showmore').click(function (e) {
     var pageNo =  $(this).attr('page_no');
     //alert(pageNo);
     var username = $('#username').val();
        //get handle
        //user handle data
       gethandle(username);
       getFollowers(username,pageNo);
        //get followers
     //alert(pageNo);
            //alert('tst');
             // e.preventDefault();
//                var username = $('#username').val();
//            //get page count    
//            var pageNo =  parseInt($('#con_pag').val());
//            var nxPage = parseInt(pageNo+1);
//            //update page filed
//            $('#con_pag').val(nxPage);
//            console.log(nxPage);
//            var myURL = document.location;
//            console.log(myURL);
//            document.location = myURL + "?p=2";
//            get
            //add 1 for next page
               // var pageNo =  $('#con_pag').val();
                
             //  getFollowers(username,nxPage);
                
        });

});