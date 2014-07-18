
//this function writes out the site header links
function HeaderLinks()
{
    //create the json link array
    var homeLinks = 
            [
                {"atext":"Home","ahref":"index.php"},
                {"atext":"News Feed","ahref":"newsfeed.php"},
                {"atext":"Friends","ahref":"friends.php"},
                {"atext":"Scratch","ahref":"scratch.php"},
                {"atext":"Logout","ahref":"logout.php"}
            ];
       
    //write outo header
    document.write("<h3>Text Only Facebook</h3>");
    document.write("<em>comments/suggestions/issues contact <a href='mailto:jim@seattlerules.com'>jim@seattlerules.com</a></em>");
    
    //write out the links
    var link;
    document.write("<hr><table><tr>");
    for(var i = 0; i < homeLinks.length; i++)
    {
        document.write("<td><a id='headerlinks' href='"+homeLinks[i].ahref+"'>"+homeLinks[i].atext+"</a></td>");
    }
    document.write("</tr></table><hr>");
    
}

//this function returns a javascript date from a unix date stamp
function DateTimeFromUnixTimeStamp(unixTimeStamp)
{
            
    //make a normal looking date format
    //unix timestamp is in seconds, but javascript date object goes down to milliseconds
    var javascriptMilliseconds = unixTimeStamp*1000;
    var javascriptDate = new Date(javascriptMilliseconds);
    var month = javascriptDate.getMonth();
    var day = javascriptDate.getDay();
    var year = javascriptDate.getFullYear();
    var hour = javascriptDate.getHours();
    var minute = javascriptDate.getMinutes();
    
    if(minute.length===1)minute="0"+minute;
    if(month.length===1)month="0"+month;
    if(day.length===1)day="0"+day;

    var dateString = month+"/"+day+"/"+year+" "+hour+":"+minute;
    
    return dateString;
}


