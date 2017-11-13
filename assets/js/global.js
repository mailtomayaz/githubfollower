/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* Global JavaScript File for working with jQuery library */
// execute when the HTML file's (document object model: DOM) has loaded

$(document).ready(function () {
    //user search button click
    var path = $('#usercheck').attr('action');
    $('#getuser').click(function (e) {
        e.preventDefault();
        //show loader image
        $('#loader').show();
        //get user name
        var username = $('#username').val();
        gethandle(username);
        //get follower data
        getFollowers(username, 1);
        //get followers
    });

    /*
     * 
     * @param {string} usr
     * @returns handle and followers count
     */

    function gethandle(usr) {
        $.get(path + "/" + usr,
                function (data, status) {
                    if (status === 'success') {

                        //get followers;
                        $('#userhandle').html(data);

                    } else {
                        $('#notification-bar').text('An error occurred');
                    }

                });
    }

    /*
     * 
     * @param {string} usr, integer
     * @returns followrs records 100 per page
     */
    function getFollowers(usr, pg) {
        var folUrl = path + '/' + usr + '/' + pg;
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
                        $('#loader').hide();

                    } else {
                        $('#notification-bar').text('An error occurred');
                        $('#loader').hide();
                    }

                });
    }
    //more button
    /*
     * load next 100 records on view more link
     *  
     */
    $('#showmore').click(function (e) {
        $('#loader').show();
        var pageNo = $(this).attr('page_no');
        //alert(pageNo);
        var username = $('#username').val();
        //get handle
        //user handle data
        gethandle(username);
        //user follwer data
        getFollowers(username, pageNo);

    });

});