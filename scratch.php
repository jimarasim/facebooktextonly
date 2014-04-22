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
    
$multiQuery = array(
"query1" => "SELECT post_id, actor_id, message, description
                        FROM stream 
                        WHERE filter_key in (
                             SELECT filter_key 
                             FROM stream_filter
                             WHERE uid=me() AND type='newsfeed'
                       ) AND is_hidden = 0 LIMIT 50",
"query2"    => "SELECT uid, name FROM user 
                        WHERE uid IN (SELECT actor_id FROM #query1)"
);

$statuses = $facebook->api(array(
      "method"    => "fql.multiquery",
      "queries"     => $multiQuery

  ));

  echo("here");
  
?>
</body></html>




