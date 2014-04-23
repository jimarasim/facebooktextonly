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
    "query1" => "SELECT post_id, actor_id, message, description, permalink, created_time
                            FROM stream 
                            WHERE filter_key in (
                                 SELECT filter_key 
                                 FROM stream_filter
                                 WHERE uid=me() AND type='newsfeed'
                           ) AND is_hidden = 0 ORDER BY created_time DESC LIMIT 100",
    "query2"    => "SELECT uid, name FROM user 
                            WHERE uid IN (SELECT actor_id FROM #query1)"
    );

    $statuses = $facebook->api(array(
          "method"    => "fql.multiquery",
          "queries"     => $multiQuery

      ));

    echo("<table><th colspan=3>".$user_profile['name']." - NewsFeed</th>");
    foreach ($statuses[0]["fql_result_set"] as $statusArray) 
    {
        $name="";
        foreach($statuses[1]["fql_result_set"] as $index => $nameArray)
        {
            if($nameArray["uid"]==$statusArray["actor_id"])
            {
                $name = $statuses[1]["fql_result_set"][$index]["name"];
                break;
            }
        }
        echo('<tr><td>'.$name.'</td><td>');
        if(isset($statusArray["message"]))
        {
            echo($statusArray["message"]);
        }
        if(isset($statusArray["description"]))
        {
            echo("[".$statusArray["description"]."]");
        }
        if(isset($statusArray["permalink"])&&!empty($statusArray["permalink"]))
        {
            echo("(<a href='".$statusArray["permalink"]."' target='_blank'>more</a>)");
        }
        echo('</td>');
        echo('<td>'.date("Ymd H:i",$statusArray["created_time"]).'</td>');
        echo('</tr>');
    }
    echo('</table>');
  
  
?>
</body></html>




