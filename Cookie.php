<?php
/*
Checking if a cookie exists (i.e., if the user is already logged in).
Decrypting and parsing cookie data to retrieve session information.
Removing the cookie when the user logs off or the session is invalidated.
*/
// Initialize variables
$CookieTeamNumber = 0;
$CookieTeamName = "";
$LoginLink = "";
if (!isset($Cookie_Name)) {
    $Cookie_Name = "";
}



// Handle logout request
if (isset($_POST["Logoff"]) || isset($_GET['Logoff'])) {
   
    // Set cookie to expire
    setcookie($Cookie_Name, "", time() - 3600, "/"); // Expire the cookie
    unset($_COOKIE[$Cookie_Name]); // Remove from the $_COOKIE superglobal
    $CookieTeamNumber = 0; // Reset team number

    header("Location: /index.php");
    exit();  // Ensure no further code is executed after the redirect
} elseif (isset($_COOKIE[$Cookie_Name])) {
    // Decrypt and parse cookie data
    $encryption_key = base64_decode($CookieTeamNumberKey);
    list($encrypted_data, $iv) = explode('::', base64_decode($_COOKIE[$Cookie_Name]), 2);
    $CookieArray = unserialize(openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv));
    $CookieTeamNumber = $CookieArray['TeamNumber'] ?? 0;
    $CookieTeamName = $CookieArray['TeamName'] ?? "";

    // Build the login link for logoff
    $CurrentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $LoginLink = strpos($_SERVER['REQUEST_URI'], '?') !== false ? $CurrentLink . "&Logoff" : $CurrentLink . "?Logoff";

    // Remove cookie if the team number is invalid
    if ($CookieTeamNumber == 0) {
        setcookie($Cookie_Name, "", time() - 3600, "/"); // Expire the cookie
        unset($_COOKIE[$Cookie_Name]);
    }


 // decrypt cookie data and put it into a JS teamID variable.
    $encryption_key = base64_decode($CookieTeamNumberKey);
    list($encrypted_data, $iv) = explode('::', base64_decode($_COOKIE[$Cookie_Name]), 2);
    $CookieArray = unserialize(openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv));
    $CookieTeamNumber = $CookieArray['TeamNumber'] ?? 0;
    $CookieTeamName = $CookieArray['TeamName'] ?? "";
    $teamID = $CookieArray['TeamNumber'] ?? 0;    ;
}



?>
