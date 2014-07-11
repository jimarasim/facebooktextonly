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
<link rel="Shortcut Icon" href="ocean.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="codebase.js"></script>    
</head><body><script type="text/javascript">HeaderLinks();</script>
<?php
    
try {
    
    //Query for newsfeed, and the user name associated with each post
    $multiQuery = array(
    "query1" => "SELECT post_id, actor_id, message, description, permalink, created_time
                            FROM stream 
                            WHERE filter_key in (
                                 SELECT filter_key 
                                 FROM stream_filter
                                 WHERE uid=me() AND type='newsfeed'
                           ) AND is_hidden = 0 ORDER BY created_time DESC LIMIT 50",
    "query2"    => "SELECT uid, name, pic FROM user 
                            WHERE uid IN (SELECT actor_id FROM #query1)"
    );

    $statuses = $facebook->api(array(
          "method"    => "fql.multiquery",
          "queries"     => $multiQuery

      ));

    //array for storing newsfeed values to cache in the client side page
    $newsFeedArray = array();
    
    echo("<table><th colspan=3>NewsFeed - Sort By:</th><tr><td><a href='#' id='friendSort'>Name</a></td><td><a href='#' id='statusSort'>Status</a></td><td><a href='#' id='dateSort'>Date</a></td></tr></table>");
    echo("<table id='statusTable'>");
    foreach ($statuses[0]["fql_result_set"] as $statusArrayIndex => $statusArray) 
    {
        //clear these out, in case there are no matches
        $name = "";
        $uid = "";
        $pic = "";
        
        //get $name and $uid, for initial display and serialization, for given actor_id
        foreach($statuses[1]["fql_result_set"] as $index => $nameArray)
        {
            
            if($nameArray["uid"]==$statusArray["actor_id"])
            {
                $name = $statuses[1]["fql_result_set"][$index]["name"];
                $uid = $statuses[1]["fql_result_set"][$index]["uid"];
                $pic = $statuses[1]["fql_result_set"][$index]["pic"];
                break;
            }
        }
        
        //get message, description, permalink, and created_time for initial display and serialization
        $message = $statusArray["message"];
        $description = $statusArray["description"];
        $permalink = $statusArray["permalink"];
        $created_time  = $statusArray["created_time"];
        
        //trying to fix issue of page posts showing user names
        if(strrpos($message, "In case you missed it, listen to a stream of Jack’s BBC Radio")>-1)
        {
            echo("");
        }
        
        echo("<tr><td><img src='".$pic."' /></td><td><a href='http://facebook.com/profile.php?id=".$uid."' target='_blank'>".$name."</a></td>");
        echo("<td>");
        echo("<em>".date("m/d/Y H:i",$created_time)."</em><br />");
        if(isset($message))
        {
            echo("MESSAGE:");
            echo($message);
            echo("<br />");
        }
        
        if(isset($description))
        {
            echo("DESCRIPTION:");
            echo("[".$description."]");
            echo("<br />");
        }
        
        if(isset($permalink)&&!empty($permalink))
        {
            echo("<a href='".$permalink."' target='_blank'>Actual Post</a>");
        }
        echo('</td>');

        echo('</tr>');
        
        //create array of json objects
        $newsFeedArray[$statusArrayIndex]=
                array("name"=>$name,
                    "uid"=>$uid,
                    "pic"=>$pic,
                    "message"=>$message,
                    "description"=>$description,
                    "permalink"=>$permalink,
                    "created_time"=>$created_time);
    }
    echo('</table>');
    
    
    
    //serialize the array
    $jsonencodedstatuses = json_encode($newsFeedArray);
    $jsonencodedstatusesnonull = str_replace("null", "0", $jsonencodedstatuses);
    
    echo("<script>var newsfeedarray = ".$jsonencodedstatusesnonull.";</script>");
    
  } catch (Exception $ex) {
    echo("THERE WAS AN UNEXPECTED ISSUE:".$ex->getMessage());
}
  
?>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        
        SetupEvents();
        
            
    });
    
    function SetupEvents()
    {
        //create event to empty table and sort it by friend name
        $('#friendSort').click(function(){

            //clear the table
            $('#statusTable').empty();

            //sort the friends by name
            var sorted = newsfeedarray.sort(function(a, b){
                var a1= a.name, b1= b.name;
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            var row="";
            for (var i=0;i<sorted.length;i++)
            { 
                //update the table
                row = GetStatusRow(sorted[i].pic,sorted[i].name,sorted[i].uid,sorted[i].message, sorted[i].description, sorted[i].permalink, sorted[i].created_time);
                $("#statusTable").append(row);
        
            }

        });

        //create an event ot empty tble and sort it by status
        $('#statusSort').click(function(){

            //clear the table
            $('#statusTable').empty();

            //sort the newsfeed by message
            var sorted = newsfeedarray.sort(function(a, b){
                var a1= a.message+" "+a.description, b1= b.message+" "+b.description;
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            var row="";
            for (var i=0;i<sorted.length;i++)
            { 
                //update the table
                row = GetStatusRow(sorted[i].pic,sorted[i].name,sorted[i].uid,sorted[i].message, sorted[i].description, sorted[i].permalink, sorted[i].created_time);
                $("#statusTable").append(row);
            }
        });
        
        //create an event ot empty tble and sort it by date
        $('#dateSort').click(function(){

            //clear the table
            $('#statusTable').empty();

            //sort the newsfeed by date descending
            var sorted = newsfeedarray.sort(function(a, b){
                var a1= a.created_time, b1= b.created_time;
                if(a1=== b1) return 0;
                return a1< b1? 1: -1;
            });

            //update the table
            var row="";
            for (var i=0;i<sorted.length;i++)
            { 
                //update the table
                row = GetStatusRow(sorted[i].pic,sorted[i].name,sorted[i].uid,sorted[i].message, sorted[i].description, sorted[i].permalink, sorted[i].created_time);
                $("#statusTable").append(row);
            }
        });
    }
    
    //this function formats a row of status table data, given the provided input
    function GetStatusRow(pic,name, uid,message, description, permalink, created_time)
    {
        ///build table row in a message string
        var messageString = "<tr><td><img src='"+pic+"' /></td><td><a href='http://facebook.com/profile.php?id="+uid+"' target='_blank'>"+name+"</a></td>";
        
        messageString+="<td>";
        messageString+='<em>'+DateTimeFromUnixTimeStamp(created_time)+'</em><br />';
        if(message)
        {
            messageString+="MESSAGE:";
            messageString+=message;
            messageString+="<br />";
        }
        if(description)
        {
            messageString+="DESCRIPTION:";
            messageString+="["+description+"]";
            messageString+="<br />";
        }
        
        if(permalink)
        {
            messageString+="<a href='"+permalink+"' target='_blank'>Actual Post</a>";
        }
        messageString+='</td>';


        messageString+='</tr>';

        //update the table
        return messageString;
    }
    
    
    
</script>
</body></html>




