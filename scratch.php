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
    
    //insert the user (note: queries are case sensitive)
    if(RunQuery("INSERT INTO `fbtextadmin`.`FBUSERS`(`UID`, `USERNAME`, `NAME`) VALUES ('".$user_profile['id']."', '".$user_profile['username']."', '".$user_profile['name']."')"))
    {
        echo('INSERT SUCCEEDED<br />');
    }
    else
    {
        echo('INSERT FAILED<br />');
    }
    
    //run a query against private fb databse (note: queries are case sensitive)
    if(RunQuery("SELECT * FROM fbtextadmin.FBUSERS"))
    {
        echo('DATABASE QUERY SUCCEEDED<br />');
    }
    else
    {
        echo('DATABASE QUERY FAILED<br />');
    }

    ///photo publish from existing url example
    //https://developers.facebook.com/docs/graph-api/reference/v2.0/page/photos
    /* make the API call */
    //$request = new FacebookRequest(
    //  $session,
    //  'POST',
    //  '/{page-id}/photos',
    //  array (
    //    'url' => 'image-url',
    //  )
    //);
    //$response = $request->execute();
    //$graphObject = $response->getGraphObject();
    /* handle the result */
    
    
    
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




