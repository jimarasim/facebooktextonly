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
    
    echo("this page reserved for testing purposes... it may get funky");
    
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


  
  
?>
</body></html>




