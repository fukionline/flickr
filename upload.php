<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 
if(isset($_POST["Submit"])) {
	$title = $_POST["title"];
	// ----------------------------------------------------------------------
	if(mb_strlen($title, 'utf8') > 60) { die("photo title too long"); }
	if(mb_strlen($title, 'utf8') < 1) { die("photo title cannot be empty"); }

	if(!isset($_FILES["file"])) {
		die("no file");
	}
	// ----------------------------------------------------------------------
	$upload_extension   =  strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
	$photo_id 			= getNextID("SELECT * FROM photos", "id");
	$upload_tgt_preload = "photos/$photo_id.full.$upload_extension";
	$input 				= $upload_tgt_preload;
	$name      			= $_FILES['file']['name']; 
	$temp_name  		= $_FILES['file']['tmp_name'];
	
	if(move_uploaded_file($temp_name, $upload_tgt_preload)) {
		if(!in_array($upload_extension, $website["allowed_filetypes"])) {
			unlink($upload_tgt_preload);
			die("<p>Sorry, that filetype is not allowed</p>");
		}
	}
	// $camera = getCamera($upload_tgt_preload);
	$camera = NULL;
	exec("ffmpeg -i ".$upload_tgt_preload." -vf scale=100x75 photos/$photo_id.t.jpg");
	exec("ffmpeg -i ".$upload_tgt_preload." -vf scale=240x180 photos/$photo_id.m.jpg");
	exec("ffmpeg -i ".$upload_tgt_preload." -vf scale=500x394 photos/$photo_id.jpg");
	$stmt = $conn->prepare("INSERT INTO photos (title, camera, uploaded_by) VALUES (?, ?, ?)");
	$stmt->bind_param("ssi", $title, $camera, $user_id);
	$stmt->execute();
	header("/photos.php");
}

?>
	<h1 style="margin-bottom: 10px;">Temporary photo uploader</h1>
	<p>This is still barebones -- a better one will come soon.</p>
	<p>Currently allowed filetypes: "png", "jpg", "bmp", "tga"</p>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td class="Label">Title:</td>
				<td valign="top" class="DateTime"><input type="text" name="title" value="" size="30"><br /></td>
			</tr>
			<tr>
				<td class="Label">File:</td>
				<td valign="top" class="DateTime"><input type="file" name="file" value="" size="30"><br /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="Submit" type="submit" class="Butt" value="Upload"></td>
			</tr>
		</table>
	</form>	