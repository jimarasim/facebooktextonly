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
    
    //$uid="1220353095";
    $uid=filter_input(INPUT_GET,('uid'));
    
    if(!isset($uid)||empty($uid))
    {
        throw new Exception("INVALID UID");
    }

    $multiQuery = array(
    "query1" => "SELECT uid,message,time
                            FROM status 
                            WHERE uid = ".$uid." ORDER BY time DESC LIMIT 100",
    "query2"    => "SELECT uid, name FROM user 
                            WHERE uid =".$uid
    );

    $statuses = $facebook->api(array(
          "method"    => "fql.multiquery",
          "queries"     => $multiQuery

      ));

    //array for storing newsfeed values to cache in the client side page
    $statusHistoryArray = array();
    //get $name
    $name = $statuses[1]["fql_result_set"][0]["name"];
    
    echo("<table><th colspan=3>Statuses - Sort By:</th><tr><td><a href='#' id='statusSort'>Status</a></td><td><a href='#' id='dateSort'>Date</a></td></tr></table>");
    echo("<table id='statusTable'>");
    foreach ($statuses[0]["fql_result_set"] as $statusArrayIndex => $statusArray) 
    {
        
        
        //get message, time
        $uid = $statusArray["uid"];
        $message = $statusArray["message"];
        $time = $statusArray["time"];
        
        echo("<tr>");
        echo("<td><a href='http://facebook.com/profile.php?id=".$uid."' target='_blank'>".$name."</a></td>");
        echo("<td>");
        if(isset($message))
        {
            echo($message);
        }
        echo("</td>");
        echo('<td>'.date("Ymd H:i",$time).'</td>');
        echo('</tr>');
        
        //create array of json objects
        $statusHistoryArray[$statusArrayIndex]=
                array("name"=>$name,
                    "uid"=>$uid,
                    "message"=>$message,
                    "time"=>$time);
    }
    echo('</table>');
    
    
    
    //serialize the array
    $jsonencodedstatuses = json_encode($statusHistoryArray);
    $jsonencodedstatusesnonull = str_replace("null", "0", $jsonencodedstatuses);
    
    echo("<script>var statushistoryarray = ".$jsonencodedstatusesnonull.";</script>");
    
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
        //create an event ot empty tble and sort it by status
        $('#statusSort').click(function(){

            //clear the table
            $('#statusTable').empty();

            //sort the newsfeed by message
            var sorted = statushistoryarray.sort(function(a, b){
                var a1= a.message, b1= b.message;
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            var row="";
            for (var i=0;i<sorted.length;i++)
            { 
                //update the table
                row = GetStatusRow(sorted[i].name,sorted[i].uid,sorted[i].message, sorted[i].time);
                $("#statusTable").append(row);
            }
        });
        
        //create an event ot empty tble and sort it by date
        $('#dateSort').click(function(){

            //clear the table
            $('#statusTable').empty();

            //sort the newsfeed by date
            var sorted = statushistoryarray.sort(function(a, b){
                var a1= a.time, b1= b.time;
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            var row="";
            for (var i=0;i<sorted.length;i++)
            { 
                //update the table
                row = GetStatusRow(sorted[i].name,sorted[i].uid,sorted[i].message,sorted[i].time);
                $("#statusTable").append(row);
            }
        });
    }
    
    /**
    * This function constructs a status row for the status history table
     * @param {type} name
     * @param {type} uid
     * @param {type} message
     * @param {type} time
     * @returns {String}
     */
    function GetStatusRow(name, uid,message, time)
    {
        ///build table row in a message string
        var messageString = "<tr><td><a href='http://facebook.com/profile.php?id="+uid+"' target='_blank'>"+name+"</a></td>";
        messageString+="<td>";
        if(message)
        {
            messageString+=message;
        }
        
        messageString+='</td>';
        
        messageString+='<td>'+time+'</td>';
        messageString+='</tr>';

        //update the table
        return messageString;
    }
    
</script>
</body></html>




