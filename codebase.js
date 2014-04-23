
//this function writes out the site header links
function HeaderLinks()
{
    //create the json link array
    var homeLinks = 
            [
                {"atext":"Home","ahref":"index.php"},
                {"atext":"Most Popular","ahref":"mostpopular.php"},
                {"atext":"News Feed","ahref":"newsfeed.php"},
                {"atext":"Scratch","ahref":"scratch.php"},
                {"atext":"Logout","ahref":"logout.php"}
            ];
       
    //write outo header
    document.write("<h3>Text Only Facebook</h3>");
    
    //write out the links
    var link;
    document.write("<hr><table><tr>");
    for(var i = 0; i < homeLinks.length; i++)
    {
        document.write("<td><a href='"+homeLinks[i].ahref+"'>"+homeLinks[i].atext+"</a></td>");
    }
    document.write("</tr></table><hr>");
    
}


