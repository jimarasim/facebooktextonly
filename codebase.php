<?php

//set the timezone
date_default_timezone_set("America/Los_Angeles");

//facebook sdk directory
$facebookSdkFolder = "facebook-php-sdk";

//this projects home page
$homePage = "index.php";

//include the facebook sdk.  Should be in the parent directory of this project as $facebookSdkFolder
//realpath converts path correctly for windows or unix server
$currentDirectory = realpath(dirname(__FILE__));
//find the last occurrence of the DIRECTORY_SEPARATOR (/ or \\ depending on unix or windows)
$lastSeparatorPosition = strripos($currentDirectory,DIRECTORY_SEPARATOR);
//replace the current directory folder with the $facebookSdkFolder
$facebookSdkDirectory = substr_replace($currentDirectory,$facebookSdkFolder,$lastSeparatorPosition+1);
$facebookInclude = $facebookSdkDirectory.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'facebook.php';
include $facebookInclude;

//url for facebook to call after logging in /out
$lastSlashPosition = strripos(GetCurrentUrl(),'/');
$homePageUrl = substr_replace(GetCurrentUrl(),$homePage,$lastSlashPosition+1);

$config = array(
            'appId' => '631297493591205',
            'secret' => '70225208bbd0a6f7b0868486ddee1c77',
            'fileUpload' => false, // optional
            'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
        );

$loginParams = array(
                'scope' => 'read_stream, read_friendlists, user_groups',
                'redirect_uri' => $homePageUrl
            );

$logoutParams = array( 'next' => $homePageUrl);



$facebook = new Facebook($config);


/**
 * this function gets the current url
 */
function GetCurrentUrl()
{
    $HTTPS = filter_input(INPUT_SERVER, 'HTTPS');
    $HTTP_HOST = filter_input(INPUT_SERVER, 'HTTP_HOST');
    $REQUEST_URI = filter_input(INPUT_SERVER, 'REQUEST_URI');
    
    $protocol = (!empty($HTTPS) && $HTTPS == 'on') ?'htts://':'http://';
    
    $currentUrl = $protocol.$HTTP_HOST.$REQUEST_URI;
    
    return $currentUrl;
}

/**
 * this function logs into facebook
 */
function LoginFacebook($facebook,$loginParams)
{
    $loginurl = $facebook->getLoginUrl($loginParams);
    echo("<a href='".$loginurl."'>Facebook Login</a>");
}

/**
 * This function checks for access to facebook
 */
function CheckAccess($facebook)
{
    //get the user id
    $user_id = $facebook->getUser();

    return $user_id;
}

/**
 * This function checks the database connection
 */
function RunQuery($sqlQuery)
{
    //connect to the database permissions https://panel.dreamhost.com/?tree=goodies.mysql&current_step=Index&next_step=ShowEditUser&usernamed=sk8creteordie
    $hostname = "mysql.seattlerules.com";   // eg. mysql.yourdomain.com (unique)
    $username = "sk8creteordie";   // the username specified when setting-up the database
    $password = "di3@Crete";   // the password specified when setting-up the database
    $database = "fbtextadmin";   // the database name chosen when setting-up the database (unique)

    try
    {
        //connect to the database server
        $con = mysql_connect($hostname,$username,$password);  //database connections are automatically closed
        
        //select the database to use
        $databaseSelected=mysql_select_db($database,$con);
        
        //check if the database was selected
        if(!$databaseSelected)
        {
            return false;
        }
        
        //run the query
        $result = mysql_query($sqlQuery, $con);

        //check result
        if (!$result) {
            echo "COULD NOT QUERY DATABASE:".$database.".<br />";
            echo "MYSQL ERROR:".mysql_error()."<br />";
            return false;
        }

        //if this was a SELECT query, write out the result
        if(strpos(strtolower($sqlQuery),"select")===0)
        {
            //write out data
            echo("<div style='color:white;'>");
            while ($row = mysql_fetch_assoc($result)) {
                echo "UID:".$row['UID']." USERNAME:".$row['USERNAME']." NAME:".$row['NAME']." LASTLOGIN:".$row['LASTLOGIN']."<br />";
            }
            echo("</div>");

            //release the result memory
            mysql_free_result($result); 
        }
        
        return true;
    }
    catch(Exception $ex)
    {
        echo("CONNECTION FAILED. EXCEPTION:".$ex->getMessage());
        return false;
    }
    
}

