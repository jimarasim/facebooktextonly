<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//logout link
$logoutUrl = $facebook->getLogoutUrl($logoutParams);
echo("<a href='".$logoutUrl."'>Facebook Logout</a><br />");
