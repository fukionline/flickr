<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/incl/header.php"); 

function clone_img_resource($img) {
    return imagecrop($img, array('x'=>0,'y'=>0,'width'=>imagesx($img),'height'=>imagesy($img)));
}

function get_aspect_ratio($width, $height) {
    $gcd = static function($width, $height) use (&$gcd) {
        return ($width % $height) ? $gcd($height, $width % $height) : $height;
    };
    $divisor = $gcd($width, $height);
    return $width / $divisor . ':' . $height / $divisor;
}

function letterbox_img($image, $background = false, $canvas_w, $canvas_h) {
    if (!$background) {
        $background = imagecolorallocate($image, 255, 255, 255);
    }
    $img_h = imagesy($image);
    $img_w = imagesx($image);
    $img = imagecreatetruecolor($canvas_w, $canvas_h);
    imagefill($img, 0, 0, $background);
    $xoffset = round(($canvas_w - $img_w) / 2);
    $yoffset = round(($canvas_h - $img_h) / 2);
    imagecopymerge($img, $image, $xoffset, $yoffset, 0,0, $img_w, $img_h, 100);
    return $img; 
}

 
function process_img($img, $width, $height, $fn) {
	$gdimage_t = clone_img_resource($img);
	$gdimage_t_as = get_aspect_ratio(imagesx($gdimage_t), imagesy($gdimage_t));
	$gdimage_t_as = explode(':', $gdimage_t_as);
	$gdimage_t_w = round($gdimage_t_as[0]*($height/$gdimage_t_as[1]));
	if ($gdimage_t_w > $width) {
		$gdimage_t_w = $width;
	}
	$gdimage_t = imagescale($gdimage_t, $gdimage_t_w, $height);
	$gdimage_t = letterbox_img($gdimage_t, false, $width, $height);
	imagejpeg($gdimage_t, $fn);
}
	

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
	$gdimage = NULL;

	switch (exif_imagetype($upload_tgt_preload)) {
		case IMAGETYPE_PNG:
			$gdimage = imagecreatefrompng($upload_tgt_preload);
			$bg = imagecreatetruecolor(imagesx($gdimage), imagesy($gdimage));
			imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
			imagealphablending($bg, TRUE);
			imagecopy($bg, $gdimage, 0, 0, 0, 0, imagesx($gdimage), imagesy($gdimage));
			imagedestroy($gdimage);
			$gdimage = $bg; 
			break;
		case IMAGETYPE_JPEG:
			$gdimage = imagecreatefromjpeg($upload_tgt_preload);
			break;
		case IMAGETYPE_BMP:
			$gdimage = imagecreatefrombmp($upload_tgt_preload);
			break;	
		default:
			if ($upload_extension == "tga") {
				$gdimage = imagecreatefromtga($upload_tgt_preload);
			} else {
				die("Unsupported format");
			}
	}
	
	process_img($gdimage, 100, 75, "photos/$photo_id.t.jpg");
	process_img($gdimage, 240, 180, "photos/$photo_id.m.jpg");
	imagejpeg(imagescale($gdimage, 500), "photos/$photo_id.jpg");
	
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
