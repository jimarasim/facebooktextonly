<?php
include 'codebase.php'; 

$facebook = new Facebook($config);
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
            header('Location: login.php');
        }
    }
    catch(FacebookApiException $fex)
    {
        header('Location: login.php');
    }
    catch(Exception $ex)
    {
        echo($ex->getMessage());
    }

?>
</body></html>




