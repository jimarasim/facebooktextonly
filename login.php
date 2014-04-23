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
</body></html>



