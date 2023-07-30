<?php
session_start();
$website = array();
$database = array();
// --------------------------------------------------------
$website["sha1_salt"]	  = "thegmaniswatching";
$website["instance_name"] = "Flickr";
$website["instance_logo"] = "/images/flickr_logo_beta.gif";
$website["allowed_filetypes"] = array("png", "jpg", "bmp", "tga");
// --------------------------------------------------------
$database["ip_addr"]	= "127.0.0.1";
$database["username"]	= "root";
$database["password"]	= "";
$database["name"]		= "flickr";
// --------------------------------------------------------
$conn = new mysqli($database["ip_addr"], $database["username"], $database["password"], $database["name"]);
if ($conn->connect_error) {
	die("Conn failed. " . $conn->connect_error);
}
// --------------------------------------------------------
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/functions.php");
?>