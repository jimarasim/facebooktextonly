<?php
include 'codebase.php'; 

$facebook = new Facebook($config);

?>

<html><head><title></title></head><body>
<?php
    try
    {
        LoginFacebook($facebook,$loginParams);
        
    }
    catch(Exception $ex)
    {
        echo($ex->getMessage());
    }

?>
</body></html>



