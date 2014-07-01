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
    //display friends data
    $friends = $facebook->api(array(
        "method"    => "fql.query",
        "query"     => "SELECT uid,name,friend_count,pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ORDER BY name"
    ));

    
    echo("<table><th colspan=2>Friends - Sort By:</th><tr><td><a href='#' id='friendSort'>Name</a></td><td><a href='#' id='friendsSort'>Friends</a></td></tr></table>");
    echo("<table id='friendTable'>");
    //echo("<tr><td><a href='#' id='friendSort'>Friend</a></td><td><a href='#' id='friendsSort'>Friends</a></td></tr>");
    foreach ($friends as $friendArray) 
    {
        //write out a row
        $row = "<tr><td><img src='".$friendArray['pic']."' /></td>";
        $row .= "<td>Name: <a href='http://facebook.com/profile.php?id=".$friendArray['uid'];
        $row .= "' target='_blank'>".$friendArray['name']."</a>";
        $row .= "&nbsp<a href=statushistory.php?uid=".$friendArray['uid'].">(statuses)</a>";
        $row .= "</td><td>Friends:";
        $row .= $friendArray['friend_count']."</td></tr>";
        echo ($row);
    }
    echo('</table>');
    
    //serialize the array
    $jsonencodedfriends = json_encode($friends);
    $jsonencodedfriends = str_replace("null", "0", $jsonencodedfriends);
    
    echo("<script>var friendarray = ".$jsonencodedfriends.";</script>");
    


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
            $('#friendTable').empty();

            //sort the friends by name
            var sorted = friendarray.sort(function(a, b){
                var a1= a.name, b1= b.name;
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            for (var i=0;i<sorted.length;i++)
            { 
                $("#friendTable").append(GetStatusRow(sorted[i].pic,sorted[i].uid,sorted[i].name,sorted[i].friend_count));
            }

        });

        //create an event ot empty tble and sort it by friend count
        $('#friendsSort').click(function(){

            //clear the table
            $('#friendTable').empty();

            //sort the friends by number of friends
            var sorted = friendarray.sort(function(a, b){
                var a1= parseInt(a.friend_count), b1= parseInt(b.friend_count);
                if(a1=== b1) return 0;
                return a1> b1? 1: -1;
            });

            //update the table
            for (var i=0;i<sorted.length;i++)
            { 
                $("#friendTable").append(GetStatusRow(sorted[i].pic,sorted[i].uid,sorted[i].name,sorted[i].friend_count));
            }
        });
    }
    
    function GetStatusRow(pic,uid,name,friend_count)
    {
        ///build table row in a message string
        var messageString = "<tr><td><img src='"+pic+"' /></td>";
        messageString += "<td>Name: <a href='http://facebook.com/profile.php?id="+uid+"' target='_blank'>"+name+"</a>";
        messageString += "&nbsp<a href=statushistory.php?uid="+uid+">(statuses)</a></td>";
        messageString += "<td>Friends:"+friend_count+"</td></tr>";

        //update the table
        return messageString;
    }
</script>
</body></html>




