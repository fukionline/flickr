<?php
$title = $website["instance_name"];
if($_SERVER["PHP_SELF"] == "/index.php") { $title = "Welcome to " . $website["instance_name"] . " - " . "Photo Sharing"; }
if($_SERVER["PHP_SELF"] == "/photos.php") { $title = $website["instance_name"] . ": " . "Photos"; }
if($_SERVER["PHP_SELF"] == "/register.php") { $title = $website["instance_name"] . ": " . "Register Now"; }
if($_SERVER["PHP_SELF"] == "/login.php") { $title = $website["instance_name"] . ": " . "Login"; }
if($_SERVER["PHP_SELF"] == "/photo.php") { $title = $website["instance_name"] . ": " . "Photo"; }
if($_SERVER["PHP_SELF"] == "/upload.php") { $title = $website["instance_name"] . ": " . "Upload"; }
if($_SERVER["PHP_SELF"] == "/iconbuilder.php") { $title = $website["instance_name"] . ": " . "Buddy Icon Builder"; }
if($_SERVER["PHP_SELF"] == "/tags.php") { $title = $website["instance_name"] . ": " . "Photo Tags"; }
if($_SERVER["PHP_SELF"] == "/gallery_view.php") { $title = $website["instance_name"] . ": " . "View Gallery"; }
?>