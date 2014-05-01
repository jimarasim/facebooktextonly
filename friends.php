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
        "query"     => "SELECT uid,name,friend_count FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) ORDER BY name"
    ));

    
    echo("<table><th colspan=2>Friends - Sort By:</th><tr><td><a href='#' id='friendSort'>Name</a></td><td><a href='#' id='friendsSort'>Friends</a></td></tr></table>");
    echo("<table id='friendTable'>");
    //echo("<tr><td><a href='#' id='friendSort'>Friend</a></td><td><a href='#' id='friendsSort'>Friends</a></td></tr>");
    foreach ($friends as $friendArray) 
    {
        //write out a row
        echo ("<tr><td>Name: <a href='http://facebook.com/profile.php?id=".$friendArray['uid']."' target='_blank'>".$friendArray['name']."</a></td><td>Friends:".$friendArray['friend_count']."</td></tr>");
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
                $("#friendTable").append(
                        "<tr><td>Name: <a href='http://facebook.com/profile.php?id="+
                        sorted[i].uid+"' target='_blank'>"+
                        sorted[i].name+"</a></td><td>Friends:"+
                        sorted[i].friend_count+"</td></tr>");
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
                $("#friendTable").append(
                        "<tr><td>Name: <a href='http://facebook.com/profile.php?id="+
                        sorted[i].uid+"' target='_blank'>"+
                        sorted[i].name+"</a></td><td>Friends:"+
                        sorted[i].friend_count+"</td></tr>");
            }
        });
    }
</script>
</body></html>




