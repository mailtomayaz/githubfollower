<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h3>Github API User and Follower Information</h3>
<h3><?php //echo $page_item['title'];  ?></h3>
<div class="main">
    <?php //echo $page_item['text'];  ?>

<?php
$attributes = array('name' => 'usercheck', 'id' => 'usercheck');
//user search form
echo form_open('pages/searchuser', $attributes);
?>
<table>
    <tr>
        <td><label for="title">User Name</label></td>
        <td><input type="input" name="title" id="username" /></td>
        <td><input id="getuser" type="submit" name="submit" value="Search Users" /></td>
        <input type="hidden" id="con_pag" value='1' />

</table>
</form>
<!--content area to display -->
<div id="notification-bar"></div>
<div id="userhandle"> </div>
<div class="follower_count"></div>
<div class="followers_avatar">
    <table id="followers_avatar">
           <tr>
            <th>Name</th>
            <th>URL</th>
            <th>Avatar</th>
           </tr>
       </table>
    
    
</div>
<div id="loader"></div>
</div>