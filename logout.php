<?php
echo 4343; exit();
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the specified URL after logout
header("Location: https://ecopackservices.com/welcome");
exit; // Make sure to exit after redirecting
?>
