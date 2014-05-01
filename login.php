<?php
include 'codebase.php'; 
if(CheckAccess($facebook))
{
   header('Location: index.php');
}
?>

<html><head><title>Text Only Facebook</title>
<link rel="Stylesheet" href="stylebase.css" />
<link rel="Shortcut Icon" href="ocean.ico" />
<script type="text/javascript" src="codebase.js"></script>    
</head><body id='loginpage'>
<?php
    LoginFacebook($facebook,$loginParams);
?>
    <hr>
    This site renders text only pages of your Facebook newsfeed and friends list.  Other features will be added as time goes on.<br />
    Your data will not be stored or tracked by this site in any way.
</body></html>



