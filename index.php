<?php
include 'codebase.php'; 

try 
{
    $facebook = new Facebook($config);
}
catch(Exception $ex)
{
    
    echo($ex->getMessage());
}
?>

<html><head><title></title></head><body>
<?php
    try
    {
        
        //get the user id
       $user_id = $facebook->getUser();
        
        if($user_id)
        {
            //dispaly user id
            echo("User ID:".$user_id."<br />");
            
            //get facebook user credentials
            $user_profile = $facebook->api('/me','GET');
            echo "Name: " . $user_profile['name']."<br />";
            
            echo("<a href='logout.php'>Logout</a><br />");
        }
        else    
        {
            
            echo("<script> window.location='login.php'; </script>");
        }
    }
    catch(Exception $ex)
    {
        
        echo('EXCEPTION CAUGHT:'.$ex->getMessage());
    }

?>
</body></html>




