<?php
include 'codebase.php'; 

$facebook = new Facebook($config);

//logout
$facebook->destroySession();

echo($facebook->getUser());

session_destroy();

header('Location: '.$facebook->getLogoutUrl($logoutParams));

