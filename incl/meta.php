<?php

$page = array();

if($_SERVER["PHP_SELF"] == "/index.php") { $page["title"] = "Welcome to " . $website["instance_name"] . " - " . "Photo Sharing"; }
if($_SERVER["PHP_SELF"] == "/photos.php") { $page["title"] = $website["instance_name"] . ": " . "Photos"; }
if($_SERVER["PHP_SELF"] == "/register.php") { $page["title"] = $website["instance_name"] . ": " . "Register Now"; }
if($_SERVER["PHP_SELF"] == "/login.php") { $page["title"] = $website["instance_name"] . ": " . "Login"; }
if($_SERVER["PHP_SELF"] == "/photo.php") { $page["title"] = $website["instance_name"] . ": " . "Photo"; }
if($_SERVER["PHP_SELF"] == "/upload.php") { $page["title"] = $website["instance_name"] . ": " . "Upload"; }

?>