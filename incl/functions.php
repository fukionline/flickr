<?php
function getCamera($photo) {
	
	// Get width and height
	list($width, $height) = getimagesize($photo);
	if ($height > $width) {
		die("Curerntly, the upload of portrait or square photos is prohibited due to website problems");
	}

      $notFound = "Unavailable";

	// Fetch EXIF data
	$exif_ifd0 = exif_read_data($photo ,'IFD0' ,0);       
	$exif_exif = exif_read_data($photo ,'EXIF' ,0);
	
	if (@array_key_exists('Make', $exif_ifd0)) {
		$cam_make = $exif_ifd0["Make"];
	} else { $cam_make = $notFound; }
	
	if (@array_key_exists('Model', $exif_ifd0)) {
		$cam_model = $exif_ifd0["Model"];
	} else { $cam_model = $notFound; }
	
	// Return array and info
	$return = $cam_make . "  " . $cam_model;
	return $return;
}

function getNextID($sql, $rowname) {
	global $conn;
	$i = 1;
	$asd = $conn->query($sql);
	if ($asd->num_rows > 0) {
		while($row = $asd->fetch_assoc()) {
			if($row["$rowname"] = $i) {
				$i++;
			}
		}
	}
return $i;
}

?>