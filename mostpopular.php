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
<!--<link rel="Shortcut Icon" href="jaemzware.ico" />-->
<script type="text/javascript" src="codebase.js"></script>    
</head><body><script type="text/javascript">HeaderLinks();</script>
<?php
    //display friends data
    $friends = $facebook->api(array(
        "method"    => "fql.query",
        "query"     => "SELECT uid,name,friend_count FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ORDER BY friend_count DESC"
    ));

    echo("<table><th colspan=2>".$user_profile['name']." - Most Popular Friends</th>");
    foreach ($friends as $friendArray) 
    {
        echo ("<tr><td>Name: ".$friendArray['name']."</td><td>Friends:".$friendArray['friend_count']."</td></tr>");
    }
    echo('</table>');


?>
</body></html>




