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
    
    //display statuses in last 24 hours
    $statuses = $facebook->api(array(
        "method"    => "fql.query",
        "query"     => "SELECT post_id, actor_id, message, description
                        FROM stream 
                        WHERE filter_key in (
                             SELECT filter_key 
                             FROM stream_filter
                             WHERE uid=me() AND type='newsfeed'
                       ) AND is_hidden = 0 LIMIT 50"
    ));

    echo("<table><th colspan=2>".$user_profile['name']." - NewsFeed</th>");
    foreach ($statuses as $statusArray) 
    {
        echo ("<tr><td>Post_id: ".$statusArray['post_id']."</td><td>Actor_id: "
                .$statusArray['actor_id']."</td><td>Status:"
                .$statusArray['message']."</td><td>Description:"
                .$statusArray['description']."</td></tr>");
    }
    echo('</table>');


?>
</body></html>




