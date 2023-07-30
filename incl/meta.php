<?php

$page = array();

if($_SERVER["PHP_SELF"] == "/index.php") {
	$page["title"] = "Welcome to " . $website["instance_name"] . " - " . "Photo Sharing";
}

if($_SERVER["PHP_SELF"] == "/photos.php") {
	$page["title"] = $website["instance_name"] . ": " . "Photos";
}

if($_SERVER["PHP_SELF"] == "/register.php") {
	$page["title"] = $website["instance_name"] . ": " . "Register Now";
}

if($_SERVER["PHP_SELF"] == "/login.php") {
	$page["title"] = $website["instance_name"] . ": " . "Login";
}

if($_SERVER["PHP_SELF"] == "/photo.php") {
	if(isset($_GET["id"])) {
		$result = $conn->query("SELECT title FROM photos WHERE id=" . $_GET["id"]);
		if($result->num_rows == 0) {
			$page["title"] = "Flickr Photo";
		} else while($row = $result->fetch_assoc()) {
		$page["title"] = htmlspecialchars($row["title"]) . " on Flickr - Photo Sharing!";
		}
	} else {
		$page["title"] = "Flickr Photo";

	}
}

?>