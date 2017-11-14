/* 
 * To add custom JS to the github application
 *  Global JavaScript File for working with jQuery library
 *  
 *  */

// execute when the HTML file's (document object model: DOM) has loaded

$(document).ready(function () {
    //user search button click
    var path = $('#usercheck').attr('action');
    /**
     * This function would send data to php controler for API Call
     * 
     */
    $('#getuser').click(function (e) {
        e.preventDefault();
        //show loader image
        $('#loader').show();
        //get user name
        var username = $('#username').val();
        getHandle(username);
        //get follower data
        $('#followers_avatar').show();
        getFollowers(username, 1);
        //get followers
    });

    /*
     * This function gets information of github user by sending API request to PHP contoller
     * @param string usr
     * @returns string github user handle and followers count
     */

    function getHandle(usr) {
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
     *This function send request to PHP controller for API call of github user to get follower data 
     * @param string usr name of user which to get followers
     * @param integer pg page number of the follower result 
     * @returns string followrs records 
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
                        //$('.followers_avatar').html(data);
                        $('#followers_avatar').remove('.showmore');
                        $('#followers_avatar').append(data);
                        $('#loader').hide();

                    } else {
                        $('#notification-bar').text('An error occurred');
                        $('#loader').hide();
                    }

                });
    }
    //more button
    /*
     * Load more button query more followers of the current github user
     *  @returns github user and follower data  
     */
    $('.showmore').click(function (e) {
        e.preventDefault();
        $('#loader').show();
        var pageNo = $(this).attr('page_no');
        //alert(pageNo);
        var username = $('#username').val();
        //get handle
        //user handle data
        getHandle(username);
        //user follwer data
         $('#followers_avatar').show();
        getFollowers(username, pageNo);
        $(this).remove();

    });

});