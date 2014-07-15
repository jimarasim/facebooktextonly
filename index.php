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
    
    //TRACK the login
    RunQuery("INSERT INTO `fbtextadmin`.`FBUSERS`(`UID`, `USERNAME`, `NAME`) VALUES ('".$user_profile['id']."', '".$user_profile['username']."', '".$user_profile['name']."')");

}
?>

<html><head><title>Text Only Facebook</title>
<link rel="Stylesheet" href="stylebase.css" />
<link rel="Shortcut Icon" href="ocean.ico" />
<script type="text/javascript" src="codebase.js"></script>    
</head><body><script type="text/javascript">HeaderLinks();</script>
<?php

    
    echo "User Name: " . $user_profile['username']."<br />";
    echo "Name: " . $user_profile['name']."<br />";
    echo "UID: " . $user_profile['id']."<br />";
    echo "<br />This site will never have advertising nor anything for sale.<br />";
    
    
?>
</body></html>




