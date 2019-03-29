<?php
/*
 * Basic Site Settings and API Configuration
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'pantrypal test');
define('DB_USER_TBL', 'users');
define('Servers','AllowNoPassword' = true);

// Google API configuration
define('GOOGLE_CLIENT_ID', '1067865018960-fpf02piennheuoc69meqtehcev12qnbo.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', 'EHAtzvasBCfHq2tcmIpMbNq1');
define('GOOGLE_REDIRECT_URL', 'http://localhost/pantrypal');

// Start session
if(!session_id()){
    session_start();
}

// Include Google API client library
require_once 'google-api-php-client/Google_Client.php';
require_once 'google-api-php-client/contrib/Google_Oauth2Service.php';

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('PantryPal');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>