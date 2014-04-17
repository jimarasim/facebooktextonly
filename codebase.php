<?php
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
                'scope' => 'read_stream, friends_likes',
                'redirect_uri' => $homePageUrl
            );

$logoutParams = array( 'next' => $homePageUrl);

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
    echo("Please Login through Facebook:<a href='".$loginurl."'>Facebook Login</a><br />");
}

