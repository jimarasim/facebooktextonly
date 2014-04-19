<?php
include 'codebase.php'; 

$facebook = new Facebook($config);

//logout
$facebook->destroySession();

?>

<html><head><title></title></head><body>
<?php
echo("<script>window.location='".$facebook->getLogoutUrl($logoutParams)."';</script>");
?>
</body></html>

