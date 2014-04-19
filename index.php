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

<html><head><title>TextOnly Facebook</title>
<style>table, th, td
{
    border: 1px solid black;
}
</style></head><body><h1>TextOnly Facebook</h1>
<?php
    try
    {
        
        //get the user id
       $user_id = $facebook->getUser();
        
        if($user_id)
        {
            //dispaly user id
            //echo("User ID:".$user_id."<br />");
            
            //get facebook user identification
            $user_profile = $facebook->api('/me','GET');
            //echo "User Name: " . $user_profile['username']."<br />";
            //echo "Name: " . $user_profile['name']."<br />";
            
            //display friends data
            //$friends = $facebook->api('/me/friendlists','GET');
            $friends = $facebook->api(array(
                "method"    => "fql.query",
                "query"     => "SELECT uid,name,friend_count FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ORDER BY friend_count DESC"
            ));
            
            echo("<table><th colspan=2>".$user_profile['name']."(<a href='logout.php'>Logout</a>) - Most Popular Friends</th>");
            foreach ($friends as $dataArray) 
            {
                echo ("<tr><td>Name: ".$dataArray['name']."</td><td>Friends:".$dataArray['friend_count']."</td></tr>");
            }
            echo('</table>');
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




