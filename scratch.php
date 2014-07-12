<?php
include 'codebase.php'; 


if(!CheckAccess($facebook))
{
   header('Location: login.php');
}
else
{
    //get facebook user identification
    $user_profile = $facebook->api('/me','GET');
}
?>

<html><head><title>Text Only Facebook</title>
<link rel="Stylesheet" href="stylebase.css" />
<link rel="Shortcut Icon" href="ocean.ico" />
<script type="text/javascript" src="codebase.js"></script>    
</head><body><script type="text/javascript">HeaderLinks();</script>
<?php
    
    echo("<h2 style='color:red;'>this page reserved for testing purposes... it may get funky</h2>");
    
    if(RunQuery("SELECT * FROM FBTextAdmin.USERS"))
    {
        echo('DATABASE QUERY SUCCEEDED');
    }
    else
    {
        echo('DATABASE QUERY FAILED');
    }


    
    ////////////////////////////////////////////////////////////////////
    //Database: FBTextAdmin	Table: USERS
    //mysql insert query for user
    //"INSERT INTO `FBTextAdmin`.`USERS` (`UID`, `USERNAME`, `NAME`) VALUES ('".$user_profile['id']."', '".$user_profile['username']."', '".$user_profile['name']."');"
    //SELECT * FROM `USERS`
    ////////////////////////////////////////////////////////////////////

    
    
    
    ////////////////////////////////////////////////////////////////////
    // Upload a photo to a user’s profile
    // Your app needs publish_actions permission for this to work
//    $facebook->setFileUploadSupport(true);
//
//    $img = 'images/jim.jpg';
//
//    $photo = $facebook->api(
//      '/me/photos', 
//      'POST',
//      array(
//        'source' => '@' . $img,
//        'message' => 'Photo uploaded via the PHP SDK!'
//      )
//    );
    ////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////
    //NON-BIASED NEWSFEED
    //display friends data
//    $friends = $facebook->api(array(
//        "method"    => "fql.query",
//        "query"     => "SELECT uid,name,username,pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ORDER BY name"
//    ));
//
//    
//    echo("<table id='currentStatusTable'>");
//    foreach ($friends as $friendArray) 
//    {
//        //write out a row
//        $row = "<tr><td><img src='".$friendArray['pic']."' /></td><td>UID:".$friendArray['uid']."</td>";
//        $row .= "<td>Name: <a href='http://facebook.com/profile.php?id=".$friendArray['uid'];
//        $row .= "' target='_blank'>".$friendArray['name']."</a></td>";
//        $row .= "</tr>";
//        echo ($row);
//    }
//    echo('</table>');
    ////////////////////////////////////////////////////////////////////

  
  
?>
</body></html>




