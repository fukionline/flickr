<?php
session_start();
$website = array();
$database = array();
// --------------------------------------------------------
$website["sha1_salt"]	  = "thegmaniswatching";
$website["instance_name"] = "Flickr";
$website["instance_logo"] = "/images/flickr_logo_beta.gif";
$website["allowed_filetypes"] = array("png", "jpg", "bmp", "tga");
$website["developer_team"] = array(1, 2); // A list of developers to put on the logged in homepage
// --------------------------------------------------------
$database["ip_addr"]	= "127.0.0.1";
$database["username"]	= "root";
$database["password"]	= "";
$database["name"]		= "flickr";
// --------------------------------------------------------
try {
	$conn = new PDO("mysql:host=". $database["ip_addr"] . ";dbname=". $database["name"] . "", $database["username"], $database["password"]);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
// --------------------------------------------------------
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/functions.php");
?>