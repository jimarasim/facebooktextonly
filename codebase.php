<?php
include '../facebook-php-sdk/src/facebook.php'; 

require_once("facebook.php");

$config = array(
            'appId' => '631297493591205',
            'secret' => '70225208bbd0a6f7b0868486ddee1c77',
            'fileUpload' => false, // optional
            'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
        );

$loginParams = array(
                'scope' => 'read_stream, friends_likes',
                'redirect_uri' => GetCurrentUrl()
            );

$logoutParams = array( 'next' => GetCurrentUrl());

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

