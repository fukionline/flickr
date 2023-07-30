<?php
require_once("incl/func/exif.php"); 
if(isset($_GET["filename"])) {
	$pic = getPhotoInfo();
}

$pic = getPhotoInfo("dfafaf");
die($pic["orientation"]);

if($pic["orientation"] == "landscape") {
	exec("ffmpeg -i $file -vf scale=100x75 p1_t.jpg");
	exec("ffmpeg -i $file -vf scale=240x180 p1_m.jpg");
	exec("ffmpeg -i $file -vf scale=500x394 p1.jpg");
}

if($pic["orientation"] == "portrait") {
	exec("ffmpeg -i $file -vf scale=75x100 p2_t.jpg");
	exec("ffmpeg -i $file -vf scale=180x240 p2_m.jpg");
	exec("ffmpeg -i $file -vf scale=501x668 p2.jpg");
}

?>
<h1>landscape photo</h1>
<p>Thumbnail:</p> <img src="/p1.t.jpg">
<p>Medium:</p> <img src="/p1.m.jpg">
<p>Large:</p> <img src="/p1.jpg">
<hr>
<h1>portrait</h1>
<p>Thumbnail:</p> <img src="/p2.t.jpg">
<p>Medium:</p> <img src="/p2.m.jpg">
<p>Large:</p> <img src="/p2.jpg">